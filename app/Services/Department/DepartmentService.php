<?php

namespace App\Services\Department;

use App\Models\Department;
use App\Services\CheckService;
use App\Services\Role\RolePermService;

class DepartmentService
{
    public function list(array $data)
    {
        $query = Department::with(['users', 'director'])
            ->when(isset($data['search']), function ($query) use ($data) {
                $query->where(function ($query) use ($data) {
                    $query->where('name', 'like', '%' . translit($data['search'])['lat'] . '%')
                        ->orWhere('name', 'like', '%' . translit($data['search'])['cyr'] . '%');
                });
            })
            ->orderByDesc('id');

        if (auth()->user()->role_id !== 1) {
            $perm = (new RolePermService())->getAllow(auth()->user()->role_id, 'department.list');
            if ($perm === 'own') {
                $query->where(function ($query) {
                    $query
                        ->where('director_id', auth()->id())
                        ->orWhereHas('users', function ($query) {
                            $query->where('user_id', auth()->id())->where('role_id', 3);
                        });
                });
            }
        }

        return $query->paginate($data['per_page'] ?? 15);
    }

    public function checkById(int $id)
    {
        return (new CheckService())->checkById(Department::with(['director', 'users']), $id, 'Department not found');
    }

    public function show(int $id)
    {
        return $this->checkById($id);
    }

    public function add(array $data)
    {
        return Department::query()->updateOrCreate($data, $data);
    }

    public function update(int $id, array $data): void
    {
        $department = $this->checkById($id);
        $department->update($data);
    }

    public function delete(int $id): void
    {
        $department = $this->checkById($id);
        $department->delete();
    }
}
