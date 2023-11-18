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
use App\Http\Controllers\GV_SoanDe\ThemCauHoiDienKhuyetController;
use App\Http\Controllers\GV_SoanDe\ThemCauHoiTracNghiemController;
use App\Http\Controllers\GV_SoanDe\TrangChuGiaoVienSoanDeController;
use App\Http\Controllers\QuanLy\QLUserController;
use App\Http\Controllers\QuanLy\QLMonHocController;
use App\Http\Controllers\QuanLy\TrangChuQuanLyController;
use App\Http\Controllers\SinhVien\TrangChuSinhVienController;
use App\Models\DoanVan;

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
    $user = session('user');
    if (!$user)
        return redirect()->route('login');
    else {
        if ($user->RoleID == 1) {
            return redirect()->route('trang-chu-quan-ly');
        } elseif ($user->RoleID == 2) {
            return redirect()->route('trang-chu-giao-vien-soan-de');
        } elseif ($user->RoleID == 3) {
            return redirect()->route('trang-chu-can-bo-coi-thi');
        } else {
            return redirect()->route('trang-chu-sinh-vien');
        }
    }
});
//Chức năng thêm xóa sửa môn học



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
    Route::get('/quanly/insert-user', [QLUserController::class, 'indexinsert'])->name('insertUser');
    Route::post('/quanly/insert-user', [QLUserController::class, 'insertUser'])->name('insertUser.post');
    Route::post('/quanly/process-file', [QLUserController::class, 'processFile'])->name('processFile');
    Route::get('/quanly/ql-monhoc', [QLMonHocController::class, 'QLMonHocForm'])->name('ql-monhoc');
    Route::post('/quanly/them-mon-hoc', [QLMonHocController::class, 'themMonHoc'])->name('insertMonHoc');
    Route::get('/quanly/delete-monhoc/{id}', [QLMonHocController::class, 'xoaMonHoc'])->name('delete-monhoc');
    Route::post('/quanly/update-monhoc/{id}', [QLMonHocController::class, 'suaMonHoc'])->name('update-monhoc');
    Route::post('/quanly/process-file-monhoc', [QLMonHocController::class, 'processFile'])->name('processFileMH');
});
//Chức năng của nhóm giáo viên soạn đề
Route::group(['middleware' => 'checkLogin:2'], function () {
    Route::get('/soande/them-chuong', [ChuongController::class, 'themChuongForm'])->name('them-chuong');
    Route::post('/soande/them-chuong', [ChuongController::class, 'themChuong']);
    Route::get('/soande/them-doan', [DoanVanController::class, 'themDoanVanForm'])->name('them-doan');
    Route::get('/get-chuongs/{mamh}', [DoanVanController::class, 'getChuongs']);
    Route::post('/soande/them-doan', [DoanVanController::class, 'themDoanVan'])->name('doanvan.them');
    Route::get('/soande/sua-mon-hoc/{id}', [MonHocController::class, 'suaMonHocForm']);
    Route::post('/soande/sua-mon-hoc/{id}', [MonHocController::class, 'suaMonHoc']);
    Route::delete('/soande/xoa-mon-hoc/{id}', [MonHocController::class, 'xoaMonHoc']);
    Route::get('/soande/sua-chuong/{id}', [ChuongController::class, 'suaChuongForm'])->name('sua-chuong');
    Route::post('/soande/sua-chuong/{id}', [ChuongController::class, 'suaChuong']);
    Route::delete('/soande/xoa-chuong/{id}', [ChuongController::class, 'xoaChuong']);
    Route::get('/get-chuongs/{mamh}', [ChuongController::class, 'getChuongs']);
    Route::get('/soande/sua-doan-van/{id}', [DoanVanController::class, 'suaDoanVanForm']);
    Route::post('/soande/sua-doan-van/{id}', [DoanVanController::class, 'suaDoanVan']);
    Route::delete('/soande/xoa-doan-van/{id}', [DoanVanController::class, 'xoaDoanVan'])->name('doanvan.xoa');
    Route::get('/get-doanvans/{machuong}', [DoanVanController::class, 'getDoanVans']);
    Route::post('/soande/them-mon-hoc-excel', [MonHocController::class, 'themMonHocExcel'])->name('them-mon-hoc-excel');
    Route::get('/gv_soande/trang-chu-giao-vien-soan-de', [TrangChuGiaoVienSoanDeController::class, 'index'])->name('trang-chu-giao-vien-soan-de');
    Route::get('/gv_soande/them-cau-hoi-trac-nghiem', [ThemCauHoiTracNghiemController::class, 'index']);
    Route::get('/get-chuongs/{mamh}', [ThemCauHoiTracNghiemController::class, 'getChuongs']);
    Route::get('/get-doanvans/{machuong}', [ThemCauHoiTracNghiemController::class, 'getDoanVans']);
    Route::post('/gv_soande/them-cau-hoi-trac-nghiem', [ThemCauHoiTracNghiemController::class, 'themCauHoi'])->name('them-cau-hoi-trac-nghiem');
    Route::get('/gv_soande/them-cau-hoi-dien-khuyet', [ThemCauHoiDienKhuyetController::class, 'index'])->name('them-cau-hoi-dien-khuyet');
    Route::get('/get-chuongs/{mamh}', [ThemCauHoiDienKhuyetController::class, 'getChuongs']);
    Route::get('/get-doanvans/{machuong}', [ThemCauHoiDienKhuyetController::class, 'getDoanVans']);
    Route::post('/gv_soande/them-cau-hoi-dien-khuyet', [ThemCauHoiDienKhuyetController::class, 'themCauHoi']);
});
//Chức năng của nhóm quản cán bộ coi thi
Route::group(['middleware' => 'checkLogin:3'], function () {

    Route::get('/cb_coithi/trang-chu-can-bo-coi-thi', [TrangChuCanBoCoiThiController::class, 'index'])->name('trang-chu-can-bo-coi-thi');
});
//Chức năng của nhóm quản sinh viên
Route::group(['middleware' => 'checkLogin:4'], function () {

    Route::get('/sinhvien/trang-chu-sinh-vien', [TrangChuSinhVienController::class, 'index'])->name('trang-chu-sinh-vien');
});
