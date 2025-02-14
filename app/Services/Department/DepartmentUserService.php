<?php

namespace App\Services\Department;

use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\User;
use App\Services\CheckService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DepartmentUserService
{
    public function list(int $department_id, array $data): LengthAwarePaginator
    {
        $query = DepartmentUser::with(['department', 'user'])
            ->where('department_id', $department_id)
            ->when(isset($data['search']), function ($query) use ($data) {
                $query->whereHas('user', function ($query) use ($data) {
                    $query->where('name', 'like', '%' . $data['search'] . '%')
                        ->orWhere('surname', 'like', '%' . $data['search'] . '%')
                        ->orWhere('patronymic', 'like', '%' . $data['search'] . '%');
                });
            })
            ->orderByDesc('id');

        return $query->paginate($data['per_page'] ?? 15);
    }

    public function add(int $departmentId, array $data): void
    {
        $department = (new CheckService())->checkById(Department::query(), $departmentId, 'Department not found');
        $department->users()->sync($data['users']);
    }

    public function delete(int $departmentId, int $userId): void
    {
        $department = (new CheckService())->checkById(Department::query(), $departmentId, 'Department not found');
        (new CheckService())->checkById(User::query(), $userId, 'User not found', true);

        $department->users()->detach($userId);
    }
}
