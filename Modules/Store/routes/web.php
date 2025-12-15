<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Store\Http\Controllers\Dashboard\StoreController as DashboardStoreController;
use Modules\Store\Http\Controllers\Website\StoreController as WebsiteStoreController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('stores', StoreController::class)->names('store');
// });

Route::prefix(LaravelLocalization::setLocale().'/dashboard')
    ->middleware(['auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->as('dashboard.')
    ->group(function () {

    Route::resource('stores', DashboardStoreController::class)->names('stores');

});
Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->group(function () {

    Route::resource('stores', WebsiteStoreController::class)->names('stores');

});
