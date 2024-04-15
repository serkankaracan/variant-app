<?php

use App\Http\Controllers\VariantValueController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\ProductController;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::resource('categories', CategoryController::class);
Route::resource('variants', VariantController::class);
Route::resource('variantValues', VariantValueController::class);
Route::resource('products', ProductController::class);
