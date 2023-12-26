<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\DeThi;
use App\Models\MonHoc;
use Illuminate\Http\Request;
use App\Models\PhongThi;
use App\Models\Users;
use App\Models\Thi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class QLThiController extends Controller
{
    public function index()
    {
        $dsphong = PhongThi::orderBy('MaPT', 'desc')->get();
        $dsmon = MonHoc::with('dsDeThi')->orderBy('MaMH', 'desc')->get();
        $dssinhvien = Users::where('RoleID', '=', '4')->orderBy('UserID', 'desc')->get();
        $dscanbo = Users::where('RoleID', '=', '3')->orderBy('UserID', 'desc')->get();
        $dsdethi = DeThi::whereNotNull('MaPT')->orderBy('MaDe', 'desc')->paginate(10);
        return view('quanly.ql-thi', [
            'title' => 'Quản Lý Thi',
            'dsphong' => $dsphong,
            'dsmon' => $dsmon,
            'dssinhvien' => $dssinhvien,
            'dscanbo' => $dscanbo,
            'dsdethi' => $dsdethi,
        ]);
    }
    public function TaoLich(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'monhoc_id' => 'required|string',
            'dethi_id' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'phong_id' => 'required|string',
            'canbo_id' => 'required|string',
            'ngay_thi' => 'required|date',
        ]);

        if ($validator->fails()) {
            // Nếu có lỗi xác thực, hiển thị chúng
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dethi = DeThi::where('MaDe', $request->dethi_id)->first();

        if ($dethi) {
            $thoiGianBatDau = Carbon::createFromFormat('H:i', $request->input('start_time'));

            // Tính thời gian kết thúc
            $thoiGianKetThuc = $thoiGianBatDau->copy()->addMinutes($dethi->ThoiGianLamBai)->addMinutes(20);
            // Kiểm tra xem đã có lịch thi nào khác trong phòng và thời gian đó chưa
            $conflictingSchedule = DeThi::where('MaPT', (int)$request->input('phong_id'))
                ->where('MaDe', '!=', $request->dethi_id)
                ->whereDate('NgayThi', '=', $request->input('ngay_thi'))
                ->where(function ($query) use ($thoiGianBatDau, $thoiGianKetThuc) {
                    $query->whereBetween('ThoiGianBatDau', [$thoiGianBatDau->format('H:i:s'), $thoiGianKetThuc->format('H:i:s')])
                        ->orWhereBetween('ThoiGianKetThuc', [$thoiGianBatDau->format('H:i:s'), $thoiGianKetThuc->format('H:i:s')]);
                })
                ->first();

            if ($conflictingSchedule) {
                return redirect()->back()->with('error', 'Lịch đã bị trùng với đề thi khác trong phòng vì trùng ngày thi và thời gian thi.');
            }

            // Kiểm tra xem đã có cán bộ coi thi nào khác có lịch trùng không
            $conflictingCaoBoSchedule = DeThi::where('MaCBCT', (int)$request->input('canbo_id'))
                ->where('MaDe', '!=', $request->dethi_id)
                ->whereDate('NgayThi', '=', $request->input('ngay_thi'))
                ->where(function ($query) use ($thoiGianBatDau, $thoiGianKetThuc) {
                    $query->where(function ($subquery) use ($thoiGianBatDau, $thoiGianKetThuc) {
                        $subquery->where('ThoiGianBatDau', '>=', $thoiGianBatDau->format('H:i:s'))
                            ->where('ThoiGianBatDau', '<', $thoiGianKetThuc->format('H:i:s'));
                    })
                        ->orWhere(function ($subquery) use ($thoiGianBatDau, $thoiGianKetThuc) {
                            $subquery->where('ThoiGianKetThuc', '>', $thoiGianBatDau->format('H:i:s'))
                                ->where('ThoiGianKetThuc', '<=', $thoiGianBatDau->format('H:i:s'));
                        });
                })
                ->first();

            if ($conflictingCaoBoSchedule) {
                return redirect()->back()->with('error', 'Cán bộ coi thi đã có lịch trùng với đề thi khác.');
            }

            // Cập nhật thông tin lịch thi
            $dethi->NgayThi = $request->input('ngay_thi');
            $dethi->ThoiGianBatDau = Carbon::createFromFormat('H:i', $request->input('start_time'))->toTimeString();
            $dethi->ThoiGianKetThuc = Carbon::parse($dethi->ThoiGianBatDau)->addMinutes($dethi->ThoiGianLamBai)->addMinutes(20)->toTimeString();
            $dethi->MaCBCT = (int)$request->input('canbo_id');
            $dethi->MaPT = (int)$request->input('phong_id');

            $dethi->save();
            return redirect()->route('ql-thi')->with('success', 'Lịch đã được tạo thành công.');
        }

        return redirect()->back()->with('error', 'Không tìm thấy đề thi có mã ' . $request->dethi_id);
    }
    public function XoaLich($id)
    {
        $dethi = DeThi::where('MaDe', $id)->first();

        // Kiểm tra xem có tồn tại không
        if (!$dethi) {
            return redirect()->route('ql-thi')->with('error', 'Không tìm thấy đề thi.');
        }

        $dethi->NgayThi = null;
        $dethi->ThoiGianBatDau = null;
        $dethi->ThoiGianKetThuc = null;
        $dethi->MaCBCT = null;
        $dethi->MaPT = null;
        $dethi->save();

        // Bước 3: Chuyển hướng người dùng đến trang danh sách người dùng
        return redirect()->route('ql-thi')->with('success', 'Lịch thi đã được xóa thành công.');
    }
    public function PhanBoSinhVien()
    {
        $dsmon = MonHoc::with('dsDeThi')->orderBy('MaMH', 'desc')->get();
        $dssinhvien = Users::where('RoleID', '=', '4')->orderBy('UserID', 'desc')->paginate(10);
        
        return view('quanly.phan-bo-sinh-vien', [
            'title' => 'Phân Bổ Sinh Viên',
            'dsmon' => $dsmon,
            'dssinhvien' => $dssinhvien,
            'monhoc_id' => null,
            'dethi_id' => null,
        ]);
    }
    public function getSinhVienByLichThi(Request $request)
    {
        $monhoc_id = $request->input('monhoc_id');
        $dethi_id = $request->input('dethi_id');

        if ($monhoc_id == null) {
            $dssinhvien = Users::where('RoleID', '=', '4')->orderBy('UserID', 'desc')->paginate(10);
        } else {
            // Nếu có môn học được chọn, lấy danh sách sinh viên chưa thi môn học đó
            $dssinhvien = Users::where('RoleID', '=', '4')
                ->whereDoesntHave('thi.deThi', function ($query) use ($monhoc_id) {
                    $query->where('MaMH', $monhoc_id);
                })
                ->orderBy('UserID', 'desc')
                ->paginate(10);
        }
        $dsmon = MonHoc::with('dsDeThi')->orderBy('MaMH', 'desc')->get();
        $dsdethi = DeThi::whereNotNull('MaPT')->orderBy('MaDe', 'desc')->get();
        return view('quanly.phan-bo-sinh-vien', [
            'title' => 'Phân Bổ Sinh Viên',
            'dsmon' => $dsmon,
            'dssinhvien' => $dssinhvien,
            'dsdethi' => $dsdethi,
            'monhoc_id' => $monhoc_id,
            'dethi_id' => $dethi_id,
        ]);
    }
    public function addSinhVienToLichThi(Request $request)
    {
        $sinhVienIDs = explode(',', $request->input('selectedSinhVien'));

        if (!empty($sinhVienIDs)) {
            $maMonHoc = $request->input('monhoc_id');
            $maDeThi = $request->input('dethi_id');
            if (empty($maDeThi)) {
                return redirect()->route('phan-bo-sinh-vien')->with('error', 'bạn chưa chọn đề thi và lọc sinh viên.');
            }
            // Lặp qua danh sách sinh viên đã chọn và thêm vào bảng thi
            foreach ($sinhVienIDs as $sinhVienID) {
                // Kiểm tra xem sinh viên đã có trong bảng thi hay chưa
                $exist = Thi::where('MaSV', $sinhVienID)
                    ->where('MaDe', $maDeThi)
                    ->exists();

                // Nếu chưa tồn tại, thêm vào bảng thi
                if (!$exist) {
                    $thi = new Thi();
                    $thi->MaSV = $sinhVienID;
                    $thi->MaDe = $maDeThi;
                    $thi->save();
                }
            }

            return redirect()->route('phan-bo-sinh-vien')->with('success', 'Đã thêm sinh viên vào lịch thi.');
        } else {
            return redirect()->route('phan-bo-sinh-vien')->with('error', 'Vui lòng chọn ít nhất một sinh viên để thêm vào lịch thi.');
        }
    }
}
