<?php

namespace App\Services;

use App\Enums\AppStepEnum;
use App\Enums\RoleEnum;
use App\Models\Application;
use App\Models\Department;

class CheckService
{
    public function checkById($model, int $id, string $message = "Data not found", $checkActive = false)
    {
        if ($checkActive) $model->active();
        $data = $model->find($id);
        if (!$data) throwError($message);
        return $data;
    }

    public function checkWithoutId($model, int $id, string $message = "Data already exists", $checkActive = false)
    {
        if ($checkActive) $model->active();
        $data = $model->find($id);
        if ($data) throwError($message);
        return $data;
    }

    public function checkManyById($model, array $ids, string $message = "Data not found", $checkActive = false)
    {
        if ($checkActive) $model->active();
        $data = $model->whereIn('id', $ids)->get();
        if ($data->count() !== count($ids)) throwError($message);
        return $data;
    }

    public function checkManyWithoutId($model, array $ids, string $message = "Data already exists", $checkActive = false)
    {
        if ($checkActive) $model->active();
        $data = $model->whereIn('id', $ids)->get();
        if ($data->count() > 0) throwError($message);
        return $data;
    }

    public function checkByKeyValue($model, string $key, $value, string $message = "Data not found", $checkActive = false)
    {
        if ($checkActive) $model->active();
        $data = $model->where($key, $value)->first();
        if (!$data) throwError($message);
        return $data;
    }

    public function checkWithoutKeyValue($model, string $key, $value, string $message = "Data already exists", $checkActive = false)
    {
        if ($checkActive) $model->active();
        $data = $model->where($key, $value)->first();
        if ($data) throwError($message);
        return $data;
    }

    public function checkManyByKeyValue($model, string $key, array $values, string $message = "Data not found", $checkActive = false)
    {
        if ($checkActive) $model->active();
        $data = $model->whereIn($key, $values)->get();
        if ($data->count() !== count($values)) throwError($message);
        return $data;
    }

    public function checkManyWithoutKeyValue($model, string $key, array $values, string $message = "Data already exists", $checkActive = false)
    {
        if ($checkActive) $model->active();
        $data = $model->whereIn($key, $values)->get();
        if ($data->count() > 0) throwError($message);
        return $data;
    }

    public function checkForDirector($user, $allow_admin = true): bool
    {
        if ($allow_admin && $user->role_id === RoleEnum::ADMIN->value) return true;
        if ($user->role_id !== RoleEnum::DIRECTOR->value) throwError('Faqat direktor uchun');
        return true;
    }

    public function checkForDepartmentDirector($user, Department $department, $allow_admin = true): bool
    {
        if ($allow_admin && $user->role_id === RoleEnum::ADMIN->value) return true;
        if ($user->role_id !== RoleEnum::DIRECTOR->value && $user->id !== $department->director_id) throwError('Faqat bo\'lim boshliqlari uchun');
        return true;
    }

    public function checkForHR($user, $allow_admin = true): bool
    {
        if ($allow_admin && $user->role_id === RoleEnum::ADMIN->value) return true;
        if ($user->role_id !== RoleEnum::HR->value) throwError('Faqat HR uchun');
        return true;
    }

    public function checkAppCurrentStep(Application $app, AppStepEnum $step): bool
    {
        if ($app->step_number === $step->value) throwError('Ariza allaqachon bu qadamda');
        return true;
    }
}
