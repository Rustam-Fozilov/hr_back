<?php

namespace App\Http\Requests\Application;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChangeFireAppStepRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'has_app'               => 'required|in:0,1',
            'app_id'                => 'nullable|required_if:has_app,=,1|integer|exists:applications,id',
            'step_number'           => 'required|required_if:has_app,=,0|integer',
            'user_id'               => 'nullable|required_if:has_app,=,0|integer|exists:users,id',
            'fire_date'             => 'nullable|required_if:has_app,=,0|string|date_format:Y-m-d',
            'fire_reason'           => 'nullable|required_if:has_app,=,0|string',
            'app_fire_date'         => 'nullable|required_if:has_app,=,0|string|date_format:Y-m-d', // bo'shashga ariza yozgan sanasi
            'comment'               => 'nullable|string',
            'workload_type'         => 'nullable|required_if:has_app,=,0|integer|in:1,2', // 1-office 2-magazin,
            'workloads'             => 'nullable|required_if:has_app,=,0|array',
            'workloads.*'           => 'nullable|required_if:has_app,=,0|integer|exists:departments,id',
            'declaration_upload_id' => 'nullable|required_if:has_app,=,0|integer|exists:uploads,id',
        ];
    }
}
