<?php

namespace App\Http\Controllers;

use App\Http\Requests\Form\SoftStoreFormRequest;
use App\Models\Form;
use App\Services\Form\FormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __construct(
        protected FormService $service,
    )
    {
    }

    public function show(int $form_id): JsonResponse
    {
        $form = $this->service->show($form_id);
        return success($form);
    }

    public function store(SoftStoreFormRequest $request): JsonResponse
    {
        $form = $this->service->create($request->validated());
        return success($form);
    }

    public function update(int $id, SoftStoreFormRequest $request): JsonResponse
    {
        $form = $this->service->update($id, $request->validated());
        return success($form);
    }

    public function destroy(Form $form): JsonResponse
    {
        $form->delete();
        return success();
    }
}
