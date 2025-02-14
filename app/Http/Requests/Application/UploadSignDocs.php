<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadSignDocs extends FormRequest
{
    public function rules(): array
    {
        return [
            'app_id'    => ['required', 'integer', Rule::exists('applications', 'id')->where('type_id', 7)],
            'upload_id' => 'required|integer|exists:uploads,id',
        ];
    }
}
