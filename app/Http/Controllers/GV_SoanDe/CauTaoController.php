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

    public function luuCauHoi(Request $request, $ma_de, $ma_chuong)
    {
        // Xử lý lưu số lượng câu hỏi cho chương của đề thi
        // ...

        // Lưu vào bảng Cautao
        $cautao = new CauTao();
        $cautao->MaDe = $ma_de;
        $cautao->MaChuong = $ma_chuong;
        $cautao->SoLuongGioi = $request->so_luong_gioi;
        $cautao->SoLuongKha = $request->so_luong_kha;
        $cautao->SoLuongTB = $request->so_luong_tb;
        $cautao->save();

        // Có thể thêm các xử lý khác nếu cần

        return redirect()->route('gv_soande/soan-de')->with('success', 'Lưu câu hỏi thành công');
    }

    public function cautaoDeThi($id)
    {
        // Lấy thông tin đề thi
        $dethis = DeThi::find($id);

        // Lấy thông tin chương của môn học từ bảng chuong
        $chuongs = Chuong::where('MaMH', $dethis->MaMH)->get();

        return view('/gv_soande/sua-de-thi', [
            'dethis' => $dethis,
            'chuongs' => $chuongs,
            'title' => 'Sửa Đề Thi',
            'role' =>'Giáo Viên Soạn Đề'
        ]);
    }
    public function suaDeThi(Request $request, $id)
    {
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'gioi_') !== false || strpos($key, 'kha_') !== false || strpos($key, 'trungbinh_') !== false) {
                $maChuong = explode('_', $key)[1];
    
                // Sử dụng updateOrCreate để tạo mới hoặc cập nhật bản ghi
                $soLuongGioi = (int)$request->input('gioi_' . $maChuong);
                $soLuongKha = (int)$request->input('kha_' . $maChuong);
                $soLuongTB = (int)$request->input('trungbinh_' . $maChuong);
                $soLuongCH = $soLuongGioi + $soLuongKha + $soLuongTB;
    
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
                    $this->themCauHoiVaoDeThi($id, $maChuong);
                }
            }
        }
    
        return redirect()->route('soan-de')->with('success', 'Lưu số lượng câu hỏi thành công');
    }
    
    public function themCauHoiVaoDeThi($ma_de, $ma_chuong)
    {
        // Lấy thông tin câu hỏi từ ngân hàng câu hỏi dựa trên chương
        // và kiểu câu hỏi (giỏi, khá, trung bình) từ bảng CauHoi
        $cauHoiGioi = $this->layCauHoiNgauNhien($ma_chuong, 'Gioi');
        $cauHoiKha = $this->layCauHoiNgauNhien($ma_chuong, 'Kha');
        $cauHoiTrungBinh = $this->layCauHoiNgauNhien($ma_chuong, 'TrungBinh');

        // Thêm câu hỏi vào bảng Chitietdethi
        $this->themCauHoiVaoChitietdethi($ma_de, $cauHoiGioi);
        $this->themCauHoiVaoChitietdethi($ma_de, $cauHoiKha);
        $this->themCauHoiVaoChitietdethi($ma_de, $cauHoiTrungBinh);

        // Có thể thêm xử lý khác nếu cần
    }

    // Hàm lấy câu hỏi ngẫu nhiên từ ngân hàng câu hỏi dựa trên chương và kiểu câu hỏi
    private function layCauHoiNgauNhien($ma_chuong, $mucdo)
    {

        // Lấy danh sách đoạn văn của chương
        $doanVan = DoanVan::where('MaChuong', $ma_chuong)->inRandomOrder()->first();
        // Nếu có đoạn văn, lấy câu hỏi thuộc đoạn văn đó
        if ($doanVan) {
            $cauHoiNgauNhien = DB::table('cauhoi')
                ->where('MaDV', $doanVan->MaDV)
                ->where('MucDo', $mucdo)
                ->inRandomOrder()
                ->first();
            return $cauHoiNgauNhien;
        }

        return null; // Hoặc xử lý theo ý bạn khi không có đoạn văn
    }

    // Hàm thêm câu hỏi vào bảng Chitietdethi
    private function themCauHoiVaoChitietdethi($ma_de, $cauHoi)
    {

        // Thêm câu hỏi vào bảng Chitietdethi
        if ($cauHoi) {
            $chitietDeThi = new ChiTietDeThi();
            $chitietDeThi->MaDe = $ma_de;
            $chitietDeThi->MaCH = $cauHoi->MaCH;
            $chitietDeThi->save();
        }
    }    
    
}
