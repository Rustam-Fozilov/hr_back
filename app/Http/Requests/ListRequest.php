<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'per_page'  => 'nullable|integer|min:1,max:1000',
            'page'      => 'nullable|integer',
            'search'    => 'nullable|string',
            'id'        => 'nullable|integer',
            'status'    => 'nullable|integer',
            'branch_id' => 'nullable|integer|exists:branches,id',
            'type_id'   => 'nullable|integer|exists:statuses,id',
        ];
    }
}
