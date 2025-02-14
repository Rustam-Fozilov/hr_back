<?php

namespace App\Services\Role;

use App\Models\Role\Role;
use App\Services\CheckService;
use Illuminate\Database\Eloquent\Collection;

class RoleService
{
    public function getAll(): Collection
    {
        return Role::query()->active()->get();
    }

    public function list($data)
    {
        return Role::with('users')
            ->when(isset($data['search']), function ($query) use ($data) {
                $query->where('name', 'like', '%' . $data['search'] . '%');
            })
            ->active()
            ->get();
    }

    public function checkById($id)
    {
        return (new CheckService())->checkById(Role::query(), $id, 'Role not found', true);
    }

    public function checkWithoutName($name)
    {
        return (new CheckService())->checkWithoutKeyValue(Role::query(), 'name', $name, 'Role already exists', true);
    }

    public function show(int $id)
    {
        return $this->checkById($id);
    }

    public function add(array $data): void
    {
        $this->checkWithoutName($data['name']);
        $role = Role::query()->create($data);
        (new RolePermService())->addByRole($role->id);
    }

    public function update(int $id, array $data): void
    {
        $this->checkById($id);
        Role::query()->find($id)->update($data);
    }

    public function dis_active(int $id): void
    {
        $this->checkById($id);
        (new RolePermService())->deleteByRole($id);
        Role::query()->find($id)->update(['status' => 0]);
    }
}
