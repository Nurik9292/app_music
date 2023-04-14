<?php

use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




// Route::middleware('admin', 'auth')->get('/', MainController::class)->name('main');
Route::get('/', MainController::class)->name('main');

// Route::middleware('admin', 'auth')->namespace('App\Http\Controllers\Admin')->group(function () {
Route::namespace('App\Http\Controllers\Admin')->group(function () {


    // =========== BLOCK =======================
    Route::namespace('Block')->group(function () {

        // ============ OVERVIEW ====================
        Route::prefix('overview')->namespace('Overview')->name('overview.')->group(function () {
            Route::get('/', IndexController::class)->name('index');
            Route::get('/create', CreateController::class)->name('create');
        });
        // ============ END OVERVIEW ====================

        // ============ LISTEN ====================
        Route::prefix('listen')->namespace('Listen')->name('listen.')->group(function () {
            Route::get('/', IndexController::class)->name('index');
        });
        // ============ END LISTEN ====================

        // ============ RADIO ====================
        Route::prefix('radio')->namespace('Radio')->name('radio.')->group(function () {
            Route::get('/', IndexController::class)->name('index');
        });
        // ============ END RADIO ====================
    });
    // ========== END BLOCK =====================

    // ========== USER =====================
    Route::prefix('users')->namespace('User')->name('user.')->group(function () {
        Route::get('/', IndexController::class)->name('index');
        Route::get('/create', CreateController::class)->name('create');
        Route::post('/store', StoreController::class)->name('store');
    });
    // ========== END USERS =====================

    //============= ALBUM========================
    Route::prefix('albums')->namespace('Album')->name('album.')->group(function () {
        Route::get('/', IndexController::class)->name('index');
        Route::get('/create', CreateController::class)->name("create");
        Route::post('/', StoreController::class)->name('store');
    });
});


Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
