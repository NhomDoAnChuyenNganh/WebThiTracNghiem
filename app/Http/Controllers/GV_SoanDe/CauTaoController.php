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
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Counts;
use PHPUnit\Framework\Constraint\Count;

class CauTaoController extends Controller
{
    //
    public function index()
    {

        $userId = session('user');
        // Lấy danh sách đề thi đ   ang phụ trách
        $dethis = Dethi::where('MaGVSD', $userId->UserID)->paginate(10);
        return view('gv_soande.soan-de', [
            'dethis' => $dethis,
            'title' => 'Giáo Viên Soạn Đề',
            'role' => 'Giáo Viên Soạn Đề'
        ]);
    }
    public function cautaoDeThi($id)
    {
        // Kiểm tra xem đã có chi tiết đề thi hay chưa
        $chitietdethi = ChiTietDeThi::where('MaDe', $id)->first();
        $cautaos = CauTao::where('MaDe', $id)->get();
        //$cautao1 = CauTao::find('MaDe',$id);
        $dethis = DeThi::find($id);
        if ($cautaos->isEmpty()) {
            $chuongs = Chuong::where('MaMH', $dethis->MaMH)->get();
            return view('/gv_soande/cau-tao-de', [
                'dethis' => $dethis,
                'chuongs' => $chuongs,
                'title' => 'Cấu Tạo Đề Thi',
                'role' => 'Giáo Viên Soạn Đề'
            ]);
        } else if (!$chitietdethi) {
            return view('/gv_soande/chi-tiet-de-thi', [
                'dethis' => $dethis,
                'cautaos' => $cautaos,
                'title' => 'Cấu Tạo Đề Thi',
                'role' => 'Giáo Viên Soạn Đề'
            ]);
        } else {
            $chitietdethis = ChiTietDeThi::where('MaDe', $id)->get();
            // Lấy danh sách mã câu hỏi từ bảng chitietdethi
            $maCauHoiArray = $chitietdethi->pluck('MaCH')->toArray();
            // Lấy tất cả câu hỏi của môn học từ bảng cauhoi chưa có trong chitietdethi
            $cauhoisChuaCo = CauHoi::whereIn('MaDV', DoanVan::whereIn('MaChuong', Chuong::where('MaMH', $chitietdethi->deThi->MaMH)->pluck('MaChuong')->toArray())->pluck('MaDV')->toArray())
                ->whereNotIn('MaCH', $maCauHoiArray)
                ->paginate(10);
            return view('/gv_soande/sua-de-thi', [
                'dethis' => $dethis,
                'cauhoisChuaCo' => $cauhoisChuaCo,
                'chitietdethis' => $chitietdethis,
                'title' => 'Sửa Đề Thi',
                'role' => 'Giáo Viên Soạn Đề'
            ]);
        }
    }
    public function cauTaoSoCauChuong(Request $request, $id)
    {
        $tongSoLuongCauHoi = 0;
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'tongcau_') !== false) {
                $maChuong = explode('_', $key)[1];

                $soLuongCH = (int)$request->input('tongcau_' . $maChuong);
                $tongSoLuongCauHoi = $tongSoLuongCauHoi + $soLuongCH;
                if ($soLuongCH > 0) {
                    CauTao::updateOrCreate(
                        ['MaDe' => $id, 'MaChuong' => $maChuong],
                        [
                            'SoLuongCH' => $soLuongCH,
                            'SoLuongGioi' => 0,
                            'SoLuongKha' => 0,
                            'SoLuongTB' => 0,
                        ]
                    );
                }
            }
        }
        // Kiểm tra nếu tổng số lượng câu hỏi của CauTao <= SoLuongCH của DeThi
        $soLuongCHDeThi = DeThi::find($id)->SoLuongCH;
        if ($tongSoLuongCauHoi != $soLuongCHDeThi) {
            // Xóa hết chi tiết câu hỏi cũ của đề thi
            CauTao::where('MaDe', $id)->delete();
            // Xử lý khi tổng số lượng câu hỏi vượt quá SoLuongCH của DeThi
            return back()->with('error', 'Tổng số lượng câu hỏi các CHƯƠNG phải bằng số lượng câu hỏi của ĐỀ THI');
        }
        return redirect()->route('cau-tao-de-thi', ['id' => $id])->with('success', 'Lưu số lượng câu hỏi từng chương thành công');
    }

    public function cauTaoMucDoCauHoi(Request $request, $id)
    {
        $updateData = [];
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'gioi_') !== false) {
                $maChuong = explode('_', $key)[1];
                // Sử dụng updateOrCreate để tạo mới hoặc cập nhật bản ghi
                $soLuongGioi = (int)$request->input('gioi_' . $maChuong);
                $soLuongKha = (int)$request->input('kha_' . $maChuong);
                $soLuongTB = (int)$request->input('trungbinh_' . $maChuong);
                $cautao = CauTao::where('MaDe', $id)->where('MaChuong', $maChuong)->first();
                // Kiểm tra nếu tổng số lượng câu hỏi của CauTao <= SoLuongCH của DeThi
                $tongCHMucDo = $soLuongGioi + $soLuongKha + $soLuongTB;
                if ($tongCHMucDo != $cautao->SoLuongCH) {
                    // Xử lý khi tổng số lượng câu hỏi vượt quá SoLuongCH của DeThi
                    return back()->with('error', 'Tổng số lượng câu hỏi của các MỨC ĐỘ không được quá số lượng câu hỏi của CHƯƠNG');
                }
                // Thêm thông tin cần cập nhật vào mảng
                $updateData[] = [
                    'MaChuong' => $maChuong,
                    'SoLuongTB' => $soLuongTB,
                    'SoLuongKha' => $soLuongKha,
                    'SoLuongGioi' => $soLuongGioi,
                ];
            }
        }
        foreach ($updateData as $data) {
            CauTao::where(['MaDe' => $id, 'MaChuong' => $data['MaChuong']])
                ->update([
                    'SoLuongTB' => $data['SoLuongTB'],
                    'SoLuongKha' => $data['SoLuongKha'],
                    'SoLuongGioi' => $data['SoLuongGioi'],
                ]);
            $this->themCauHoiVaoDeThi($id, $data['MaChuong']);
        }

        return redirect()->route('soan-de')->with('success', 'Thêm số lượng câu hỏi từng mức độ thành công');
    }

    public function themCauHoiRand($id)
    {
        $cautaos = CauTao::where('MaDe', $id)->get();
        foreach ($cautaos as $data) {
            $cauhoiRand = $this->layCauHoiNgauNhien($data->MaChuong, $data->SoLuongCH);
            foreach ($cauhoiRand as $cauHoi) {
                $this->themCauHoiVaoChitietdethi($id, $cauHoi);
            }
        }

        return redirect()->route('soan-de')->with('success', 'Thêm câu hỏi ngẫu nhiên thành công');
    }

    private function themCauHoiVaoDeThi($ma_de, $ma_chuong)
    {
        $deThiInfo = CauTao::where('MaDe', $ma_de)->where('MaChuong', $ma_chuong)->first();

        if ($deThiInfo) {
            $soLuongGioi = $deThiInfo->SoLuongGioi;
            $soLuongKha = $deThiInfo->SoLuongKha;
            $soLuongTB = $deThiInfo->SoLuongTB;
            // Lấy câu hỏi ngẫu nhiên từ ngân hàng câu hỏi dựa trên chương
            $cauHoiGioi = $this->layCauHoiNgauNhienMucDo($ma_chuong, 'Giỏi', $soLuongGioi);
            $cauHoiKha = $this->layCauHoiNgauNhienMucDo($ma_chuong, 'Khá', $soLuongKha);
            $cauHoiTrungBinh = $this->layCauHoiNgauNhienMucDo($ma_chuong, 'Trung Bình', $soLuongTB);
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
        }
    }

    private function layCauHoiNgauNhien($maChuong, $soLuong)
    {
        $doanVanList = DoanVan::where('MaChuong', $maChuong)->get();

        $cauHoiNgauNhien = collect();

        foreach ($doanVanList as $doanVan) {
            $cauHoi = DB::table('cauhoi')
                ->where('MaDV', $doanVan->MaDV)
                ->get();

            $cauHoiNgauNhien = $cauHoiNgauNhien->merge($cauHoi);
        }

        // Trộn ngẫu nhiên để đảm bảo sự ngẫu nhiên giữa các đoạn văn
        $cauHoiNgauNhien = $cauHoiNgauNhien->shuffle();

        return $cauHoiNgauNhien->take($soLuong);
    }


    private function layCauHoiNgauNhienMucDo($ma_chuong, $mucdo, $soLuong)
    {
        // Lấy danh sách đoạn văn của chương
        $doanVanList = DoanVan::where('MaChuong', $ma_chuong)->get();

        $cauHoiNgauNhien = collect();

        foreach ($doanVanList as $doanVan) {
            $cauHoi = DB::table('cauhoi')
                ->where('MaDV', $doanVan->MaDV)
                ->where('MucDo', $mucdo)
                ->get();

            $cauHoiNgauNhien = $cauHoiNgauNhien->merge($cauHoi);
        }

        // Trộn ngẫu nhiên để đảm bảo sự ngẫu nhiên giữa các đoạn văn
        $cauHoiNgauNhien = $cauHoiNgauNhien->shuffle();

        return $cauHoiNgauNhien->take($soLuong);
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
        } else {
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
}
