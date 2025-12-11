<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Category\Http\Controllers\Dashboard\CategoryController;

Route::middleware(['auth', 'verified'])->group(function () {


});

Route::prefix(LaravelLocalization::setLocale().'/dashboard')
    ->middleware(['auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->as('dashboard.')
    ->group(function () {

    Route::resource('categories', CategoryController::class)->names('categories');

});
