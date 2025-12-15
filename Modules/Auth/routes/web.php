<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Auth\Http\Controllers\AuthController;
use Modules\Auth\Http\Controllers\Dashboard\PermissionController;
use Modules\Auth\Http\Controllers\Dashboard\ProfileController;
use Modules\Auth\Http\Controllers\Dashboard\RoleController;
use Modules\Auth\Http\Controllers\Dashboard\UserController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('auths', AuthController::class)->names('auth');
// });

Route::
prefix(LaravelLocalization::setLocale().'/dashboard')
->middleware(['auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'  ])
->as('dashboard.')
->group(function () {
    Route::resource('users', UserController::class)->names('users');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.show');
});
