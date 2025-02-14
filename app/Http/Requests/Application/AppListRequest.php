<?php

namespace App\Http\Requests\Application;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AppListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'per_page'  => 'nullable|integer|min:1,max:1000',
            'page'      => 'nullable|integer',
            'search'    => 'nullable|string',
            'branch_id' => 'nullable|integer|exists:branches,id',
            'region_id' => 'nullable|integer|exists:regions,id',
            'type_id'   => 'nullable|integer|exists:statuses,id',
            'steps'     => 'nullable|array',
        ];
    }
}
