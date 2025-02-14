<?php

namespace App\Http\Requests\Form;

use Illuminate\Foundation\Http\FormRequest;

class SoftStoreFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // shaxsiy malumotlar
            'personal_data'                => 'nullable|array',
            'personal_data.birth_address'  => 'nullable|string',
            'personal_data.phone_home'     => 'nullable|regex:/^[0-9]{12}$/',
            'personal_data.phone_work'     => 'nullable|regex:/^[0-9]{12}$/',
            'personal_data.email'          => 'nullable|string',
            'personal_data.living_address' => 'nullable|string',
            'personal_data.family_status'  => 'nullable|string',
            'personal_data.dress_size'     => 'nullable|string',
            'personal_data.smoke_status'   => 'nullable|string',
            'personal_data.drink_status'   => 'nullable|string',
            'personal_data.citizenship'    => 'nullable|string',
            'personal_data.nationality'    => 'nullable|string',
            'personal_data.birth_date'     => 'nullable|string',
            'personal_data.phone_other'    => 'nullable|string',

            // malumoti
            'degree_data'                   => 'nullable|array',
            'degree_data.*.entrance_year'   => 'nullable',
            'degree_data.*.graduation_year' => 'nullable',
            'degree_data.*.university'      => 'nullable|string',
            'degree_data.*.speciality'      => 'nullable|string',
            'degree_data.*.additional'      => 'nullable|string',

            // til bilish datajasi
            'lang_data'               => 'nullable|array',
            'lang_data.*.lang'        => 'nullable|string',
            'lang_data.*.read_level'  => 'nullable|string',
            'lang_data.*.write_level' => 'nullable|string',
            'lang_data.*.speak_level' => 'nullable|string',

            // ko'nikmalarni bilish darajasi
            'skills_data'                  => 'nullable|array',
            'skills_data.ms_word'          => 'nullable|string',
            'skills_data.internet'         => 'nullable|string',
            'skills_data.ms_excel'         => 'nullable|string',
            'skills_data.1c'               => 'nullable|string',
            'skills_data.car_model'        => 'nullable|string',
            'skills_data.car_year'         => 'nullable',
            'skills_data.driver_license'   => 'nullable|array',
            'skills_data.driver_license.*' => 'nullable|string',

            // qarindoshlari malumoti
            'relative_data'                  => 'nullable|array',
            'relative_data.*.relative_type'  => 'nullable|string',
            'relative_data.*.fio'            => 'nullable|string',
            'relative_data.*.birth_date'     => 'nullable|date_format:Y-m-d',
            'relative_data.*.work_place'     => 'nullable|string',
            'relative_data.*.living_address' => 'nullable|string',
            'relative_data.*.phone'          => 'nullable|string',

            // ish tajribasi
            'work_experience'                        => 'nullable|array',
            'work_experience.*.start_date'           => 'nullable|date_format:Y-m-d',
            'work_experience.*.end_date'             => 'nullable|date_format:Y-m-d',
            'work_experience.*.company_name'         => 'nullable|string',
            'work_experience.*.position'             => 'nullable|string',
            'work_experience.*.company_person_count' => 'nullable|integer',
            'work_experience.*.under_person_count'   => 'nullable|integer', // Rahbarlar uchun qo'l ostidagi ishchilari soni
            'work_experience.*.activities'           => 'nullable|string',
            'work_experience.*.reason_for_leaving'   => 'nullable|string',
            'work_experience.*.salary'               => 'nullable|integer',
            'work_experience.*.achievements'         => 'nullable|string',

            // ishda nima muhimligi
            'importance_data'                     => 'nullable|array',
            'importance_data.salary'              => 'nullable|integer|between:1,10',
            'importance_data.stability'           => 'nullable|integer|between:1,10',
            'importance_data.new_skills'          => 'nullable|integer|between:1,10',
            'importance_data.flexible_work_hours' => 'nullable|integer|between:1,10',
            'importance_data.work_interest'       => 'nullable|integer|between:1,10',
            'importance_data.team_env'            => 'nullable|integer|between:1,10',
            'importance_data.work_in_office'      => 'nullable|integer|between:1,10',
            'importance_data.company_rating'      => 'nullable|integer|between:1,10',
            'importance_data.near_home'           => 'nullable|integer|between:1,10',
            'importance_data.career_growth'       => 'nullable|integer|between:1,10',

            // blitz savollar
            'blitz_data'                      => 'nullable|array',
            'blitz_data.work_quality_1'       => 'nullable|string',
            'blitz_data.work_quality_2'       => 'nullable|string',
            'blitz_data.work_quality_3'       => 'nullable|string',
            'blitz_data.weakness'             => 'nullable|string',
            'blitz_data.wanted_skills'        => 'nullable|string',
            'blitz_data.final_career'         => 'nullable|string',
            'blitz_data.reason_for_demission' => 'nullable|string',
            'blitz_data.service_trip_period'  => 'nullable|string',
            'blitz_data.criminal_works'       => 'nullable|string',
            'blitz_data.networking'           => 'nullable|string',
            'blitz_data.networking_fio'       => 'nullable|string',
            'blitz_data.where_company_know'   => 'nullable|string',
            'blitz_data.start_date'           => 'nullable|date_format:Y-m-d',
            'blitz_data.salary'               => 'nullable|integer',
        ];
    }
}
