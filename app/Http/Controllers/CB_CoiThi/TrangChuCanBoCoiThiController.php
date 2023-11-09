<?php

namespace App\Http\Controllers\CB_CoiThi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TrangChuCanBoCoiThiController extends Controller
{
    public function index()
    {
        return view('cb_coithi.trang-chu-can-bo-coi-thi',[
            'title'=>'Cán Bộ Coi Thi',
            'role' =>'Cán Bộ Coi Thi' 
        ]);
    }
}
