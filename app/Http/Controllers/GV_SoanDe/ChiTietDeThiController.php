<?php

namespace App\Http\Controllers\GV_SoanDe;

use App\Http\Controllers\Controller;
use App\Models\ChiTietDeThi;
use App\Models\DeThi;
use Illuminate\Http\Request;

class ChiTietDeThiController extends Controller
{
    //
    public function suaChiTietDeThi($id, Request $request)
    {
        // Validate dữ liệu đầu vào nếu cần

        // Lấy danh sách mã câu hỏi từ form
        $maCauHoiArray = $request->input('cauhoi_id', []);
        $slCauHoi = count($maCauHoiArray);
        $soCauDeThi = DeThi::find($id)->SoLuongCH;
        $soCauChiTietDeThi = ChiTietDeThi::where('MaDe', $id)->count();
        $tongSoLuongCauHoi = $slCauHoi + $soCauChiTietDeThi;
        //KT số lượng câu hỏi thêm vào
        if($tongSoLuongCauHoi > $soCauDeThi) {
            return back()->with('error', 'Số lượng câu hỏi thêm vào không được vượt số lượng câu hỏi của ĐỀ THI');
        } 
        else
        {
            // Lưu chi tiết câu hỏi mới vào đề thi
            foreach ($maCauHoiArray as $maCauHoi) {
                ChiTietDeThi::create([
                    'MaDe' => $id,
                    'MaCH' => $maCauHoi,
                ]);
            }

            // Redirect về trang xem đề thi hoặc trang chính với thông báo thành công
            return redirect()->route('cau-tao-de-thi',['id' => $id])->with('success', 'Lưu số lượng câu hỏi thành công');
        }

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
