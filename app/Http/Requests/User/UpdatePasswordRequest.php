<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password'         => 'required|string|min:6',
            'password_confirm' => 'required|same:password|string|min:6'
        ];
    }
}
