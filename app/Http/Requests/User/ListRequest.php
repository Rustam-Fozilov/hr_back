<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'per_page'  => 'nullable|integer|min:1,max:1000',
            'page'      => 'nullable|integer',
            'search'    => 'nullable|string',
            'branch_id' => 'nullable|integer',
            'role_id'   => 'nullable|integer',
            'status'    => 'nullable|integer|in:0,1',
        ];
    }
}
