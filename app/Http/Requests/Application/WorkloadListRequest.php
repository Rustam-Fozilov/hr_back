<?php

namespace App\Http\Requests\Application;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class WorkloadListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type'   => 'required|integer',
            'app_id' => 'nullable|integer|exists:application_workloads,application_id',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        failedValidation($validator);
    }
}
