<?php

namespace App\Services\User;

use App\Models\Staff;
use App\Services\CheckService;

class StaffService
{
    public function list(array $data)
    {
        return Staff::with(['user.role', 'user.branch'])
            ->when(isset($data['search']), function ($query) use ($data) {
                $query->whereRelation('user', 'name', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('user', 'surname', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('user', 'patronymic', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('user', 'pinfl', 'like', '%' . $data['search'] . '%')
                    ->orWhereRelation('user', 'phone', 'like', '%' . $data['search'] . '%');
            })
            ->when(isset($data['branch_id']), function ($query) use ($data) {
                $query->whereRelation('user', 'branch_id', $data['branch_id']);
            })
            ->when(isset($data['id']), function ($query) use ($data) {
                $query->where('id', $data['id']);
            })
            ->paginate($data['per_page'] ?? 15);
    }

    public function checkById(int $id)
    {
        return (new CheckService())->checkById(Staff::with(['user.role', 'user.branch']), $id, 'Staff not found');
    }

    public function getById(int $id)
    {
        return $this->checkById($id);
    }

    public function add(array $data): void
    {
        if (checkPinflNumber($data['pinfl']) === false) throwError('Pinfl raqam noto`g`ri');
        $user = (new UserService())->firstOrCreate(
            pinfl: $data['pinfl'],
            name: $data['name'],
            surname: $data['surname'],
            phone: $data['phone'],
            role_id: 2,
            patronymic: $data['patronymic'] ?? null,
            branch_id: $data['branch_id'],
        );
        Staff::query()->create([
            'user_id'    => $user->id,
            'position'   => $data['position'],
            'enter_date' => $data['enter_date'] ?? null,
        ]);
    }

    public function update(int $id, array $data): void
    {
        if (checkPinflNumber($data['pinfl']) === false) throwError('Pinfl raqam noto`g`ri');
        $staff = $this->checkById($id);
        $staff->update($data);
        $staff->user->update($data);
    }

    public function delete(int $id): void
    {
        $this->checkById($id);
        Staff::query()->where('id', $id)->delete();
    }
}
