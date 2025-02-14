<?php

namespace App\Services\Role;

use App\Models\Role\Permission;
use App\Models\Role\RolePerm;

class RolePermService
{
    public function getAllow($role_id, $key)
    {
        $rolePerm = RolePerm::query()
            ->where([
                ['role_id', $role_id],
                ['key', $key]
            ])
            ->first();

        if (!$rolePerm) {
            $permission = (new PermissionService())->getByKey($key);
            $rolePerm = $this->addRolePerm($role_id, $permission->toArray());
        }

        return $rolePerm->value;
    }

    public function getByRole(int $role_id): array
    {
        $data['list'] = RolePerm::query()
            ->where('role_id', $role_id)
            ->with(['permission'])
            ->get();

        $data['role'] = (new RoleService())->show($role_id);
        return $data;
    }

    public function getByPermission(int $perm_id): array
    {
        $data['list'] = RolePerm::query()
            ->where('permission_id', $perm_id)
            ->with(['role'])
            ->get();

        $data['permission'] = (new PermissionService())->show($perm_id);
        return $data;
    }

    public function addRolePerm(int $role_id, array $permission): RolePerm
    {
        $data['role_id'] = $role_id;
        $data['permission_id'] = $permission['id'];
        $data['key'] = $permission['key'];
        $data['value'] = 0;

        return RolePerm::query()->create($data);
    }

    public function addByPerm(Permission $permission): void
    {
        $roles = (new RoleService())->getAll();
        foreach ($roles as $role)
        {
            $this->addRolePerm($role->id, $permission->toArray());
        }
    }

    public function addByRole($role_id): void
    {
        (new RoleService())->checkById($role_id);
        $permissions = (new PermissionService())->getAll();

        foreach ($permissions as $permission)
        {
            $this->addRolePerm($role_id, $permission->toArray());
        }
    }

    public function update($rolePerms): void
    {
        foreach ($rolePerms as $rolePerm)
        {
            (new RoleService())->checkById($rolePerm['role_id']);
            $data['role_id'] = $rolePerm['role_id'];
            $data['perm_id'] = $rolePerm['permission_id'];
            $data['value'] = $rolePerm['value'];
            $data['key'] = $rolePerm['permission']['key'] ?? null;

            $updateData = [
                'value' => $data['value']
            ];
            if (!is_null($data['key'])) $updateData['key'] = $data['key'];

            RolePerm::query()
                ->where([
                    ['role_id', $data['role_id']],
                    ['permission_id', $data['perm_id']]
                ])
                ->update($updateData);
        }
    }

    public function deleteByRole(int $role_id): void
    {
        RolePerm::query()->where('role_id', $role_id)->delete();
    }

    public function deleteByPerm(int $perm_id): void
    {
        RolePerm::query()->where('permission_id', $perm_id)->delete();
    }
}
