<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Core\Http\Controllers\CoreController;
use Modules\Core\Http\Controllers\Dashboard\SettingsController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('cores', CoreController::class)->names('core');
// });
Route::prefix(LaravelLocalization::setLocale().'/dashboard')
    ->middleware(['auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->as('dashboard.')
    ->group(function () {

        // مواردك الأخرى هنا...

        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');
});
