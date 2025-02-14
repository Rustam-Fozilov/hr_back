<?php

namespace App\Http\Requests\Staff;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => 'required|string',
            'surname'    => 'required|string',
            'patronymic' => 'nullable|string',
            'phone'      => 'required|regex:/^(998)([0-9]{9})$/',
            'pinfl'      => 'required|string',
            'position'   => 'nullable|string',
            'enter_date' => 'nullable|date:Y-m-d',
            'branch_id'  => 'required|integer|exists:branches,id',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        failedValidation($validator);
    }
}
