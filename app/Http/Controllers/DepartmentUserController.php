<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentUser\AddRequest;
use App\Http\Resources\Resource;
use App\Services\Department\DepartmentUserService;
use App\Services\Role\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentUserController extends Controller
{
    public function __construct(
        protected DepartmentUserService $service,
        protected PermissionService $permissionService,
    )
    {
    }

    public function index(int $department_id, Request $request): Resource
    {
        $this->permissionService->hasPermission('department_user.list');
        $data = $this->service->list($department_id, $request->all());
        return new Resource($data);
    }

    public function store(int $departmentId, AddRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('department_user.add');
        $this->service->add($departmentId, $request->validated());
        return success();
    }

    public function destroy(int $departmentId, int $userId): JsonResponse
    {
        $this->permissionService->hasPermission('department_user.delete');
        $this->service->delete($departmentId, $userId);
        return success();
    }
}
