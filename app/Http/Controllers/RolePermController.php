<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\AddRolePermRequest;
use App\Services\Role\PermissionService;
use App\Services\Role\RolePermService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RolePermController extends Controller
{
    public function __construct(
        protected RolePermService $service,
        protected PermissionService $permissionService
    )
    {
    }

    public function getByRole(int $role_id): JsonResponse
    {
        $this->permissionService->hasPermission('rolePerm.getByRole');
        $data = $this->service->getByRole($role_id);
        return success($data);
    }

    public function getUserPermission(): JsonResponse
    {
        $user = auth()->user();
        $data = $this->service->getByRole($user->role_id);
        return success($data);
    }

    public function getByPermission(int $perm_id): JsonResponse
    {
        $this->permissionService->hasPermission('rolePerm.getByPermission');
        $data = $this->service->getByPermission($perm_id);
        return success($data);
    }

    public function update(AddRolePermRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('rolePerm.update');
        $this->service->update($request->validated()['data']);
        return success();
    }
}
