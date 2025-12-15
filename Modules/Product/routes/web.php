<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\Product\Http\Controllers\Dashboard\ProductController;
use Modules\Product\Http\Controllers\Website\ProductController as WebsiteProductController;

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::resource('products', ProductController::class)->names('product');
// });

Route::prefix(LaravelLocalization::setLocale().'/dashboard')
    ->middleware(['auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->as('dashboard.')
    ->group(function () {

    Route::resource('products', ProductController::class)->names('products');
    // Route لحذف صورة منتج معينة
    Route::delete('products/{product}/remove-image', [ProductController::class, 'removeImage'])
         ->name('products.removeImage');

});
Route::prefix(LaravelLocalization::setLocale())
    ->middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
    ->group(function () {

    Route::resource('products', WebsiteProductController::class)->names('products');

});
