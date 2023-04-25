<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->namespace('App\Http\Controllers\Admin\User\Api')->name('api.user.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::patch('/{user}', UpdateController::class)->name('update');
    Route::delete('/{user}', DestroyController::class)->name('destroy');
});

Route::prefix('genres')->namespace('App\Http\Controllers\Admin\Genre\Api')->name('api.genre.')->group(function () {
    Route::get('/', IndexController::class)->name('index');
    Route::patch('/{genre}', UpdateController::class)->name('update');
    Route::delete('/{genre}', DestroyController::class)->name('destroy');
});

Route::prefix('overviews')->namespace('App\Http\Controllers\Admin\Block\Overview\Api')->name('api.overview')->group(function () {
    Route::get('/', IndexController::class)->name('index');
});