<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class AddInternRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => 'required|string',
            'surname'     => 'required|string',
            'patronymic'  => 'nullable|string',
            'phone'       => 'required|regex:/^(998)([0-9]{9})$/',
            'pinfl'       => 'required|string|size:14',
            'birth_date'  => 'nullable|string|date_format:Y-m-d',
            'branch_id'   => 'required|integer|exists:branches,id',
            'position_id' => 'nullable|integer|exists:positions,id',
        ];
    }
}
