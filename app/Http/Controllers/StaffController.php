<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use App\Http\Requests\Staff\AddRequest;
use App\Http\Resources\Resource;
use App\Services\Role\PermissionService;
use App\Services\User\StaffService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct(
        protected StaffService $service,
        protected PermissionService $permissionService,
    )
    {
    }

    public function index(ListRequest $request): Resource
    {
        $this->permissionService->hasPermission('staff.list');
        $data = $this->service->list($request->all());
        return new Resource($data);
    }

    public function show(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('staff.show');
        $data = $this->service->getById($id);
        return success($data);
    }

    public function store(AddRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('staff.add');
        $this->service->add($request->validated());
        return success();
    }

    public function update(int $id, AddRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('staff.update');
        $this->service->update($id, $request->validated());
        return success();
    }

    public function delete(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('staff.delete');
        $this->service->delete($id);
        return success();
    }
}
