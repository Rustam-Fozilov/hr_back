<?php

namespace App\Http\Requests\Role;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'       => 'required|string',
            'color'      => 'nullable|string',
            'branch_add' => 'nullable|boolean',
        ];
    }
}
