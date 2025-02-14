<?php

namespace App\Http\Requests\Form;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // shaxsiy malumotlar
            'personal_data'                => 'required|array',
            'personal_data.birth_address'  => 'required|string',
            'personal_data.phone_home'     => 'nullable|regex:/^[0-9]{12}$/',
            'personal_data.phone_work'     => 'nullable|regex:/^[0-9]{12}$/',
            'personal_data.email'          => 'nullable|string',
            'personal_data.living_address' => 'required|string',
            'personal_data.family_status'  => 'required|string',
            'personal_data.dress_size'     => 'nullable|string',
            'personal_data.smoke_status'   => 'nullable|string',
            'personal_data.drink_status'   => 'nullable|string',
            'personal_data.citizenship'    => 'required|string',
            'personal_data.nationality'    => 'required|string',
            'personal_data.birth_date'     => 'required|string',
            'personal_data.phone_other'    => 'nullable|string',

            // malumoti
            'degree_data'                   => 'nullable|array',
            'degree_data.*.entrance_year'   => 'required',
            'degree_data.*.graduation_year' => 'required',
            'degree_data.*.university'      => 'required|string',
            'degree_data.*.speciality'      => 'nullable|string',
            'degree_data.*.additional'      => 'nullable|string',

            // til bilish datajasi
            'lang_data'               => 'nullable|array',
            'lang_data.*.lang'        => 'required|string',
            'lang_data.*.read_level'  => 'required|string',
            'lang_data.*.write_level' => 'required|string',
            'lang_data.*.speak_level' => 'required|string',

            // ko'nikmalarni bilish darajasi
            'skills_data'                  => 'nullable|array',
            'skills_data.ms_word'          => 'required_if:skills_data,!=,null|string',
            'skills_data.internet'         => 'required_if:skills_data,!=,null|string',
            'skills_data.ms_excel'         => 'required_if:skills_data,!=,null|string',
            'skills_data.1c'               => 'required_if:skills_data,!=,null|string',
            'skills_data.car_model'        => 'nullable|string',
            'skills_data.car_year'         => 'nullable',
            'skills_data.driver_license'   => 'nullable|array',
            'skills_data.driver_license.*' => 'required_if:skills_data,!=,null|string',

            // qarindoshlari malumoti
            'relative_data'                  => 'required|array',
            'relative_data.*.relative_type'  => 'required|string',
            'relative_data.*.fio'            => 'required|string',
            'relative_data.*.birth_date'     => 'required|date_format:Y-m-d',
            'relative_data.*.work_place'     => 'nullable|string',
            'relative_data.*.living_address' => 'required|string',
            'relative_data.*.phone'          => 'required|string',

            // ish tajribasi
            'work_experience'                        => 'nullable|array',
            'work_experience.*.start_date'           => 'required|date_format:Y-m-d',
            'work_experience.*.end_date'             => 'required|date_format:Y-m-d',
            'work_experience.*.company_name'         => 'required|string',
            'work_experience.*.position'             => 'required|string',
            'work_experience.*.company_person_count' => 'nullable|integer',
            'work_experience.*.under_person_count'   => 'nullable|integer', // Rahbarlar uchun qo'l ostidagi ishchilari soni
            'work_experience.*.activities'           => 'required|string',
            'work_experience.*.reason_for_leaving'   => 'required|string',
            'work_experience.*.salary'               => 'required|integer',
            'work_experience.*.achievements'         => 'required|string',

            // ishda nima muhimligi
            'importance_data'                     => 'nullable|array',
            'importance_data.salary'              => 'required_if:importance_data,!=,null|integer|between:1,10',
            'importance_data.stability'           => 'required_if:importance_data,!=,null|integer|between:1,10',
            'importance_data.new_skills'          => 'required_if:importance_data,!=,null|integer|between:1,10',
            'importance_data.flexible_work_hours' => 'required_if:importance_data,!=,null|integer|between:1,10',
            'importance_data.work_interest'       => 'required_if:importance_data,!=,null|integer|between:1,10',
            'importance_data.team_env'            => 'required_if:importance_data,!=,null|integer|between:1,10',
            'importance_data.work_in_office'      => 'required_if:importance_data,!=,null|integer|between:1,10',
            'importance_data.company_rating'      => 'required_if:importance_data,!=,null|integer|between:1,10',
            'importance_data.near_home'           => 'required_if:importance_data,!=,null|integer|between:1,10',
            'importance_data.career_growth'       => 'required_if:importance_data,!=,null|integer|between:1,10',

            // blitz savollar
            'blitz_data'                      => 'nullable|array',
            'blitz_data.work_quality_1'       => 'required_if:blitz_data,!=,null|string',
            'blitz_data.work_quality_2'       => 'required_if:blitz_data,!=,null|string',
            'blitz_data.work_quality_3'       => 'required_if:blitz_data,!=,null|string',
            'blitz_data.weakness'             => 'required_if:blitz_data,!=,null|string',
            'blitz_data.wanted_skills'        => 'required_if:blitz_data,!=,null|string',
            'blitz_data.final_career'         => 'required_if:blitz_data,!=,null|string',
            'blitz_data.reason_for_demission' => 'required_if:blitz_data,!=,null|string',
            'blitz_data.service_trip_period'  => 'required_if:blitz_data,!=,null|string',
            'blitz_data.criminal_works'       => 'required_if:blitz_data,!=,null|string',
            'blitz_data.networking'           => 'required_if:blitz_data,!=,null|string',
            'blitz_data.networking_fio'       => 'nullable|string',
            'blitz_data.where_company_know'   => 'required_if:blitz_data,!=,null|string',
            'blitz_data.start_date'           => 'required_if:blitz_data,!=,null|date_format:Y-m-d',
            'blitz_data.salary'               => 'required_if:blitz_data,!=,null|integer',
        ];
    }
}
