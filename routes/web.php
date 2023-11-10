<?php

use App\Http\Controllers\CB_CoiThi\TrangChuCanBoCoiThiController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonHocController;
use App\Http\Controllers\ChuongController;
use App\Http\Controllers\DoanVanController;
use App\Http\Controllers\GV_SoanDe\TrangChuGiaoVienSoanDeController;
use App\Http\Controllers\QuanLy\QLUserController;
use App\Http\Controllers\QuanLy\TrangChuQuanLyController;
use App\Http\Controllers\SinhVien\TrangChuSinhVienController;


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
    return view('home', ['title' => 'Trang chủ']);
});

Route::get('/soande/them-mon-hoc', [MonHocController::class, 'themMonHocForm']);
Route::post('/soande/them-mon-hoc', [MonHocController::class, 'themMonHoc']);
Route::get('/soande/them-chuong', [ChuongController::class, 'themChuongForm']);
Route::post('/soande/them-chuong', [ChuongController::class, 'themChuong']);
Route::get('/soande/them-doan', [DoanVanController::class, 'themDoanVanForm'])->name('doanvan.form');
Route::get('/get-chuongs/{mamh}', [DoanVanController::class, 'getChuongs']);
Route::post('/soande/them-doan', [DoanVanController::class, 'themDoanVan'])->name('doanvan.them');

//Chức năng đăng nhập, đăng kí, resetpassword
Route::get('/user/login', [LoginController::class, 'index'])->name('login');
Route::get('/user/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/user/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/user/register', [RegisterController::class, 'index'])->name('register');
Route::post('/user/register', [RegisterController::class, 'register'])->name('register.post');
Route::get('/user/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot-password');
Route::post('/user/forgot-password', [ForgotPasswordController::class, 'forgotpassword'])->name('forgot-password.post');
Route::get('/user/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('reset-password');
Route::post('/user/reset-password/{token}', [ResetPasswordController::class, 'resetPassword'])->name('reset-password.post');

//Chức năng của nhóm quản lý
Route::group(['middleware' => 'checkLogin:1'], function () {

    Route::get('/quanly/trang-chu-quan-ly', [TrangChuQuanLyController::class, 'index'])->name('trang-chu-quan-ly');
    Route::get('/quanly/ql-user', [QLUserController::class, 'index'])->name('ql-user');
    Route::post('/quanly/ql-user', [QLUserController::class, 'getUsersByRole'])->name('getUsersByRole');
    Route::get('/quanly/delete-user/{id}', [QLUserController::class, 'deleteUser'])->name('delete-user');
    Route::get('/quanly/edit-user/{id}', [QLUserController::class, 'edituser'])->name('edit-user');
    Route::put('/quanly/update-user/{id}', [QLUserController::class, 'updateuser'])->name('update-user');
});
//Chức năng của nhóm giáo viên soạn đề
Route::group(['middleware' => 'checkLogin:2'], function () {

    Route::get('/gv_soande/trang-chu-giao-vien-soan-de', [TrangChuGiaoVienSoanDeController::class, 'index'])->name('trang-chu-giao-vien-soan-de');
});
//Chức năng của nhóm quản cán bộ coi thi
Route::group(['middleware' => 'checkLogin:3'], function () {

    Route::get('/cb_coithi/trang-chu-can-bo-coi-thi', [TrangChuCanBoCoiThiController::class, 'index'])->name('trang-chu-can-bo-coi-thi');
});
//Chức năng của nhóm quản sinh viên
Route::group(['middleware' => 'checkLogin:4'], function () {

    Route::get('/sinhvien/trang-chu-sinh-vien', [TrangChuSinhVienController::class, 'index'])->name('trang-chu-sinh-vien');
});
