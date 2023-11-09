<?php

namespace App\Http\Controllers\GV_SoanDe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrangChuGiaoVienSoanDeController extends Controller
{
    public function index()
    {
        return view('gv_soande.trang-chu-giao-vien-soan-de',[
            'title'=>'Giáo Viên Soạn Đề',
            'role' =>'Giáo Viên Soạn Đề' 
        ]);
    }
}
