<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\AddRequest;
use App\Http\Requests\ListRequest;
use App\Http\Resources\Resource;
use App\Services\Department\DepartmentService;
use App\Services\Role\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        protected DepartmentService $service,
        protected PermissionService $permissionService
    )
    {
    }

    public function index(ListRequest $request): Resource
    {
        $this->permissionService->hasPermission('department.list');
        $data = $this->service->list($request->validated());
        return new Resource($data);
    }

    public function show(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('department.show');
        $data = $this->service->show($id);
        return success($data);
    }

    public function store(AddRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('department.add');
        $this->service->add($request->validated());
        return success();
    }

    public function update(int $id, AddRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('department.update');
        $this->service->update($id, $request->validated());
        return success();
    }

    public function destroy(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('department.delete');
        $this->service->delete($id);
        return success();
    }
}
