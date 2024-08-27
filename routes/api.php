<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

Route::middleware('auth:sanctum')->group(function(){
    Route::controller(ProductController::class)->prefix('/products')->as('products.')->group(function(){
        Route::get('/', 'store')->name('store');
        Route::get('/{code}', 'index')->name('index');
        Route::delete('/{code}', 'delete')->name('index');
    });
    // Route::controller(DepositReceiptController::class)->prefix('/deposit')->as('deposit')->group(function(){
    //     Route::post('/', 'updateConfirm')->name('updateConfirm');
    // });
});
