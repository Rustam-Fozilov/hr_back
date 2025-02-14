<?php

namespace App\Http\Requests\Permission;

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
            'parent_id' => 'nullable|integer',
            'is_parent' => 'required|integer',
            'title'     => 'required|string',
            'key'       => 'required|string',
            'type'      => 'required|string',
            'options'   => 'nullable|array'
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        failedValidation($validator);
    }
}
