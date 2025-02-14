<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('role')->group(function () {
        Route::get('list', [RoleController::class, 'list']);
        Route::post('add', [RoleController::class, 'add']);
        Route::get('show/{id}', [RoleController::class, 'show']);
        Route::put('update/{id}', [RoleController::class, 'update']);
        Route::delete('delete/{id}', [RoleController::class, 'delete']);
    });
    Route::prefix('permission')->group(function () {
        Route::get('list', [PermissionController::class, 'list']);
        Route::post('add', [PermissionController::class, 'add']);
        Route::get('show/{id}', [PermissionController::class, 'show']);
        Route::put('update/{id}', [PermissionController::class, 'update']);
        Route::delete('delete/{id}', [PermissionController::class, 'delete']);
    });
    Route::prefix('role/permission')->group(function () {
        Route::get('get/by/role/{role_id}', [RolePermController::class, 'getByRole']);
        Route::get('get/user/permission', [RolePermController::class, 'getUserPermission']);
        Route::get('get/by/permission/{perm_id}', [RolePermController::class, 'getByPermission']);
        Route::put('update', [RolePermController::class, 'update']);
    });
});
