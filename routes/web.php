<?php

use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/user/login', [LoginController::class, 'index'])->name('login');
Route::post('/user/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/user/register', [RegisterController::class, 'index'])->name('register');
Route::post('/user/register', [RegisterController::class, 'register'])->name('register.post');