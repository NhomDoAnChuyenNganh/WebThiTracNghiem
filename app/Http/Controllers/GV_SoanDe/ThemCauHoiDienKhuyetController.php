<?php

namespace App\Http\Controllers\GV_SoanDe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CauHoi;
use App\Models\MonHoc;
use App\Models\Chuong;
use App\Models\DoanVan;
use App\Models\DapAn;

class ThemCauHoiDienKhuyetController extends Controller
{
    //
    public function index()
    {
        $monhocs = MonHoc::all();
        return view('gv_soande.them-cau-hoi-dien-khuyet', [
            'monhocs' => $monhocs,
            'title' => 'Giáo Viên Soạn Đề',
            'role' => 'Giáo Viên Soạn Đề'
        ]);
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

    public function getCauHois($madv)
    {
        $cauhois = CauHoi::where('MaDV', $madv)->get();
        return response()->json($cauhois);
    }

    public function themCauHoi(Request $request)
    {
        $request->validate([
            'DoanVan' => 'required',
            'NoiDung' => 'required',
            'MucDo' => 'required', // Kiểm tra loại câu hỏi
            'DapAn' => 'required', // Kiểm tra ít nhất một đáp án được chọn
        ]);
        // Lưu câu hỏi vào CSDL
        $cauhoi = new CauHoi();
        $cauhoi->NoiDung = $request->input('NoiDung');
        $cauhoi->MaDV = $request->input('DoanVan');
        $cauhoi->MucDo = $request->input('MucDo');
        $cauhoi->MaLoai = 3;
        $cauhoi->save();

        // Lấy ID của câu hỏi vừa thêm
        $cauHoiID = $cauhoi->MaCH;

        $dapan = new DapAn();
        $dapan->NoiDungDapAn = $request->input('DapAn');
        $dapan->LaDapAnDung = true;
        $dapan->MaCH = $cauHoiID;
        $dapan->save();

        return redirect('/gv_soande/them-cau-hoi-dien-khuyet')->with('success', 'Câu hỏi đã được thêm thành công.');
    }
}
