<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonHocController;
use App\Http\Controllers\ChuongController;
use App\Http\Controllers\DoanVanController;
use App\Models\Chuong;

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
Route::get('/soande/them-mon-hoc', [MonHocController::class, 'themMonHocForm']);
Route::post('/soande/them-mon-hoc', [MonHocController::class, 'themMonHoc']);
Route::get('/soande/them-chuong', [ChuongController::class, 'themChuongForm']);
Route::post('/soande/them-chuong', [ChuongController::class, 'themChuong']);
Route::get('/soande/them-doan', [DoanVanController::class, 'themDoanVanForm'])->name('doanvan.form');
Route::get('/get-chuongs/{mamh}', [DoanVanController::class, 'getChuongs']);
Route::post('/soande/them-doan', [DoanVanController::class, 'themDoanVan'])->name('doanvan.them');
