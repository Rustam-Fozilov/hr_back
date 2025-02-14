<?php

namespace App\Http\Requests\Application;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddFireRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'has_app'               => 'required|in:0,1',
            'id'                    => 'nullable|required_if:has_app,=,1|integer|exists:applications,id',
            'user_id'               => 'required|integer|exists:users,id',
            'fire_date'             => 'required|string|date_format:Y-m-d',
            'fire_reason'           => 'required|string',
            'app_fire_date'         => 'required|string|date_format:Y-m-d', // bo'shashga ariza yozgan sanasi
            'workload_type'         => 'required_if:has_app,=,0|integer|in:1,2', // 1-office 2-magazin,
            'workloads'             => 'required_if:has_app,=,0|array',
            'workloads.*'           => 'required_if:has_app,=,0|integer|exists:departments,id',
            'declaration_upload_id' => 'required|integer|exists:uploads,id',
        ];
    }
}
