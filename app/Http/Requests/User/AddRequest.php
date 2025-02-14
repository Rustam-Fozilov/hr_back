<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'required|string',
            'surname'     => 'required|string',
            'patronymic'  => 'nullable|string',
            'phone'       => 'required|regex:/^(998)([0-9]{9})$/',
            'pinfl'       => 'required|string|size:14',
            'role_id'     => 'required|integer|exists:roles,id',
            'password'    => 'required|string|min:6',
            'birth_date'  => 'nullable|string|date_format:Y-m-d',
            'position_id' => 'nullable|integer|exists:positions,id',
            'branches'    => 'nullable|array',
            'branches.*'  => 'required|integer|exists:branches,id',
            'avatar_id'   => 'nullable|integer|exists:uploads,id',
        ];
    }
}
