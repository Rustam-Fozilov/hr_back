<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddRequest;
use App\Http\Requests\User\EditRequest;
use App\Http\Requests\User\ListRequest;
use App\Http\Requests\User\UpdatePasswordRequest;
use App\Http\Resources\Resource;
use App\Services\Role\PermissionService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $service,
        protected PermissionService $permissionService
    )
    {
    }

    public function list(ListRequest $request): Resource
    {
        $this->permissionService->hasPermission('user.list');
        $list = $this->service->list($request->validated());
        return new Resource($list, $request->validated());
    }

    public function add(AddRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('user.add');
        $this->service->add($request->validated());
        return success();
    }

    public function show(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('user.show');
        $data = $this->service->show($id);
        return success($data);
    }

    public function getByPinfl(string $pinfl): JsonResponse
    {
        $data = $this->service->getByPinfl($pinfl);
        return success($data);
    }

    public function me(): JsonResponse
    {
        $data = $this->service->me();
        return success($data);
    }

    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $this->service->updatePassword($request->validated());
        return success();
    }

    public function update(int $id, EditRequest $request): JsonResponse
    {
        $this->permissionService->hasPermission('user.update');
        $this->service->edit($id, $request->validated());
        return success();
    }

    public function delete(int $id): JsonResponse
    {
        $this->permissionService->hasPermission('user.delete');
        $this->service->delete($id);
        return success();
    }
}
