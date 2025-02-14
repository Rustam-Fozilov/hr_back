<?php

namespace App\Services\User;

use App\Http\Integrations\Invoice\InvoiceConnector;
use App\Http\Integrations\Invoice\Requests\GetUserByPinflRequest;
use App\Models\Branch;
use App\Models\Position;
use App\Models\User;
use App\Services\CheckService;
use Carbon\Carbon;

class UserService
{
    public function list(array $data)
    {
        return User::with(['role', 'branch', 'branches', 'avatar', 'position'])
            ->when(isset($data['search']), function ($query) use ($data) {
                $query->where(function ($query) use ($data) {
                    $query->where('name', 'like', '%' . $data['search'] . '%')
                        ->orWhere('surname', 'like', '%' . $data['search'] . '%')
                        ->orWhere('patronymic', 'like', '%' . $data['search'] . '%')
                        ->orWhere('pinfl', 'like', '%' . $data['search'] . '%')
                        ->orWhere('phone', 'like', '%' . $data['search'] . '%')
                        ->orWhereRelation('role', 'name', 'like', '%' . $data['search'] . '%');
                });
            })
            ->when(isset($data['role_id']), function($query) use ($data) {
                $query->where('role_id', $data['role_id']);
            })
            ->when(isset($data['branch_id']), function($query) use ($data) {
                $query->where('branch_id', $data['branch_id']);
            })
            ->when(isset($data['status']), function($query) use ($data) {
                $query->where('status', $data['status']);
            })
            ->paginate($data['per_page'] ?? 15);
    }

    public function add(array $data)
    {
        if (checkPinflNumber($data['pinfl']) === false) throwError(__('user.pinfl_incorrect'));
        $this->checkWithoutPinfl($data['pinfl']);
        $user = User::query()->create($data);
        if (isset($data['branches'])) $user->branches()->sync($data['branches']);
        return $user;
    }

    public function checkById(int $id)
    {
        return (new CheckService())->checkById(User::with(['branch', 'avatar']), $id, __('user.not_found'), true);
    }

    public function checkWithoutPinfl(string $pinfl)
    {
        return (new CheckService())->checkWithoutKeyValue(User::query(), 'pinfl', $pinfl, __('user.exists'));
    }

    public function checkPinflWithoutId(int $id, string $pinfl): void
    {
        $check = User::query()->where([
            ['id', '!=', $id],
            ['pinfl', $pinfl],
            ['status', 1]
        ])->first();

        if ($check) throwError("$pinfl bu pinfl oldin royxatdan otgan");
    }

    public function show(int $id)
    {
        return User::with(['branch', 'branches', 'avatar', 'role', 'position'])->find($id);
    }

    public function getByPinfl(string $pinfl)
    {
        $request = new GetUserByPinflRequest($pinfl);
        $response = (new InvoiceConnector)->send($request);
        $data = json_decode($response->body(), true);

        if (!isset($data['data']) || !isset($data['data']['ns10Code'])) {
            throwError("Bu pinfl raqam bo`yicha ma`lumot topa olmadik: $pinfl");
        }

        $result = $data['data'];
        if (isset($result['fullName'])) {
            $fullName = explode(' ', $result['fullName'], 3);
            $result['name'] = $fullName[1];
            $result['surname'] = $fullName[0];
            $result['patronymic'] = $fullName[2];
        }

        return $result;
    }

    public function me()
    {
        return auth()->user();
    }

    public function updatePassword(array $info): void
    {
        auth()->user()->update(['password' => $info['password']]);
    }

    public function edit(int $id, array $data): void
    {
        $user = $this->checkById($id);
        if (checkPinflNumber($data['pinfl']) === false) throwError(__('user.pinfl_incorrect'));
        $this->checkPinflWithoutId($id, $data['pinfl']);
        $user->update($data);
        if (isset($data['branches'])) $user->branches()->sync($data['branches']);
        if (isset($data['departments'])) $user->departments()->sync($data['departments']);
    }

    public function delete(int $id): void
    {
        $user = $this->checkById($id);
        $user->tokens()->delete();
        $user->update(['status' => 0]);
    }

    public function firstOrCreate(
        string $pinfl,
        string $name,
        string $surname,
        string $phone,
        int $role_id,
        string $patronymic = null,
        int $branch_id = null,
    )
    {
        return User::query()->firstOrCreate(
            [
                'pinfl' => $pinfl,
            ],
            [
                'name'       => $name,
                'surname'    => $surname,
                'patronymic' => $patronymic,
                'phone'      => $phone,
                'role_id'    => $role_id,
                'branch_id'  => $branch_id,
                'password'   => 123456,
            ]
        );
    }

    public function importExcel(array $item): void
    {
        $fio = $item[1];
        $name = explode(' ', $fio, 3)[1];
        $surname = explode(' ', $fio, 3)[0];
        $patronymic = explode(' ', $fio, 3)[2] ?? null;
        $pinfl = $item[2];
        $branch_id = Branch::query()->where('name', 'LIKE', $item[0])->first()->id ?? null;
        $birth_date = $item[4] ? Carbon::parse($item[4])->format('Y-m-d') : null;
        $clearPhone = removeSymbol($item[7]);
        $clearPhone2 = removeSymbol($item[8]);
        $phone = strlen($clearPhone) == 9 ? '998' . $clearPhone : $clearPhone;
        $phone2 = strlen($clearPhone2) == 9 ? '998' . $clearPhone2 : $clearPhone2;
        $position_id = Position::query()->where('name', $item[3])->first()->id ?? null;
        $realPhone = null;

        if (strlen($phone) >= 9) {
            $realPhone = $phone;
        } else if (strlen($phone2) >= 9) {
            $realPhone = $phone2;
        }

        $user = User::query()->where('pinfl', $pinfl)->first();

        if (is_null($user) && is_null($realPhone)) return;

        if ($user) {
            if (is_null($user->branch_id)) {
                $user->branch_id = $branch_id;
                $user->save();
            }
            return;
        }

        User::query()->firstOrCreate(
            ['pinfl' => $pinfl],
            [
                'name' => $name,
                'surname' => $surname,
                'patronymic' => $patronymic,
                'phone' => $realPhone,
                'birth_date' => $birth_date,
                'role_id' => 2,
                'branch_id' => $branch_id,
                'position_id' => $position_id,
                'password' => 123456,
                'status' => 1,
            ]
        );
    }
}
