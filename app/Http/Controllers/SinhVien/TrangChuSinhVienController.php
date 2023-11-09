<?php

namespace App\Http\Controllers\SinhVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrangChuSinhVienController extends Controller
{
    public function index()
    {
        return view('sinhvien.trang-chu-sinh-vien',[
            'title'=>'Sinh Viên',
            'role' =>'Sinh Vien' 
        ]);
    }
}
