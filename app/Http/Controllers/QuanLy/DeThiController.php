<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\DeThi;
use App\Models\MonHoc;
use App\Models\Users;
use Illuminate\Http\Request;

class DeThiController extends Controller
{
    //
    public function getTaoDeThi()
    {
        // Lấy danh sách môn học và chương từ cơ sở dữ liệu
        $gvsds = Users::where('RoleID', 2)->get(); // Lấy danh sách giáo viên soạn đề
        $monhocs = MonHoc::all(); // Lấy danh sách môn học
        return view('quanly.tao-de-thi',[
            'monhocs' => $monhocs,
            'gvsds' => $gvsds,
            'title'=>'Quản Lý',
            'role' =>'Admin' 
        ]);
    }
    public function luuDeThi(Request $request)
    {
        // Xử lý lưu đề thi vào cơ sở dữ liệu
        $dethi = new DeThi();
        $dethi->TenDeThi = $request->input('ten_de_thi');
        $dethi->SoLuongCH = $request->input('so_luong_cau_hoi');
        $dethi->MaGVSD = $request->input('ma_gvsd');
        $dethi->MaMH = $request->input('ma_mon_hoc');
        // Thêm các trường khác nếu cần
        $dethi->save();
        return redirect('quanly/tao-de-thi')->with('success', 'Đề thi đã được tạo thành công!');
    }
}
