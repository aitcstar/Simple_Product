<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;



Route::group(['prefix' => 'v1'], function () {
    Route::prefix('product')->group(function () {
        Route::get('/index', [ProductController::class, 'index']);
        Route::get('/show/{product}', [ProductController::class, 'show']);
        Route::post('/store', [ProductController::class, 'store']);
        Route::PUT('/update/{product}', [ProductController::class, 'update']);
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy']);
    });


});
