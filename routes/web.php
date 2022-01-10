<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CpanelController;
use App\Http\Controllers\AdditionalDataController;

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

        #region Project Types
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
        Route::delete('/project-types/{projectType}', [SettingsController::class, 'projectTypeDestroy'])
            ->name('settings.project-types.destroy');
        #endregion

        #region Folders
        Route::get('/folders', [SettingsController::class, 'folderIndex'])
            ->name('settings.folders.index');
        Route::get('/folders/create', [SettingsController::class, 'folderCreate'])
            ->name('settings.folders.create');
        Route::post('/folders', [SettingsController::class, 'folderStore'])
            ->name('settings.folders.store');
        Route::get('/folders/{folder}/edit', [SettingsController::class, 'folderEdit'])
            ->name('settings.folders.edit');
        Route::patch('/folders/{folder}', [SettingsController::class, 'folderUpdate'])
            ->name('settings.folders.update');
        Route::delete('/folders/{folder}', [SettingsController::class, 'folderDestroy'])
            ->name('settings.folders.destroy');
        #endregion

        #region Images
        Route::get('/images', [SettingsController::class, 'imageIndex'])
            ->name('settings.images.index');
        Route::get('/images/create', [SettingsController::class, 'imageCreate'])
            ->name('settings.images.create');
        Route::post('/images', [SettingsController::class, 'imageStore'])
            ->name('settings.images.store');
        Route::get('/images/{image}/edit', [SettingsController::class, 'imageEdit'])
            ->name('settings.images.edit');
        Route::patch('/images/{image}', [SettingsController::class, 'imageUpdate'])
            ->name('settings.images.update');
        Route::delete('/images/{image}', [SettingsController::class, 'imageDestroy'])
            ->name('settings.images.destroy');
        #endregion

        #region Other Settings
        Route::get('/other-settings', [SettingsController::class, 'otherSettingsIndex'])
            ->name('settings.other-settings.index');
        Route::get('/other-settings/edit', [SettingsController::class, 'otherSettingsEdit'])
            ->name('settings.other-settings.edit');
        Route::post('/other-settings/edit', [SettingsController::class, 'otherSettingsUpdate'])
            ->name('settings.other-settings.update');
        #endregion
    });

    Route::resource('cpanels', CpanelController::class);
    Route::resource('additionalDataGroup', AdditionalDataController::class)
        ->except(['show']);
});

require __DIR__.'/auth.php';
