<?php

namespace App\Http\Controllers\QuanLy;

use App\Models\DeThi;
use App\Models\Thi;
use App\Models\Users;
use App\Models\MonHoc;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    public function index()
    {
        $userCount = Users::count();
        // Lấy danh sách môn học và số sinh viên thi trên 5 điểm cho mỗi môn
        $thongKeData = DB::table('dethi')
            ->join('thi', 'dethi.MaDe', '=', 'thi.MaDe')
            ->join('monhoc', 'dethi.MaMH', '=', 'monhoc.MaMH')
            ->where('thi.Diem', '>=', 5)
            ->select('monhoc.TenMH', DB::raw('COUNT(thi.MaSV) as so_luong_sinh_vien'))
            ->groupBy('monhoc.TenMH')
            ->get();
        dd($thongKeData);
        return view('quanly.thong-ke', [
            'title' => 'Thống Kê',
            'thongKeData' => $thongKeData,
            'soluongthisinh'=>$userCount
        ]);
    }
}
