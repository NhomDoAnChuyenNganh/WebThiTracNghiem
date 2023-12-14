<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\PhongThi;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Http\Request;

class QLPhongThiController extends Controller
{
    public function index()
    {
        $dsphong = PhongThi::orderBy('MaPT', 'desc')->paginate(10);
        return view('quanly.ql-phongthi', [
            'title' => 'Quản Lý Phòng Thi',
            'dsphong' => $dsphong,
        ]);
    }
    public function themPhongThi(Request $request)
    {
        $request->validate([
            'ten_phong' => 'required',
        ]);

        // Kiểm tra xem tên đã tồn tại hay chưa
        $existingPhongThi = PhongThi::where('TenPT', $request->input('ten_phong'))->first();

        if ($existingPhongThi) {
            // Nếu tên  đã tồn tại, bạn có thể thực hiện các hành động cần thiết, ví dụ: hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Tên phòng đã tồn tại. Vui lòng chọn tên khác.');
        }

        // Nếu tên chưa tồn tại, thêm vào cơ sở dữ liệu
        $phongthi = new PhongThi();
        $phongthi->TenPT = $request->input('ten_phong');
        $phongthi->save();

        return redirect()->route('ql-phongthi')->with('success', 'Phòng thi đã được thêm thành công.');
    }

    public function suaPhongThi(Request $request, $id)
    {
        $request->validate([
            'ten_phong_edit' => 'required',
        ]);
        $existingPhongthi = PhongThi::where('TenPT', $request->input('ten_phong_edit'))->first();

        if ($existingPhongthi) {
            // Nếu tên phòng đã tồn tại, bạn có thể thực hiện các hành động cần thiết, ví dụ: hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Tên phòng thi đã tồn tại. Vui lòng chọn tên khác.');
        }
        $phong = PhongThi::find($id);
        $phong->TenPT = $request->input('ten_phong_edit');
        $phong->save();
        return redirect()->route('ql-phongthi')->with('success', 'Phòng thi đã được thay đổi thành công.');
    }

    public function xoaPhongThi($id)
    {
        $phongthi = PhongThi::where('MaPT', $id)->first();

        // Kiểm tra xem có tồn tại không
        if (!$phongthi) {
            return redirect()->route('ql-phongthi')->with('error', 'không tìm thấy phòng thi.');
        }

        
        try {
            // Bước 2: Thực hiện xóa 
            $phongthi->delete();

            // Bước 3: Chuyển hướng người dùng đến trang danh sách 
            return redirect()->route('ql-phongthi')->with('success', 'Phòng thi đã được xóa thành công.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->back()->with('error', 'Không thể xóa phòng thi này do tồn tại các mối quan hệ liên quan.');
            }
        }
    }
    public function processFile(Request $request)
    {
        // Kiểm tra xem tệp đã được gửi lên hay không
        if ($request->hasFile('pt_file')) {
            // Lấy tệp từ biểu mẫu
            $file = $request->file('pt_file');

            // Kiểm tra định dạng tệp
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'xlsx') {

                // Đọc và xử lý tệp
                $ptsData = $this->processExcelFile($file);

                foreach ($ptsData as $ptData) {
                    PhongThi::create($ptData);
                }
                return redirect()->route('ql-phongthi')->with('success', 'Đã thêm danh sách thành công');
            } else {
                // Định dạng không hỗ trợ
                return redirect()->route('ql-phongthi')->with('error', 'Định dạng tệp chỉ hỗ trợ Excel');
            }
        }
        return redirect()->route('ql-phongthi')->with('error', 'Vui lòng chọn một tệp để xử lý');
    }

    private function processExcelFile($file)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($file->getPathname());

        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();

        $ptsData = [];

        for ($row = 2; $row <= $highestRow; $row++) {

            if (PhongThi::where('TenPT', $sheet->getCell('B' . $row)->getValue())->exists()) {
                continue;
            }

            $ptsData[] = [
                'TenPT' => $sheet->getCell('B' . $row)->getValue(),
            ];
        }
        return $ptsData;
    }
}
