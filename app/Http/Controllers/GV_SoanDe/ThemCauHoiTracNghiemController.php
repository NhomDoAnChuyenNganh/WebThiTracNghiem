<?php

namespace App\Http\Controllers\GV_SoanDe;

use App\Http\Controllers\Controller;
use App\Models\Chuong;
use App\Models\DoanVan;
use App\Models\MonHoc;
use App\Models\CauHoi;
use App\Models\DapAn;
use Illuminate\Http\Request;

class ThemCauHoiTracNghiemController extends Controller
{
    //
    public function index()
    {
        $monhocs = MonHoc::all();
        return view('gv_soande.them-cau-hoi-trac-nghiem', [
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
            'DapAnDung' => 'required|array|min:1', // Kiểm tra ít nhất một đáp án được chọn
            'SoLuongDapAn' => 'required|integer|min:1', // Thêm quy tắc validate cho số lượng đáp án
        ]);
        // Lưu câu hỏi vào CSDL
        $cauhoi = new CauHoi();
        $cauhoi->NoiDung = $request->input('NoiDung');
        $cauhoi->MaDV = $request->input('DoanVan');
        $cauhoi->MucDo = $request->input('MucDo');
        // Kiểm tra số lượng checkbox được chọn
        $dapAnDung = $request->input('DapAnDung');
        if (count($dapAnDung) > 1) {
            $cauhoi->MaLoai = 2; // Nhiều hơn 1 checkbox được chọn
        } else {
            $cauhoi->MaLoai = 1; // Chỉ có 1 checkbox được chọn
        }
        $cauhoi->save();

        // Lấy ID của câu hỏi vừa thêm
        $cauHoiID = $cauhoi->MaCH;

        $soDapAn = $request->input('SoLuongDapAn');

        for ($i = 1; $i <= $soDapAn; $i++) {
            $dapan = new DapAn();
            $dapan->NoiDungDapAn = $request->input('DapAn' . $i);

            // Kiểm tra xem checkbox có được chọn hay không
            $checkboxName = 'DapAn' . $i;
            $dapan->LaDapAnDung = in_array($i, $dapAnDung) && $request->has($checkboxName);

            $dapan->MaCH = $cauHoiID;
            $dapan->save();
        }

        return redirect('/gv_soande/them-cau-hoi-trac-nghiem')->with('success', 'Câu hỏi đã được thêm thành công.');
    }
}
