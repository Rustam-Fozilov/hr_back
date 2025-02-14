<?php

namespace App\Http\Controllers;

use App\Http\Requests\Upload\UploadRequest;
use App\Services\Upload\UploadService;
use Illuminate\Http\JsonResponse;

class UploadController extends Controller
{
    public function uploadImage(UploadRequest $request): JsonResponse
    {
        $service = new UploadService();

        return success(
            $service->uploadFile($request->file('file'), 1)
        );
    }

    public function uploadPdf(UploadRequest $request): JsonResponse
    {
        $service = new UploadService();

        return success(
            $service->uploadFile($request->file('file'), 1)
        );
    }

    public function uploadFile(UploadRequest $request): JsonResponse
    {
        $service = new UploadService();

        return success(
            $service->uploadFile($request->file('file'), 1)
        );
    }

    public function deleteImage(int $id): JsonResponse
    {
        $service = new UploadService(id: $id);

        return success(
            $service->deleteFileByPath()
        );
    }
}
