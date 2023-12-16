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
        return view('/soande/them-doan', [
            'monhocs' => $monhocs,
            'title' => 'Thêm Đoạn Văn'
        ]);
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

    public function getDoanVans($machuong)
    {
        $doanvans = DoanVan::where('MaChuong', $machuong)->get();
        return response()->json($doanvans);
    }

    public function suaDoanVanForm($id)
    {
        $doanVan = DoanVan::find($id);

        return view('/soande/sua-doan-van', [
            'doanVan' => $doanVan,
            'title' => 'Sửa Đoạn Văn'
        ]);
    }

    public function suaDoanVan(Request $request, $id)
    {
        $request->validate([
            'TenDV' => 'required',
        ]);

        $doanVan = DoanVan::find($id);
        $doanVan->TenDV = $request->input('TenDV');
        $doanVan->save();

        return redirect('/soande/them-doan')->with('success', 'Sửa đoạn văn thành công.');
    }

    public function xoaDoanVan($id)
    {
        $doanVan = DoanVan::find($id);

        if (!$doanVan) {
            return redirect('/soande/them-doan')->with('error', 'Không tìm thấy đoạn văn.');
        }

        try {
            $doanVan->delete();
            return redirect('/soande/them-doan')->with('success', 'Xóa đoạn văn thành công.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->back()->with('error', 'Không thể xóa đoạn văn này do tồn tại các mối quan hệ liên quan.');
            }
        }
    }
}
