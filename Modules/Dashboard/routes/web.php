<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Dashboard\Http\Controllers\DashboardController;

Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->group(function () {
        Route::middleware(['auth', 'verified'])->group(function () {
            Route::resource('dashboards', DashboardController::class)->names('dashboard');
        });
    });
