<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ])
    ->group(function () {

        Route::get('/', function () {
            return view('welcome');
        })->name('home');

        Route::middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified',
        ])->group(function () {
            // Route::get('/dashboard', function () {
            //     return view('dashboard');
            // })->name('dashboard');
        });
    });
