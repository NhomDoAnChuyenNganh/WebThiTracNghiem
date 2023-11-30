<?php

namespace App\Http\Controllers\GV_SoanDe;

use App\Http\Controllers\Controller;
use App\Models\CauHoi;
use App\Models\CauTao;
use App\Models\ChiTietDeThi;
use App\Models\Chuong;
use App\Models\DeThi;
use App\Models\DoanVan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CauTaoController extends Controller
{
    //
    public function index()
    {
        
        $userId = session('user');
        // Lấy danh sách đề thi đ   ang phụ trách
        $dethis = Dethi::where('MaGVSD', $userId->UserID)->get();
        return view('gv_soande.soan-de',[
            'dethis' => $dethis,
            'title'=>'Giáo Viên Soạn Đề',
            'role' =>'Giáo Viên Soạn Đề' 
        ]);
    }
    public function cautaoDeThi($id)
    {
        // Kiểm tra xem đã có chi tiết đề thi hay chưa
        $chitietdethi = ChiTietDeThi::where('MaDe', $id)->first();
        $dethis = DeThi::find($id);
        if (!$chitietdethi) {

            // Lấy thông tin chương của môn học từ bảng chuong
            $chuongs = Chuong::where('MaMH', $dethis->MaMH)->get();


            return view('/gv_soande/cau-tao-de', [
                'dethis' => $dethis,
                'chuongs' => $chuongs,
                'title' => 'Sửa Đề Thi',
                'role' => 'Giáo Viên Soạn Đề'
            ]);
        } else {
            $chitietdethis = ChiTietDeThi::where('MaDe', $id)->get();
            // Lấy danh sách mã câu hỏi từ bảng chitietdethi
            $maCauHoiArray = $chitietdethi->pluck('MaCH')->toArray();
            // Lấy tất cả câu hỏi của môn học từ bảng cauhoi chưa có trong chitietdethi
            $cauhoisChuaCo = CauHoi::whereIn('MaDV', DoanVan::whereIn('MaChuong', Chuong::where('MaMH', $chitietdethi->deThi->MaMH)->pluck('MaChuong')->toArray())->pluck('MaDV')->toArray())
            ->whereNotIn('MaCH', $maCauHoiArray)
            ->get();
            return view('/gv_soande/sua-de-thi', [
                'dethis' => $dethis,
                'cauhoisChuaCo' => $cauhoisChuaCo,
                'chitietdethis' => $chitietdethis,
                'title' => 'Sửa Đề Thi',
                'role' => 'Giáo Viên Soạn Đề'
            ]);
        }
    }


    public function suaDeThi(Request $request, $id)
    {
        $tongSoLuongCauHoi = 0;
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'gioi_') !== false) {
                $maChuong = explode('_', $key)[1];

                // Sử dụng updateOrCreate để tạo mới hoặc cập nhật bản ghi
                $soLuongGioi = (int)$request->input('gioi_' . $maChuong);
                $soLuongKha = (int)$request->input('kha_' . $maChuong);
                $soLuongTB = (int)$request->input('trungbinh_' . $maChuong);
                $soLuongCH = (int)$request->input('tongcau_' . $maChuong);
                // Kiểm tra nếu tổng số lượng câu hỏi của CauTao <= SoLuongCH của DeThi
                $soLuongCHDeThi = DeThi::find($id)->SoLuongCH;
                $tongSoLuongCauHoi = $tongSoLuongCauHoi + $soLuongCH;
                $tongCHMucDo = $soLuongGioi + $soLuongKha + $soLuongTB;

                if($tongCHMucDo > $soLuongCH) {
                    // Xóa hết chi tiết câu hỏi cũ của đề thi
                    ChiTietDeThi::where('MaDe', $id)->delete();
                    // Xử lý khi tổng số lượng câu hỏi vượt quá SoLuongCH của DeThi
                    return back()->with('error', 'Tổng số lượng câu hỏi của các MỨC ĐỘ không được quá số lượng câu hỏi của CHƯƠNG');
                } 

                if($tongSoLuongCauHoi > $soLuongCHDeThi) {
                    // Xóa hết chi tiết câu hỏi cũ của đề thi
                    ChiTietDeThi::where('MaDe', $id)->delete();
                    // Xử lý khi tổng số lượng câu hỏi vượt quá SoLuongCH của DeThi
                    return back()->with('error', 'Tổng số lượng câu hỏi các CHƯƠNG vượt quá số lượng câu hỏi của ĐỀ THI');
                } 

                if ($soLuongCH > 0) {
                    CauTao::updateOrCreate(
                        ['MaDe' => $id, 'MaChuong' => $maChuong],
                        [
                            'SoLuongGioi' => $soLuongGioi,
                            'SoLuongKha' => $soLuongKha,
                            'SoLuongTB' => $soLuongTB,
                            'SoLuongCH' => $soLuongCH,
                        ]
                    );
                }
                $this->themCauHoiVaoDeThi($id, $maChuong);
            }
        }
        return redirect()->route('soan-de')->with('success', 'Lưu số lượng câu hỏi thành công');
    }
    
    private function themCauHoiVaoDeThi($ma_de, $ma_chuong)
    {
        $deThiInfo = CauTao::where('MaDe', $ma_de)->where('MaChuong', $ma_chuong)->first();
    
        if ($deThiInfo) {
            $soLuongGioi = $deThiInfo->SoLuongGioi;
            $soLuongKha = $deThiInfo->SoLuongKha;
            $soLuongTB = $deThiInfo->SoLuongTB;
            $soCHConLai = $deThiInfo->SoLuongCH - $soLuongGioi - $soLuongKha - $soLuongTB;
            // Lấy câu hỏi ngẫu nhiên từ ngân hàng câu hỏi dựa trên chương
            $cauHoiGioi = $this->layCauHoiNgauNhienMucDo($ma_chuong, 'Giỏi', $soLuongGioi);
            $cauHoiKha = $this->layCauHoiNgauNhienMucDo($ma_chuong, 'Khá', $soLuongKha);
            $cauHoiTrungBinh = $this->layCauHoiNgauNhienMucDo($ma_chuong, 'Trung Bình', $soLuongTB);
            $cauHoiConLai = $this->layCauHoiNgauNhien($ma_chuong, $soCHConLai);
            // Thêm câu hỏi vào bảng Chitietdethi
            foreach ($cauHoiGioi as $cauHoi) {
                $this->themCauHoiVaoChitietdethi($ma_de, $cauHoi);
            }
            foreach ($cauHoiKha as $cauHoi) {
                $this->themCauHoiVaoChitietdethi($ma_de, $cauHoi);
            }
            foreach ($cauHoiTrungBinh as $cauHoi) {
                $this->themCauHoiVaoChitietdethi($ma_de, $cauHoi);
            }
            foreach ($cauHoiConLai as $cauHoi) {
                $this->themCauHoiVaoChitietdethi($ma_de, $cauHoi);
            }
        }
    }

    private function layCauHoiNgauNhien($ma_chuong, $soLuong)
    {
        // Lấy danh sách đoạn văn của chương
        $doanVan = DoanVan::where('MaChuong', $ma_chuong)->inRandomOrder()->first();
        // Nếu có đoạn văn, lấy câu hỏi thuộc đoạn văn đó
        if ($doanVan) {
            $cauHoiNgauNhien = DB::table('cauhoi')
                ->where('MaDV', $doanVan->MaDV)
                ->inRandomOrder()
                ->limit($soLuong)
                ->get();
            return $cauHoiNgauNhien;
        }
        return $this->layCauHoiNgauNhien($ma_chuong, $soLuong);
    }

    private function layCauHoiNgauNhienMucDo($ma_chuong, $mucdo, $soLuong)
    {
        // Lấy danh sách đoạn văn của chương
        $doanVan = DoanVan::where('MaChuong', $ma_chuong)->inRandomOrder()->first();
        // Nếu có đoạn văn, lấy câu hỏi thuộc đoạn văn đó
        if ($doanVan) {
            $cauHoiNgauNhien = DB::table('cauhoi')
                ->where('MaDV', $doanVan->MaDV)
                ->where('MucDo', $mucdo)
                ->inRandomOrder()
                ->limit($soLuong)
                ->get();
            return $cauHoiNgauNhien;
        }
        return $this->layCauHoiNgauNhienMucDo($ma_chuong, $mucdo, $soLuong);
    }

    private function themCauHoiVaoChitietdethi($ma_de, $cauHoi)
    {
        // Kiểm tra trước khi thêm mới
        $kiemTraTonTai = ChiTietDeThi::where('MaDe', $ma_de)
            ->where('MaCH', $cauHoi->MaCH)
            ->exists();
        // Nếu chưa tồn tại, thêm mới
        if (!$kiemTraTonTai && $cauHoi && !empty($cauHoi)) {
            $chitietDeThi = new ChiTietDeThi();
            $chitietDeThi->MaDe = $ma_de;
            $chitietDeThi->MaCH = $cauHoi->MaCH;
            $chitietDeThi->save();
        }else {
            $ma_dv = $cauHoi->MaDV;
            $mucdo = $cauHoi->MucDo;
            $doanvans = DoanVan::where('MaDV', $ma_dv)->first();
            $ma_chuong = $doanvans->MaChuong;
            // Nếu đã tồn tại, lấy câu hỏi ngẫu nhiên khác và thêm vào
            $cauHoiMoi = $this->layCauHoiNgauNhienMucDo($ma_chuong, $mucdo, 1); // Số lượng câu hỏi là 1
            if ($cauHoiMoi) {
                $this->themCauHoiVaoChitietdethi($ma_de, $cauHoiMoi[0]); // Lấy câu hỏi đầu tiên từ danh sách
            }
        }
    }

    public function luuSoLuongCauHoi($id, Request $request)
    {
        // Lấy danh sách mã câu hỏi từ form
        $maCauHoiArray = $request->input('cauhoi_id', []);

        // Lưu chi tiết câu hỏi mới vào đề thi
        foreach ($maCauHoiArray as $maCauHoi) {
            ChiTietDeThi::create([
                'MaDe' => $id,
                'MaCH' => $maCauHoi,
            ]);
        }

        // Redirect về trang xem đề thi hoặc trang chính với thông báo thành công
        return redirect()->route('soan-de')->with('success', 'Lưu số lượng câu hỏi thành công');
    }
    public function xoaCauHoi(Request $request)
    {
        $maCauHoi = $request->input('maCauHoi');
        $maDe = $request->input('maDe');

        // Xoá chi tiết câu hỏi từ bảng ChiTietDeThi
        ChiTietDeThi::where('MaDe', $maDe)
            ->where('MaCH', $maCauHoi)
            ->delete();

        // Trả về thông báo thành công hoặc lỗi (nếu cần)
        return response()->json(['success' => true]);
    }
    
}


