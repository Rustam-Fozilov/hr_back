<?php

namespace App\Services\Application;

use App\Enums\AppStepEnum;
use App\Enums\StatusEnum;
use App\Jobs\SendInternUserJob;
use App\Models\Application;
use App\Models\ApplicationUpload;
use App\Models\ApplicationUser;
use App\Models\ApplicationWorkload;
use App\Models\Department;
use App\Models\Form;
use App\Services\CheckService;
use App\Services\FileService;
use App\Services\Form\FormService;
use App\Services\Role\RolePermService;
use App\Services\StepService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\DB;

class ApplicationService
{
    public function list(array $data)
    {
        $fire_count = Application::query()->where('type_id', StatusEnum::FIRE)->count();
        $hire_count = Application::query()->where('type_id', StatusEnum::HIRE)->count();

        $list = Application::with(['user.branch.region', 'app_user.branch.region', 'type'])
            ->when(isset($data['search']), function ($query) use ($data) {
                $query->whereRelation('user', 'name', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('user', 'surname', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('user', 'patronymic', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('user', 'phone', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('user', 'pinfl', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('app_user', 'name', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('app_user', 'surname', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('app_user', 'patronymic', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('app_user', 'phone', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('app_user', 'pinfl', 'like', '%' . $data['search'] . '%');
            })
            ->when(isset($data['steps']) && count($data['steps']) > 0, function ($query) use ($data) {
                $query->whereIn('step_number', $data['steps']);
            })
            ->when(isset($data['branch_id']), function ($query) use ($data) {
                $query->where(function ($query) use ($data) {
                    $query
                        ->whereRelation('user', 'branch_id', $data['branch_id'])
                        ->orWhereRelation('app_user', 'branch_id', $data['branch_id']);
                });
            })
            ->when(isset($data['region_id']), function ($query) use ($data) {
                $query->where(function ($query) use ($data) {
                    $query
                        ->whereRelation('user.branch', 'region_id', $data['region_id'])
                        ->orWhereRelation('app_user.branch', 'region_id', $data['region_id']);
                });
            })
            ->when(isset($data['type_id']), function ($query) use ($data) {
                $query->where('type_id', $data['type_id']);
            })
            ->selectRaw('applications.*')
            ->orderByDesc('id');

        if (auth()->user()->role_id !== 1) {
            $perm = (new RolePermService())->getAllow(auth()->user()->role_id, 'application.list');

            if ($perm === 'own') {
                if (auth()->user()->role_id == 3) {
                    $list->whereRelation('workloads.department', 'director_id', auth()->id())->orWhere('owner_id', auth()->id());
                } else {
                    $list
                        ->where(function ($query) {
                            $query->whereHas('app_user', function ($query) {
                                $query->whereIn('branch_id', auth()->user()->branches->pluck('id'));
                            })
                            ->orWhere('owner_id', auth()->id());
                        });
                }
            }
        }

        $pag = $list->paginate($data['per_page'] ?? 15);
        $pag->getCollection()->transform(function ($app) use ($hire_count, $fire_count) {
            if (is_null($app->user_id)) {
                unset($app->user);
                $app->hire_count = $hire_count;
                $app->fire_count = $fire_count;
                $app->user = $app->app_user;
            }
            return $app;
        });

        return $pag;
    }

    public function checkById(int $id)
    {
        return (new CheckService())->checkById(Application::query(), $id, 'Application not found', true);
    }

    public function show(int $id)
    {
        $app = Application::with(['user.branch', 'user.position', 'app_user.branch', 'app_user.position', 'uploads', 'workloads.department.director', 'type', 'form', 'history.user', 'owner'])->find($id);
        $history = $app->history->whereNotNull('comment')->where('step_number', $app->step_number)->last();

        if (!is_null($history)) {
            $app->comment = $history->comment;
        }

        if (is_null($app->user)) {
            unset($app->user);
            $app->user = $app->app_user;
        }

        return $app;
    }

    public function add(array $data, AppStepEnum $step = AppStepEnum::SAVED)
    {
        DB::beginTransaction();

        try {
            if (checkPinflNumber($data['pinfl']) === false) throwError('Pinfl raqam noto`g`ri');

            if ($data['has_app'] == 1) {
                $app = $this->checkById($data['id']);
                $app->app_user->update($data);
                $app->update($data);
            } else {
                (new CheckService())->checkWithoutKeyValue(ApplicationUser::query(), 'pinfl', $data['pinfl'], __('app.exists'));
                $app = $this->createHire(data: $data);
                $app->app_user()->create($data);
                $app->form()->save(Form::query()->find($data['form_id']));
            }

            $this->createFiles($app, $data);
            $this->addConfirmUploads($app, $data);
            (new StepService())->storeAppStep($app, $step);

            DB::commit();
            return $app;
        } catch(\HttpResponseException $e) {
            throwError($e->getMessage());
        }
        return null;
    }

    public function createHire($step_number = AppStepEnum::SAVED, $data = null): Application
    {
        $app = new Application();
        $app->type_id = StatusEnum::HIRE;
        $app->step_number = $step_number;
        $app->status = StatusEnum::ACTIVE;
        $app->hire_date = $data['hire_date'] ?? null;
        $app->contract_duration = $data['contract_duration'] ?? null;
        $app->intern_duration = $data['intern_duration'] ?? false;
        $app->owner_id = auth()->id();
        $app->save();
        return $app;
    }

    public function addFire(array $data, AppStepEnum $step = AppStepEnum::SAVED)
    {
        DB::beginTransaction();

        try {
            $user = (new UserService())->checkById($data['user_id']);

            if ($data['has_app'] === 1) {
                $app = $this->checkById($data['id']);
                $app->update($data);
            } else {
                (new CheckService())->checkWithoutKeyValue(Application::query(), 'user_id', $user->id, __('app.exists'), true);
                $data['user_id'] = $user->id;
                $app = $this->createFire($data);
            }

            if (isset($data['workloads'])) $this->createWorkLoads($app, $data['workloads'], $data['workload_type']);
            $this->createFiles($app, $data);
            (new StepService())->storeAppStep($app, $step);

            DB::commit();
            return $app;
        } catch(\HttpResponseException $e) {
            throwError($e->getMessage());
        }
        return null;
    }

    public function createFire(array $data, $step_number = AppStepEnum::SAVED)
    {
        return Application::query()->create([
            'user_id' => $data['user_id'],
            'type_id' => StatusEnum::FIRE,
            'step_number' => $step_number,
            'status' => StatusEnum::ACTIVE,
            'workload_type' => $data['workload_type'],
            'fire_date' => $data['fire_date'],
            'fire_reason' => $data['fire_reason'],
            'app_fire_date' => $data['app_fire_date'],
            'owner_id' => auth()->id(),
        ]);
    }

    public function addIntern(array $data)
    {
        (new CheckService())->checkWithoutKeyValue(ApplicationUser::query(), 'pinfl', $data['pinfl'], __('app.exists'));
        $app = Application::query()->create(['type_id' => StatusEnum::INTERN]);
        $app->app_user()->create($data);
        dispatch(new SendInternUserJob($data));
        return $app;
    }

    public function changeStep(int $has_app, int $step_number, array $data): void
    {
        DB::beginTransaction();
        try {
            $stepService = new StepService();
            $data['has_app'] = $has_app;
            $app = $has_app == 1 ? $this->checkById($data['app_id']) : $this->add($data);
            unset($data['step_number']);

            if ($has_app == 1) {
                $this->createFiles($app, $data);
                $this->addConfirmUploads($app, $data);
            }

            switch ($step_number) {
                case AppStepEnum::IN_VIEW->value:
                    $forms = $app->form()->with(['personal_data', 'relative_data', 'degree_data', 'work_experience_data'])->first();
                    $validate = (new FormService())->validateForm($forms->toArray());
                    if (!$validate) break;

                    $app->update($data);
                    $app->app_user->update($data);

                    $stepService->changeAppToInView($app);
                    break;
                case AppStepEnum::REJECTED->value:
                    $stepService->changeAppToRejected($app, $data['comment'] ?? null);
                    break;
                case AppStepEnum::READY_TO_SIGN->value:
                    if (isset($data['contract_duration']) || isset($data['intern_duration'])) {
                        $app->update([
                            'contract_duration' => $data['contract_duration'] ?? null,
                            'intern_duration' => $data['intern_duration'] ?? false
                        ]);
                    }
                    $stepService->changeAppToReadyToSign($app);
                    break;
                case AppStepEnum::PENDING_APPROVAL->value:
                    $this->checkHireConfirmUploads($data);
                    $stepService->changeAppToPendingApproval($app);
                    break;
                case AppStepEnum::DOCS_ACCEPTED->value:
                    $stepService->changeAppToDocsSentEmail($app);
                    break;
                case AppStepEnum::DOCS_SEND_EMAIL->value:
                    $stepService->changeAppToDocsReceived($app);
                    break;
                case AppStepEnum::FOR_JAMSHID_AKA->value:
                    $stepService->changeAppToForJamshidAka($app);
                    break;
                case AppStepEnum::FINAL_APPROVAL->value:
                    $stepService->changeAppToFinalApproval($app);
                    break;
                default:
                    throwError('Invalid step number');
            }
            DB::commit();
        } catch (\HttpResponseException $e) {
            throwError($e->getMessage());
        }
    }

    public function undoStep(int $app_id, array $data): void
    {
        $app = $this->checkById($app_id);

        switch ($app->step_number) {
            case AppStepEnum::IN_VIEW->value:
                $app->workloads()->update(['status_id' => StatusEnum::NOT_SIGNED]);
                (new StepService())->storeAppStep($app, AppStepEnum::SAVED);
                break;
            case AppStepEnum::PENDING_APPROVAL->value:
                (new StepService())->storeAppStep($app, AppStepEnum::READY_TO_SIGN, $data['comment'] ?? null);
                break;
        }
    }

    public function changeFireStep(array $data): void
    {
        DB::beginTransaction();
        try {
            $stepService = new StepService();
            $app = $data['has_app'] == 1 ? $this->checkById($data['app_id']) : $this->addFire($data);

            if ($data['has_app'] == 1) {
                $this->createFiles($app, $data);
            }

            switch ($data['step_number']) {
                case AppStepEnum::IN_VIEW->value:
                    if (!isset($data['declaration_upload_id'])) throwError(__('app.declaration_required'));
                    $app->update($data);
                    $stepService->changeAppToInView($app);
                    break;
                case AppStepEnum::REJECTED->value:
                    $stepService->changeAppToRejected($app, $data['comment'] ?? null);
                    break;
                case AppStepEnum::SENT_TO_WORKLOAD->value:
                    if (!isset($data['declaration_upload_id'])) throwError(__('app.declaration_required'));
                    $app->update($data);
                    $stepService->changeAppToSentWorkload($app);
                    break;
                case AppStepEnum::PENDING_TO_SIGN->value:
                    $stepService->changeAppToPendingSign($app);
                    break;
                case AppStepEnum::FOR_JAMSHID_AKA->value:
                    $stepService->changeAppToForJamshidAka($app);
                    break;
                case AppStepEnum::FINAL_APPROVAL->value:
                    $stepService->changeAppToFinalApproval($app);
                    break;
                default:
                    throwError('Invalid step number');
            }
            DB::commit();
        } catch (\HttpResponseException $e) {
            DB::rollBack();
            throwError($e->getMessage());
        }
    }

    public function addConfirmUploads(Application $app, array $data): void
    {
        foreach ($data as $key => $uploadIds) {
            if (str_ends_with($key, '_confirm_ids') && is_array($uploadIds) && count($uploadIds) > 0) {
                $type = str_replace('_ids', '', $key);
                ApplicationUpload::query()->where('application_id', $app->id)->where('type', $type)->delete();

                foreach ($uploadIds as $uploadId) {
                    ApplicationUpload::query()->create([
                        'application_id' => $app->id,
                        'upload_id' => $uploadId,
                        'type' => $type,
                    ]);
                }
            }
        }
    }

    public function createFiles(Application $app, array $uploadData): void
    {
        $filtered = collect($uploadData)->filter(function ($value, $key) {
            return str_ends_with($key, '_upload_id') && !is_null($value);
        })->mapWithKeys(function ($value, $key) {
            return [str_replace('_upload_id', '', $key) => $value];
        });

        foreach ($filtered as $type => $uploadId) {
            $upload = $app->uploads()->where('application_uploads.type', $type);

            if (!$upload->exists()) {
                ApplicationUpload::query()->create([
                    'application_id' => $app->id,
                    'upload_id' => $uploadId,
                    'type' => $type,
                ]);
            } else {
                $upload->update(['upload_id' => $uploadId]);
            }
        }
    }

    public function createWorkLoads(Application $app, array $workloads, int $workload_type): void
    {
        $app->workloads()->delete();
        foreach ($workloads as $workload) {
            $app->workloads()->create(['department_id' => $workload, 'workload_type' => $workload_type]);
        }
    }

    public function checkHireConfirmUploads(array $data): void
    {
        $requiredFields = ['nda_confirm_ids', 'trudovoy_confirm_ids', 'mat_confirm_ids', 'prikaz_priyom_confirm_ids', 'position_confirm_ids'];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) throwError(__('app.all_signed_files_required'));
        }
    }

    public function sign(int $app_id): void
    {
        $departments = Department::query()
            ->where('director_id', auth()->id())
            ->pluck('id');

        $app = ApplicationWorkload::query()
            ->where('application_id', $app_id)
            ->whereIn('department_id', $departments)
            ->where('status_id', StatusEnum::NOT_SIGNED);

        if (count($app->get()) === 0) throwError(__('app.already_signed'));
        $app->update(['status_id' => StatusEnum::SIGNED]);
    }

    public function delete(int $id): void
    {
        $app = $this->checkById($id);
        $this->clearAppCache($app);
        $app->delete();
    }

    public function clearAppCache(Application $app): void
    {
        $app->history()->delete();
        $app->workloads()->delete();
        $app->form()->delete();
        $app->app_user()->delete();

        ApplicationUpload::query()->where('application_id', $app->id)->delete();
    }

    public function nextApp(int $app_id)
    {
        $this->checkById($app_id);
        return Application::with(['user.branch', 'type', 'uploads', 'workloads.department.director'])
            ->where('id', '>', $app_id)
            ->active()
            ->first();
    }

    public function downloadPositionDocs(int $app_id)
    {
        return FileService::downloadPositionDocs($app_id);
    }

    public function downloadHireDocs(string $type, array $data)
    {
        return FileService::downloadHireDocs($type, $data);
    }

    public function uploadSignDocs(int $app_id, int $upload_id): void
    {
        $app = $this->checkById($app_id);
        ApplicationUpload::query()->where('application_id', $app->id)->updateOrCreate(['type' => 'workload', 'application_id' => $app->id], ['upload_id' => $upload_id]);
        $app->workloads()->update(['status_id' => StatusEnum::SIGNED, 'signed_at' => now()]);
    }
}
