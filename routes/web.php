<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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
Route::middleware(['auth.user'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth.user');
});

Route::get('/signin', [UserController::class, 'signin'])->name('signin');
Route::post('/signin', [UserController::class, 'authenticate'])->name('signin');
Route::get('/signup', [UserController::class, 'signup']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
