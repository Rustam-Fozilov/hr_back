<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListRequest;
use App\Http\Requests\Permission\AddRequest;
use App\Services\Role\PermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionService $service
    )
    {
    }

    public function list(ListRequest $request): JsonResponse
    {
        $this->service->hasPermission('permission.list');
        $list = $this->service->list($request->validated());
        return success($list);
    }

    public function show(int $id): JsonResponse
    {
        $this->service->hasPermission('permission.show');
        $data = $this->service->show($id);
        return success($data);
    }

    public function add(AddRequest $request): JsonResponse
    {
        $this->service->hasPermission('permission.add');
        $this->service->add($request->validated());
        return success();
    }

    public function update(int $id, AddRequest $request): JsonResponse
    {
        $this->service->hasPermission('permission.update');
        $this->service->update($id, $request->validated());
        return success();
    }

    public function delete(int $id): JsonResponse
    {
        $this->service->hasPermission('permission.delete');
        $this->service->dis_active($id);
        return success();
    }
}
