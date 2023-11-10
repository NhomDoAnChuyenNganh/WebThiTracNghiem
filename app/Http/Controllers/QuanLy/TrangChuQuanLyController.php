<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrangChuQuanLyController extends Controller
{
    public function index()
    {
        return view('quanly.trang-chu-quan-ly',[
            'title'=>'Quản Lý',
            'role' =>'Admin' 
        ]);
    }
}
