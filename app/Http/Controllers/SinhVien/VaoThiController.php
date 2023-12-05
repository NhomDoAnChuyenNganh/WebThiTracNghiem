<?php

namespace App\Http\Controllers\SinhVien;

use App\Models\DeThi;
use App\Models\Thi;
use App\Models\MonHoc;
use App\Models\ChiTietDeThi;
use App\Models\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VaoThiController extends Controller
{
    public function index()
    {
        $userId = session('user');

        // Lấy danh sách đề thi của sinh viên với trạng thái là 0
        $query = Users::find($userId->UserID)
        ->thi()
        ->whereHas('deThi', function ($query) {
            $query->where('TrangThai', 0);
        })
        ->with(['deThi' => function ($query) {
            $query->orderBy('MaDe', 'desc');
        }]);
            // Áp dụng phân trang
        $dsDethi = $query->paginate(10);

        // Lấy danh sách mã môn học
        $dsMaMonHoc = [];
        foreach ($dsDethi as $dt) {
        $dsMaMonHoc[] = $dt->deThi->MaMH;
        }

        // Lấy danh sách môn học
        $dsMonHoc = MonHoc::whereIn('MaMH', $dsMaMonHoc)
        ->get();
        

        return view('sinhvien.thi', [
            'title' => 'Sinh Viên',
            'dslichthi' => $dsDethi,
            'dsmonhoc'=>$dsMonHoc
        ]);
    }
    public function getMonHocBySinhVien(Request $request)
    {
        $MonhocId = $request->input('monhoc_id');
        $userId = session('user');

        if ($MonhocId != null) {
            $query = Users::find($userId->UserID)
                ->thi()
                ->whereHas('deThi', function ($query) use ($MonhocId) {
                    $query->where('TrangThai', 0)
                        ->where('MaMH', $MonhocId);
                })
                ->with(['deThi' => function ($query) {
                    $query->orderBy('MaDe', 'desc');
                }]);
            $dsDethi = $query->paginate(10);
        } else {
            $query = Users::find($userId->UserID)
            ->thi()
            ->whereHas('deThi', function ($query) {
                $query->where('TrangThai', 0);
            })
            ->with(['deThi' => function ($query) {
                $query->orderBy('MaDe', 'desc');
            }]);
            $dsDethi = $query->paginate(10);
        }

        $query = Users::find($userId->UserID)
        ->thi()
        ->whereHas('deThi', function ($query) {
            $query->where('TrangThai', 0);
        })
        ->with('deThi');
            // Áp dụng phân trang
        $ds = $query->paginate(10);

        $dsMaMonHoc = [];
        foreach ($ds as $dt) {
            $dsMaMonHoc[] = $dt->deThi->MaMH;
        }

        // Lấy danh sách môn học từ bảng MonHoc
        $dsMonHoc = MonHoc::whereIn('MaMH', $dsMaMonHoc)
            ->get();

        return view('sinhvien.thi', [
            'title' => 'Sinh Viên',
            'dslichthi' => $dsDethi,
            'dsmonhoc'=>$dsMonHoc
        ]);
    }
    public function vaoThi($id)
    {
        $user = session('user');
        $dethi = DeThi::find($id);
       // Kiểm tra nếu thời gian hiện tại lớn hơn thời gian bắt đầu 20 phút
       $thoiGianBatDau = strtotime($dethi->ThoiGianBatDau); // Đổi thời gian bắt đầu từ chuỗi sang timestamp
       $thoiGianHienTai = time(); // Thời gian hiện tại

        if ($thoiGianHienTai > ($thoiGianBatDau + 200 * 60)) {
            // Nếu thời gian hiện tại lớn hơn thời gian bắt đầu 20 phút, hiển thị thông báo
            Thi::where('MaDe', $id)->where('MaSV', $user->UserID)->update([
                'SoCauDung' => 0,
                'Diem' => 0,
            ]);
            return redirect()->route('thi')->with('error', 'Bạn đã vào trễ quá thời gian quy định. Bạn bị 0 điểm');
        }
        // Lấy danh sách chi tiết đề thi của đề thi có mã $id
        $dsChiTietDeThi = ChiTietDeThi::with('cauhoi.dapan', 'cauhoi.loaicauhoi')->where('MaDe', $id)->get();

        // Danh sách câu hỏi và đáp án của đề thi
        $dsCauHoiVaDapAn = [];

        // Duyệt qua danh sách chi tiết đề thi
        foreach ($dsChiTietDeThi as $chiTiet) {
            $cauHoi = $chiTiet->cauhoi;
            $dapAn = $cauHoi->dapan;
            $loaiCauHoi = $cauHoi->loaicauhoi; // Thêm dòng này để lấy thông tin loại câu hỏi

            // Thêm thông tin câu hỏi và đáp án vào mảng
            $dsCauHoiVaDapAn[] = [
                'MaCauHoi' => $cauHoi->MaCH,
                'NoiDungCauHoi' => $cauHoi->NoiDung,
                'LoaiCauHoi' => $loaiCauHoi->TenLoai, // Thêm thông tin loại câu hỏi vào mảng
                'DanhSachDapAn' => $dapAn->map(function ($item) {
                    return [
                        'MaDapAn' => $item->MaDA,
                        'NoiDungDapAn' => $item->NoiDungDapAn,
                        'LaDapAnDung' => $item->LaDapAnDung,
                    ];
                })->all(),
            ];
        }
        // Thực hiện các thao tác khác cần thiết với danh sách câu hỏi và đáp án
        
        
        return view('sinhvien.vao-thi', [
            'title' => 'Sinh Viên',
            'dsCauHoiVaDapAn' => $dsCauHoiVaDapAn,
            'dethi' => $dethi
        ]);
    }
    public function ketQua(Request $request,$id)
    {
        $dethi = DeThi::find($id);
        $dsChiTietDeThi = ChiTietDeThi::with('cauhoi.dapan')->where('MaDe', $id)->get();

        // Danh sách câu hỏi và đáp án của đề thi
        $dsCauHoiVaDapAn = [];

        // Duyệt qua danh sách chi tiết đề thi
        foreach ($dsChiTietDeThi as $chiTiet) {
            $cauHoi = $chiTiet->cauhoi;
            $dapAn = $cauHoi->dapan;
            $loaiCauHoi = $cauHoi->loaicauhoi; // Thêm dòng này để lấy thông tin loại câu hỏi

            // Thêm thông tin câu hỏi và đáp án vào mảng
            $dsCauHoiVaDapAn[] = [
                'MaCauHoi' => $cauHoi->MaCH,
                'NoiDungCauHoi' => $cauHoi->NoiDung,
                'LoaiCauHoi' => $loaiCauHoi->TenLoai, // Thêm thông tin loại câu hỏi vào mảng
                'DanhSachDapAn' => $dapAn->map(function ($item) {
                    return [
                        'MaDapAn' => $item->MaDA,
                        'NoiDungDapAn' => $item->NoiDungDapAn,
                        'LaDapAnDung' => $item->LaDapAnDung,
                    ];
                })->all(),
            ];
        }
        // Xử lý kết quả từ form gửi lên
        $dapAnDaChon = $request->input('dap_an', []);
        $dapAnDienKhuyet = $request->input('dap_an_dien_khuyet', []);
        // Tổng số câu hỏi của đề thi
        $soLuongCH = $dethi->SoLuongCH;

        // Điểm mỗi câu hỏi
        $diemMoiCau = ($soLuongCH > 0) ? 10 / $soLuongCH : 0;
        // Tổng điểm
        $diem = 0;

        foreach ($dsCauHoiVaDapAn as $item) {
            $maCauHoi = $item['MaCauHoi'];
            $dapAnDung = collect($item['DanhSachDapAn'])->filter(function ($dapAn) {
                return $dapAn['LaDapAnDung'] == true;
            })->pluck('MaDapAn')->toArray();
            $dapAndienkhuyetdung = collect($item['DanhSachDapAn'])->filter(function ($dapAn) {
                return $dapAn['LaDapAnDung'] == true;
            })->pluck('NoiDungDapAn')->toArray();

            // Kiểm tra đáp án đúng và đáp án đã chọn
            if ($item['LoaiCauHoi'] == "Điền khuyết") 
            {
                $dapAnChon = isset($dapAnDienKhuyet[$maCauHoi]) ? $dapAnDienKhuyet[$maCauHoi] : '';
                if( $dapAnChon==[])
                {
                    $diem +=0;
                }
                else
                {
                    $diem += ($dapAnChon ==  $dapAndienkhuyetdung[0]) ? $diemMoiCau : 0; // Cộng điểm nếu đúng
                }
            } 
            else 
            {
                $dapAnChon = isset($dapAnDaChon[$maCauHoi]) ? $dapAnDaChon[$maCauHoi] : [];
                sort($dapAnChon);
                sort($dapAnDung);
                if( $dapAnChon==[])
                {
                    $diem +=0;
                }
                else
                {
                    $diem += ($dapAnChon == $dapAnDung) ? $diemMoiCau : 0;
                }
               
            }
        }

        // Tính điểm cuối cùng
        dd($diem);
    }
}
