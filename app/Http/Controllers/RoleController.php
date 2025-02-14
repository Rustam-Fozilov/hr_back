<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use App\Http\Requests\Role\AddRequest;
use App\Services\Role\PermissionService;
use App\Services\Role\RoleService;
use Illuminate\Http\JsonResponse;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $service,
        protected PermissionService $permissionService,
    )
    {
    }

    public function list(ListRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('role.list');
        $list = $this->service->list($request->validated());
        return success($list);
    }

    public function show(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('role.show');
        $data = $this->service->show($id);
        return success($data);
    }

    public function add(AddRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('role.add');
        $this->service->add($request->validated());
        return success();
    }

    public function update(int $id, AddRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('role.update');
        $this->service->update($id, $request->validated());
        return success();
    }

    public function delete(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('role.delete');
        $this->service->dis_active($id);
        return success();
    }
}
