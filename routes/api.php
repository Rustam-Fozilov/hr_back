<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentUserController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkloadController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('branches', [BranchController::class, 'list']);
    Route::get('regions', [RegionController::class, 'list']);
    Route::get('logout', [AuthController::class, 'logout']);

    Route::prefix('user')->group(function () {
        Route::get('pinfl/{pinfl}', [UserController::class, 'getByPinfl']);
        Route::get('list', [UserController::class, 'list']);
        Route::post('add', [UserController::class, 'add']);
        Route::get('show/{id}', [UserController::class, 'show']);
        Route::get('me', [UserController::class, 'me']);
        Route::post('update/password', [UserController::class, 'updatePassword']);
        Route::put('update/{id}', [UserController::class, 'update']);
        Route::delete('delete/{id}', [UserController::class, 'delete']);
    });

    Route::group(['prefix' => 'upload'], function () {
        Route::post('image', [UploadController::class, 'uploadImage'])->name('upload.image');
        Route::post('pdf', [UploadController::class, 'uploadPdf'])->name('upload.pdf');
        Route::post('file', [UploadController::class, 'uploadFile'])->name('upload.file');
        Route::delete('image/{id}', [UploadController::class, 'deleteImage'])->name('delete.image');
    });

    Route::group(['prefix' => 'workloads'], function () {
        Route::get('list', [WorkloadController::class, 'list']);
    });

    // CRUD
    Route::apiResources([
        'form'              => FormController::class,
        'staff'             => StaffController::class,
        'positions'         => PositionController::class,
        'departments'       => DepartmentController::class,
        'applications'      => ApplicationController::class,
        'departments.users' => DepartmentUserController::class,
    ]);
});
