<?php

namespace App\Http\Requests\Application;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'has_app'           => 'required|in:0,1',
            'id'                => 'nullable|required_if:has_app,=,1|integer|exists:applications,id',
            'form_id'           => 'nullable|required_if:has_app,=,0|exists:forms,id',
            'branch_id'         => 'required|integer|exists:branches,id',
            'name'              => 'required|string',
            'surname'           => 'required|string',
            'patronymic'        => 'nullable|string',
            'phone'             => 'required|string',
            'pinfl'             => 'required|string|size:14',
            'comment'           => 'nullable|string',
            'hire_date'         => 'nullable|string|date_format:Y-m-d',
            'position_id'       => 'nullable|integer|exists:positions,id',
            'contract_duration' => 'nullable|string|date_format:Y-m-d',
            'intern_duration'   => 'nullable|boolean',
            'passport_code'     => 'required|string',
            'passport_number'   => 'required|string',
            'passport_date'     => 'required|string|date_format:Y-m-d',
            'passport_end_date' => 'required|string|date_format:Y-m-d',

            'app_upload_id'           => 'required|integer|exists:uploads,id',
            'passport_upload_id'      => 'required|integer|exists:uploads,id',
            'passport_back_upload_id' => 'nullable|integer|exists:uploads,id', // id passport orqa tomoni
            'military_upload_id'      => 'nullable|integer|exists:uploads,id',
            'diploma_upload_id'       => 'required|integer|exists:uploads,id',
            'inps_upload_id'          => 'required|integer|exists:uploads,id',
            'avatar_upload_id'        => 'required|integer|exists:uploads,id',
            'address_upload_id'       => 'nullable|integer|exists:uploads,id', // propiska
            'fire_upload_id'          => 'nullable|integer|exists:uploads,id', // ishdan bo'shaganligi

            // imzo qo'ygan arizalarini yuklashi uchun
            'trudovoy_confirm_ids'        => 'nullable|array',
            'trudovoy_confirm_ids.*'      => 'integer|exists:uploads,id',

            'mat_confirm_ids'             => 'nullable|array',
            'mat_confirm_ids.*'           => 'integer|exists:uploads,id',

            'prikaz_priyom_confirm_ids'   => 'nullable|array',
            'prikaz_priyom_confirm_ids.*' => 'integer|exists:uploads,id',

            'nda_confirm_ids'             => 'nullable|array',
            'nda_confirm_ids.*'           => 'integer|exists:uploads,id',

            'position_confirm_ids'        => 'nullable|array',
            'position_confirm_ids.*'      => 'integer|exists:uploads,id',
        ];
    }
}
