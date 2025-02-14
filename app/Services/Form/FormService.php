<?php

namespace App\Services\Form;

use App\Http\Requests\Form\StoreFormRequest;
use App\Models\Form;
use App\Services\CheckService;

class FormService
{
    public function show(int $form_id)
    {
        return (new CheckService())->checkById(
            Form::with(['personal_data', 'relative_data', 'degree_data', 'work_experience_data', 'skills_data', 'lang_data', 'importance_data', 'blitz_data']),
            $form_id,
            'Anketa topilmadi!'
        );
    }

    public function create(array $data): Form
    {
        $form = new Form();
        $form->save();

        if (isset($data['personal_data'])) $form->personal_data()->create($data['personal_data']);
        if (isset($data['skills_data'])) $form->skills_data()->create($data['skills_data']);
        if (isset($data['importance_data'])) $form->importance_data()->create($data['importance_data']);
        if (isset($data['blitz_data'])) $form->blitz_data()->create($data['blitz_data']);

        if (isset($data['relative_data'])) {
            foreach ($data['relative_data'] as $index => $item) {
                $item['ordering'] = $index + 1;
                $form->relative_data()->create($item);
            }
        }

        if (isset($data['degree_data'])) {
            foreach ($data['degree_data'] as $item) {
                $form->degree_data()->create($item);
            }
        }

        if (isset($data['lang_data'])) {
            foreach ($data['lang_data'] as $item) {
                $form->lang_data()->create($item);
            }
        }

        if (isset($data['work_experience'])) {
            foreach ($data['work_experience'] as $index => $item) {
                $item['ordering'] = $index + 1;
                $form->work_experience_data()->create($item);
            }
        }

        return $form;
    }

    public function update(int $id, array $data)
    {
        $form = Form::query()->find($id);

        if (isset($data['personal_data'])) $form->personal_data()->update($data['personal_data']);
        if (isset($data['skills_data'])) $form->skills_data()->update($data['skills_data']);
        if (isset($data['importance_data'])) $form->importance_data()->update($data['importance_data']);
        if (isset($data['blitz_data'])) $form->blitz_data()->update($data['blitz_data']);

        if (isset($data['relative_data'])) {
            $form->relative_data()->delete();
            foreach ($data['relative_data'] as $index => $item) {
                $item['ordering'] = $index + 1;
                $form->relative_data()->create($item);
            }
        }

        if (isset($data['degree_data'])) {
            $form->degree_data()->delete();
            foreach ($data['degree_data'] as $item) {
                $form->degree_data()->create($item);
            }
        }

        if (isset($data['lang_data'])) {
            $form->lang_data()->delete();
            foreach ($data['lang_data'] as $item) {
                $form->lang_data()->create($item);
            }
        }

        if (isset($data['work_experience'])) {
            $form->work_experience_data()->delete();
            foreach ($data['work_experience'] as $index => $item) {
                $item['ordering'] = $index + 1;
                $form->work_experience_data()->create($item);
            }
        }

        return $form;
    }

    public function validateForm(array $data): bool
    {
        $validate = validateData($data, (new StoreFormRequest())->rules());
        if (!$validate) {
            throwError(app()->getLocale() == 'uz' ? 'Forma malumotlar to`liq emas' : 'Информация в форме неполная.');
            return false;
        }
        return true;
    }
}
