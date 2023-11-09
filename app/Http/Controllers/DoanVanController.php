<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Models\Chuong;
use App\Models\DoanVan;
use App\Models\MonHoc;

class DoanVanController extends Controller
{
    //
    public function themDoanVanForm()
    {
        $monhocs = MonHoc::all();
        return view('/soande/them-doan', ['monhocs' => $monhocs]);
    }
    public function themDoanVan(Request $request)
    {
        $request->validate([
            'TenDV' => 'required',
            'MaChuong' => 'required',
        ]);

        $doanVan = new DoanVan;
        $doanVan->TenDV = $request->input('TenDV');
        $doanVan->MaChuong = $request->input('MaChuong');
        $doanVan->save();

        return redirect('/soande/them-doan')->with('success', 'Thêm đoạn văn thành công.');
    }

    public function getChuongs($mamh)
    {
        $chuongs = Chuong::where('MaMH', $mamh)->get();
        return response()->json($chuongs);
    }

}
