<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\MonHoc;
use Illuminate\Http\Request;
use App\Models\PhongThi;
use App\Models\Users;

class QLThiController extends Controller
{
    public function index()
    {
        $dsphong = PhongThi::orderBy('MaPT', 'desc')->get();
        $dsmon = MonHoc::with('dsDeThi')->orderBy('MaMH', 'desc')->get();
        $dssinhvien = Users::where('RoleID', '=', '4')->orderBy('UserID', 'desc')->get();
        $dscanbo = Users::where('RoleID', '=', '3')->orderBy('UserID', 'desc')->get();
        return view('quanly.ql-thi', [
            'title' => 'Quản Lý Thi',
            'dsphong' => $dsphong,
            'dsmon' =>$dsmon,
            'dssinhvien' =>$dssinhvien,
            'dscanbo' =>$dscanbo,
        ]);
    }
}
