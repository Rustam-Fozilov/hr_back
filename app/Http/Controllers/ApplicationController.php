<?php

namespace App\Http\Controllers;

use App\Http\Requests\Application\AddFireRequest;
use App\Http\Requests\Application\AddInternRequest;
use App\Http\Requests\Application\AddRequest;
use App\Http\Requests\Application\AppListRequest;
use App\Http\Requests\Application\ChangeFireAppStepRequest;
use App\Http\Requests\Application\UploadSignDocs;
use App\Http\Requests\ChangeAppStepRequest;
use App\Http\Resources\Resource;
use App\Services\Application\ApplicationService;
use App\Services\Role\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function __construct(
        protected ApplicationService $service,
        protected PermissionService $permissionService,
    )
    {
    }

    public function index(AppListRequest $request): Resource
    {
        $this->permissionService->hasPermission('application.list');
        $data = $this->service->list($request->validated());
        return new Resource($data);
    }

    public function show(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('application.show');
        $data = $this->service->show($id);
        return success($data);
    }

    public function store(AddRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('application.add');
        $this->service->add($request->validated());
        return success();
    }

    public function storeFire(AddFireRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('application.add');
        $this->service->addFire($request->validated());
        return success();
    }

    public function storeIntern(AddInternRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('application.add');
        $this->service->addIntern($request->validated());
        return success();
    }

    public function delete(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('application.delete');
        $this->service->delete($id);
        return success();
    }

    public function changeHireStep(ChangeAppStepRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('application.change_step');
        $this->service->changeStep($request['has_app'], $request['step_number'], $request->validated());
        return success();
    }

    public function undoStep(int $app_id, Request $request): JsonResponse
    {
        $this->permissionService->hasPermission('application.change_step');
        $this->service->undoStep($app_id, $request->all());
        return success();
    }

    public function changeFireStep(ChangeFireAppStepRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('application.change_step');
        $this->service->changeFireStep($request->validated());
        return success();
    }

    public function sign(int $app_id): JsonResponse
    {
        $this->permissionService->hasPermission('application.sign');
        $this->service->sign($app_id);
        return success();
    }

    public function nextApp(int $app_id): JsonResponse
    {
        $app = $this->service->nextApp($app_id);
        return success($app);
    }

    public function downloadPositionDocs(int $app_id)
    {
        return $this->service->downloadPositionDocs($app_id);
    }

    public function downloadDocs(string $type, Request $request)
    {
        return $this->service->downloadHireDocs($type, $request->all());
    }

    public function uploadSignDocs(UploadSignDocs $request): JsonResponse
    {
        $this->service->uploadSignDocs($request['app_id'], $request['upload_id']);
        return success();
    }
}
