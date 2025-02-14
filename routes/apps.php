<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'applications'], function () {
        Route::get('next/app/{app_id}', [ApplicationController::class, 'nextApp']);
        Route::get('download/positions/{app_id}', [ApplicationController::class, 'downloadPositionDocs']);
        Route::get('download/docs/{type}', [ApplicationController::class, 'downloadDocs']);

        Route::group(['prefix' => 'hire'], function () {
            Route::post('change/step', [ApplicationController::class, 'changeHireStep']);
            Route::post('undo/step/{app_id}', [ApplicationController::class, 'undoStep']);
        });

        Route::group(['prefix' => 'fire'], function () {
            Route::post('store', [ApplicationController::class, 'storeFire']);
            Route::post('change/step', [ApplicationController::class, 'changeFireStep']);
            Route::post('undo/step/{app_id}', [ApplicationController::class, 'undoStep']);
            Route::post('{app_id}/sign', [ApplicationController::class, 'sign']);
            Route::post('upload/sign/docs', [ApplicationController::class, 'uploadSignDocs']);
        });

        Route::group(['prefix' => 'intern'], function () {
            Route::post('store', [ApplicationController::class, 'storeIntern']);
        });
    });
});
