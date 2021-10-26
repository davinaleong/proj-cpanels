<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/blank', function () {
        return view('blank');
    })->name('blank');

    Route::get('/dashboard', [ActivityController::class, 'index'])->name('activities.index');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');

        Route::get('/project-types', [SettingsController::class, 'projectTypeIndex'])
            ->name('settings.project-types.index');
        Route::get('/project-types/create', [SettingsController::class, 'projectTypeCreate'])
            ->name('settings.project-types.create');
        Route::post('/project-types', [SettingsController::class, 'projectTypeStore'])
            ->name('settings.project-types.store');
        Route::get('/project-types/{projectType}/edit', [SettingsController::class, 'projectTypeEdit'])
            ->name('settings.project-types.edit');
        Route::patch('/project-types/{projectType}', [SettingsController::class, 'projectTypeUpdate'])
            ->name('settings.project-types.update');

        Route::get('/other-settings', [SettingsController::class, 'otherSettingsIndex'])
            ->name('settings.other-settings.index');
        Route::get('/other-settings/edit', [SettingsController::class, 'otherSettingsEdit'])
            ->name('settings.other-settings.edit');
        Route::post('/other-settings/edit', [SettingsController::class, 'otherSettingsUpdate'])
            ->name('settings.other-settings.update');
    });
});

require __DIR__.'/auth.php';
