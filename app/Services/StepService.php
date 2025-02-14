<?php

namespace App\Services;

use App\Enums\AppStepEnum;
use App\Enums\StatusEnum;
use App\Models\Application;
use App\Models\ApplicationStep;
use App\Models\ApplicationUpload;
use App\Models\User;
use App\Services\Role\PermissionService;

class StepService
{

    public function checkAppStep(Application $application, ApplicationStep $step): bool
    {
        $appStep = ApplicationStep::query()->where('step_number', $application->step_number)->pluck('key')->first();
        $targets = json_decode($step->targets, true);

        if (!is_null($targets) && !in_array($appStep, $targets)) {
            throwError('Ushbu qadamga o\'tkazish mumkin emas!');
        }
        return true;
    }

    public function storeAppStep(Application $application, AppStepEnum $step, string $comment = null): void
    {
        $application->update(['step_number' => $step]);
        $application->history()->create(['step_number' => $step, 'user_id' => auth()->id(), 'comment' => $comment]);
    }

    public function changeAppToInView(Application $application): void
    {
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::IN_VIEW)->first();
        $this->checkAppStep($application, $step);
        $this->storeAppStep($application, AppStepEnum::IN_VIEW);
    }

    public function changeAppToRejected(Application $application, string $comment = null): void
    {
        (new CheckService())->checkForHR(auth()->user());
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::REJECTED)->first();
        $this->checkAppStep($application, $step);
        $this->storeAppStep($application, AppStepEnum::REJECTED, $comment);
    }

    public function changeAppToReadyToSign(Application $application): void
    {
        (new CheckService())->checkForHR(auth()->user());
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::READY_TO_SIGN)->first();
        $this->checkAppStep($application, $step);
        $this->storeAppStep($application, AppStepEnum::READY_TO_SIGN);
    }

    public function changeAppToPendingApproval(Application $application): void
    {
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::PENDING_APPROVAL)->first();
        $this->checkAppStep($application, $step);
        $this->storeAppStep($application, AppStepEnum::PENDING_APPROVAL);
    }

    public function changeAppToDocsSentEmail(Application $application): void
    {
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::DOCS_ACCEPTED)->first();
        $this->checkAppStep($application, $step);
        $this->storeAppStep($application, AppStepEnum::DOCS_ACCEPTED);
    }

    public function changeAppToDocsReceived(Application $application): void
    {
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::DOCS_SEND_EMAIL)->first();
        $this->checkAppStep($application, $step);
        $this->storeAppStep($application, AppStepEnum::DOCS_SEND_EMAIL);
    }

    public function changeAppToSentWorkload(Application $application): void
    {
        (new PermissionService())->hasPermission('application.prepare_debt_sheet');
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::SENT_TO_WORKLOAD)->first();
        $this->checkAppStep($application, $step);
        $this->storeAppStep($application, AppStepEnum::SENT_TO_WORKLOAD);
    }

    public function changeAppToPendingSign(Application $application): void
    {
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::PENDING_TO_SIGN)->first();
        $this->checkAppStep($application, $step);

        if ($application->workloads()->where('status_id', StatusEnum::NOT_SIGNED)->count() > 0) {
            throwError(__('app.all_apps_must_be_signed'));
        }

        if ($application->uploads()->where('type', 'workload')->doesntExist()) {
            throwError(__('app.workload_not_uploaded'));
        }

        $this->storeAppStep($application, AppStepEnum::PENDING_TO_SIGN);
    }

    public function changeAppToForJamshidAka(Application $application): void
    {
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::FOR_JAMSHID_AKA)->first();
        $this->checkAppStep($application, $step);
        $this->storeAppStep($application, AppStepEnum::FOR_JAMSHID_AKA);
    }

    public function changeAppToFinalApproval(Application $application): void
    {
        (new PermissionService())->hasPermission('application.final_approval');
        $step = ApplicationStep::query()->where('step_number', AppStepEnum::FINAL_APPROVAL)->first();
        $this->checkAppStep($application, $step);
        $this->storeAppStep($application, AppStepEnum::FINAL_APPROVAL);
        $application->update(['status' => StatusEnum::INACTIVE]);
        $user = $application->app_user ?? $application->user;

        if ($application->type_id === StatusEnum::HIRE->value) {
            $avatar = ApplicationUpload::query()
                ->where('application_id', $application->id)
                ->where('type', 'avatar')
                ->first();

            $user = User::query()->updateOrCreate(
                ['pinfl' => $user->pinfl],
                [
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'patronymic' => $user->patronymic,
                    'phone' => $user->phone,
                    'pinfl' => $user->pinfl,
                    'hire_date' => $application->hire_date,
                    'birth_date' => $application->form->personalData->birth_date ?? null,
                    'position_id' => $user->position_id ?? null,
                    'avatar_id' => $avatar->upload_id ?? null,
                    'role_id' => 2,
                    'branch_id' => $user->branch_id,
                    'password' => 123456
                ]
            );

            $application->update(['user_id' => $user->id]);
            $application->app_user->delete();
        } else if ($application->type_id === StatusEnum::FIRE->value) {
            $user->update(['status' => 0]);
        }
    }
}
