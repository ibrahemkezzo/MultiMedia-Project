<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Website\Http\Controllers\HomeController;
use Modules\Website\Http\Controllers\OffersController;
use Modules\Website\Http\Controllers\WebsiteController;

// Route::middleware(['auth', 'verified'])->group(function () {
// });

Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ])
    ->group(function () {

        // Route::get('/', function () {
        //     return view('welcome');
        // })->name('home');

    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('/offers', [OffersController::class,'index'])->name('offers');
    });
