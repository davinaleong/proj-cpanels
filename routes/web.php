<?php

use Illuminate\Support\Facades\Route;
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/blank', function () {
        return view('blank');
    })->name('blank');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::get('/other-settings', [SettingsController::class, 'otherSettingsIndex'])->name('settings.other-settings.index');
        Route::get('/other-settings/edit', [SettingsController::class, 'otherSettingsEdit'])->name('settings.other-settings.edit');
        Route::post('/other-settings/edit', [SettingsController::class, 'otherSettingsUpdate'])->name('settings.other-settings.update');
    });
});

require __DIR__.'/auth.php';
