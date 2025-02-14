<?php

use App\Console\Commands\DeleteExpiredFiles;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            $lang = getLang();

            Route::middleware('api')
                ->prefix('api' . $lang)
                ->group(base_path('routes/api.php'));

            Route::middleware('api')
                ->prefix('api' . $lang)
                ->group(base_path('routes/role_perm.php'));

            Route::middleware('api')
                ->prefix('api' . $lang)
                ->group(base_path('routes/apps.php'));

            Route::middleware('web')
                ->prefix($lang)
                ->group(base_path('routes/web.php'));

            Route::prefix('test' . $lang)
                ->middleware('admin')
                ->group(base_path('routes/test.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'         => \App\Http\Middleware\AdminMiddleware::class,
            'project_token' => \App\Http\Middleware\ProjectTokenMiddleware::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('telescope:prune')->dailyAt('00:00');
        $schedule->command(DeleteExpiredFiles::class)->dailyAt('00:00');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (ValidationException $e) {
            failedValidation($e->validator);
        });
    })->create();
