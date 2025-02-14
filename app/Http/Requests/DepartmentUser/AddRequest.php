<?php

namespace App\Http\Requests\DepartmentUser;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'users'   => 'required|array',
            'users.*' => 'required|integer|exists:users,id',
        ];
    }
}
