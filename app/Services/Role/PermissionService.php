<?php

namespace App\Services\Role;

use App\Models\Role\Permission;
use App\Models\Role\RolePerm;
use App\Services\CheckService;
use Illuminate\Database\Eloquent\Collection;

class PermissionService
{
    public function list(array $data): Collection
    {
        return Permission::query()
            ->when(isset($data['search']), function ($query) use ($data) {
                $query->where('title', 'like', '%' . $data['search'] . '%');
            })
            ->get();
    }

    public function show(int $id): Permission
    {
        return $this->checkById($id);
    }

    public function add(array $data): void
    {
        $this->checkWithoutKey($data['key']);

        if (isset($data['parent_id'])){
            $this->checkById($data['parent_id']);
        }

        $data['options'] = json_encode($data['options']);
        $perm = Permission::query()->create($data);
        (new RolePermService)->addByPerm($perm);
    }

    public function isAllow($key, $value, $redirect = false): bool|string
    {
        $user = auth()->user();
        if ($user->is_admin) return 'admin';

        $allow = (new RolePermService)->getAllow($user->role_id, $key);
        if ($allow == $value) return true;

        if ($redirect) $this->forbidden($key);
        return false;
    }

    public function hasPermission($key, $redirect = true): bool
    {
        $user = auth()->user();
        if ($user->is_admin) return true;

        $allow = (new RolePermService)->getAllow($user->role_id, $key);
        if ($allow != 0) return true;

        if ($redirect) $this->forbidden($key);
        return false;
    }

    public function forbidden($key = false): void
    {
        if ($key) {
            $permission = $this->getByKey($key);

            if ($permission) {
                $message = __('errors.forbidden_role', ['role' => $permission->title]);
            } else {
                $message = __('errors.role_not_found', ['role' => $key]);
            }
        } else {
            $message = __('errors.forbidden');
        }

        throwError($message, 403);
    }

    public function getByKey(string $key)
    {
        return (new CheckService())->checkByKeyValue(Permission::query(), 'key', $key, 'Permission not found');
    }

    public function checkWithoutKey(string $key)
    {
        return (new CheckService())->checkWithoutKeyValue(Permission::query(), 'key', $key, 'Permission already exists');
    }

    public function checkById(int $id)
    {
        return (new CheckService())->checkById(Permission::query(), $id, 'Permission not found');
    }

    public function getAll(): Collection
    {
        return Permission::all();
    }

    public function update(int $id, array $data): void
    {
        $this->checkById($id);
        if (isset($data['parent_id'])){
            $this->checkById($data['parent_id']);
        }

        RolePerm::query()->where('permission_id', $id)->update(['key' => $data['key']]);
        Permission::query()->find($id)->update($data);
    }

    public function dis_active(int $id): void
    {
        $this->checkById($id);
        (new RolePermService())->deleteByPerm($id);

        Permission::query()->find($id)->delete();
    }
}
