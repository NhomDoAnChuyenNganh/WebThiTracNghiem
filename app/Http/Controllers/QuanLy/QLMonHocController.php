<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Models\MonHoc;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Http\Request;

class QLMonHocController extends Controller
{
    public function QLMonHocForm()
    {
        $monhocs = MonHoc::orderBy('MaMH', 'desc')->paginate(10);

        return view('/quanly/ql-monhoc', [
            'monhocs' => $monhocs,
            'title' => 'Quản Lý Môn Học'
        ]);
    }

    public function themMonHoc(Request $request)
    {
        $request->validate([
            'ten_mon' => 'required',
        ]);

        // Kiểm tra xem tên môn học đã tồn tại hay chưa
        $existingMonHoc = MonHoc::where('TenMH', $request->input('ten_mon'))->first();

        if ($existingMonHoc) {
            // Nếu tên môn học đã tồn tại, bạn có thể thực hiện các hành động cần thiết, ví dụ: hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Tên môn học đã tồn tại. Vui lòng chọn tên khác.');
        }

        // Nếu tên môn học chưa tồn tại, thêm vào cơ sở dữ liệu
        $monHoc = new MonHoc;
        $monHoc->TenMH = $request->input('ten_mon');
        $monHoc->save();

        return redirect()->route('ql-monhoc')->with('success', 'Môn học đã được thêm thành công.');
    }

    public function suaMonHoc(Request $request, $id)
    {
        $request->validate([
            'ten_mon_edit' => 'required',
        ]);
        $existingMonHoc = MonHoc::where('TenMH', $request->input('ten_mon_edit'))->first();

        if ($existingMonHoc) {
            // Nếu tên môn học đã tồn tại, bạn có thể thực hiện các hành động cần thiết, ví dụ: hiển thị thông báo lỗi
            return redirect()->back()->with('error', 'Tên môn học đã tồn tại. Vui lòng chọn tên khác.');
        }
        $monHoc = MonHoc::find($id);
        $monHoc->TenMH = $request->input('ten_mon_edit');
        $monHoc->save();
        return redirect()->route('ql-monhoc')->with('success', 'Môn học đã được thay đổi thành công.');
    }

    public function xoaMonHoc($id)
    {
        $monHoc = MonHoc::where('MaMH', $id)->first();

        // Kiểm tra xem có tồn tại không
        if (!$monHoc) {
            return redirect()->route('ql-monhoc')->with('error', 'không tìm thấy môn học.');
        }


        try {
            // Bước 2: Thực hiện xóa 
            $monHoc->delete();

            // Bước 3: Chuyển hướng người dùng đến trang danh sách 
            return redirect()->route('ql-monhoc')->with('success', 'Môn học đã được xóa thành công.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == "23000") {
                return redirect()->back()->with('error', 'Không thể xóa môn học này do tồn tại các mối quan hệ liên quan.');
            }
        }
    }
    public function processFile(Request $request)
    {
        // Kiểm tra xem tệp đã được gửi lên hay không
        if ($request->hasFile('mh_file')) {
            // Lấy tệp từ biểu mẫu
            $file = $request->file('mh_file');

            // Kiểm tra định dạng tệp
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'xlsx') {

                // Đọc và xử lý tệp
                $mhsData = $this->processExcelFile($file);

                foreach ($mhsData as $mhData) {
                    MonHoc::create($mhData);
                }
                return redirect()->route('ql-monhoc')->with('success', 'Đã thêm danh sách thành công');
            } else {
                // Định dạng không hỗ trợ
                return redirect()->route('ql-monhoc')->with('error', 'Định dạng tệp chỉ hỗ trợ Excel');
            }
        }
        return redirect()->route('ql-user')->with('error', 'Vui lòng chọn một tệp để xử lý');
    }

    private function processExcelFile($file)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($file->getPathname());

        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();

        $mhsData = [];

        for ($row = 2; $row <= $highestRow; $row++) {

            if (MonHoc::where('TenMH', $sheet->getCell('B' . $row)->getValue())->exists()) {
                continue;
            }

            $mhsData[] = [
                'TenMH' => $sheet->getCell('B' . $row)->getValue(),
            ];
        }
        return $mhsData;
    }
}
