<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddRolePermRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'data'                 => 'required|array',
            'data.*.role_id'       => 'required|integer',
            'data.*.permission_id' => 'required|integer',
            'data.*.key'           => 'nullable|string',
            'data.*.value'         => 'required|string',
            'data.*.permission'    => 'nullable|array',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        failedValidation($validator);
    }
}
