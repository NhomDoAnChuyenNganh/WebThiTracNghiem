<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonHoc;
use App\Models\Chuong;

class ChuongController extends Controller
{
    //
    public function themChuongForm()
    {
        $monhocs = MonHoc::all();
        return view('/soande/them-chuong', ['monhocs' => $monhocs, 'title' => 'Thêm đoạn văn']);
    }
    public function themChuong(Request $request)
    {
        $request->validate([
            'MonHoc' => 'required',
            'TenChuong' => 'required',
        ]);

        $chuong = new Chuong;
        $chuong->MaMH = $request->input('MonHoc');
        $chuong->TenChuong = $request->input('TenChuong');
        $chuong->save();

        return redirect('/gv_soande/them-chuong')->with('success', 'Thêm chương thành công.');
    }
}
