<?php

namespace App\Http\Controllers\CB_CoiThi;

use App\Models\DeThi;
use App\Models\Thi;
use App\Models\Users;
use App\Models\MonHoc;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CoiThiController extends Controller
{
    public function index()
    {
        $userId = session('user');
        $dsdethi = DeThi::where('TrangThai', 0)->where('MaCBCT', $userId->UserID)->orderBy('MaDe', 'desc')->paginate(10);
        $dsmonhoc = MonHoc::whereIn('MaMH', $dsdethi->pluck('MaMH'))->get();
        return view('cb_coithi.coi-thi', [
            'title' => 'Cán Bộ Coi Thi',
            'dslichthi' => $dsdethi,
            'dsmonhoc' => $dsmonhoc
        ]);
    }
    public function getMonHocByRole(Request $request)
    {
        $MonhocId = $request->input('monhoc_id');
        $userId = session('user');

        if ($MonhocId != null) {
            $dsdethi = DeThi::where('TrangThai', 0)
            ->where('MaCBCT', $userId->UserID)
            ->where('MaMH', $MonhocId) 
            ->orderBy('MaDe', 'desc')
            ->paginate(10);
        } else {
            $dsdethi = DeThi::where('TrangThai', 0)->where('MaCBCT', $userId->UserID)->orderBy('MaDe', 'desc')->paginate(10);    
        }
        $dsall = DeThi::where('TrangThai', 0)->where('MaCBCT', $userId->UserID)->orderBy('MaDe', 'desc')->paginate(10);    
        $dsmonhoc = MonHoc::whereIn('MaMH', $dsall->pluck('MaMH'))->get();
        return view('cb_coithi.coi-thi', [
            'title' => 'Cán Bộ Coi Thi',
            'dslichthi' => $dsdethi,
            'dsmonhoc' => $dsmonhoc
        ]);
    }
    public function coiThi($id)
    {
        $dssinhvien = Thi::where('MaDe', $id)
            ->with('user') // Sử dụng mối quan hệ để lấy thông tin sinh viên
            ->get();
        return view('cb_coithi.coi-thi-de', [
            'title' => 'Cán Bộ Coi Thi',
            'dssinhvien' => $dssinhvien
        ]);
    }
    public function doiMatKhau(Request $request, $id)
    {
        $request->validate([
            'matkhau_edit' => 'required',
        ]);
        $sinhvien = Users::find($id);
        $hashedPassword = Hash::make($request->input('matkhau_edit'));
        $sinhvien->Password = $hashedPassword;
        $sinhvien->save();
        return redirect()->back()->with('success', 'Mật khẩu đã được thay đổi thành công.');
    }
}
