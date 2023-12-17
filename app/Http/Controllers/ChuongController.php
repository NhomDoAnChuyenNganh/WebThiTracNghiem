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
        $chuongs = Chuong::all();
        return view('/soande/them-chuong', [
            'monhocs' => $monhocs,
            'chuongs' => $chuongs,
            'title' => 'Thêm Chương'
        ]);
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

        return redirect('/soande/them-chuong')->with('success', 'Thêm chương thành công.');
    }

    public function suaChuongForm($id)
    {
        $chuong = Chuong::find($id);

        return view('/soande/sua-chuong', [
            'chuong' => $chuong,
            'title' => 'Sửa Chương'
        ]);
    }

    public function suaChuong(Request $request, $id)
    {
        $request->validate([
            'TenChuong' => 'required',
        ]);

        $chuong = Chuong::find($id);
        $chuong->TenChuong = $request->input('TenChuong');
        $chuong->save();

        return redirect('/soande/them-chuong')->with('success', 'Sửa chương thành công.');
    }

    public function xoaChuong($id)
    {
        $chuong = Chuong::find($id);

        if (!$chuong) {
            return redirect('/soande/them-chuong')->with('error', 'Không tìm thấy chương.');
        }

        try {
            $chuong->delete();
            return redirect('/soande/them-chuong')->with('success', 'Xóa chương thành công.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->back()->with('error', 'Không thể xóa chương này do tồn tại các mối quan hệ liên quan.');
            }
        }
    }
    public function getChuongs($mamh)
    {
        $chuongs = Chuong::where('MaMH', $mamh)->get();
        return response()->json($chuongs);
    }
}
