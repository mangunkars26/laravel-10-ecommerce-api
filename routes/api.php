<?php

use App\Http\Controllers\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;


Route::group([
    'middleware' => 'api',
    'prefix'    => 'auth',
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/user-profile', [AuthController::class, 'userProfile']);
});

Route::controller(BrandController::class)->group(function () {
    Route::get('index',  'index');
    Route::get('show/{id}',  'show');
    Route::post('store',  'store');
    Route::put('update-brand/{id}',  'update_brand');
    Route::delete('delete-brand/{id}',  'delete');
});
Route::controller(CategoryController::class)->group(function () {
    Route::get('index',  'index');
    Route::get('show/{id}',  'show');
    Route::post('store',  'store');
    Route::put('update-category/{id}',  'update_category');
    Route::delete('delete-category/{id}',  'delete');
});

// Route::controller(AddressController::class)->group(function () {
//     Route::post('simpan-alamat', 'store');
// });

Route::post('/addresses', [AddressController::class, 'store']);
