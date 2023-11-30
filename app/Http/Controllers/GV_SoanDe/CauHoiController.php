<?php

namespace App\Http\Controllers\GV_SoanDe;

use App\Http\Controllers\Controller;
use App\Models\CauHoi;
use App\Models\DoanVan;
use App\Models\DapAn;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Http\Request;

class CauHoiController extends Controller
{
    public function index()
    {
        // Lấy tất cả câu hỏi từ cơ sở dữ liệu
        $cauhois = CauHoi::paginate(10);

        // Trả về view và truyền biến $cauhois vào view
        return view('gv_soande.danh-sach-cau-hoi', compact('cauhois'), ['title' => 'Danh sách câu hỏi']);
    }
    public function processFile(Request $request)
    {
        // Kiểm tra xem tệp đã được gửi lên hay không
        if ($request->hasFile('user_file')) {
            // Lấy tệp từ biểu mẫu
            $file = $request->file('user_file');

            // Kiểm tra định dạng tệp
            $extension = $file->getClientOriginalExtension();
            if ($extension == 'xlsx') {
                // Đọc và xử lý tệp
                $cauHoiData = $this->processExcelFile($file);

                // Lưu dữ liệu vào database
                foreach ($cauHoiData as $cauHoi) {
                    $maDV = $cauHoi['cau_hoi']['MaDV'];
                    if (!$maDV) {
                        // Xử lý trường hợp không tìm thấy MaDV
                        continue;
                    }

                    $cauHoiModel = new CauHoi([
                        'NoiDung' => $cauHoi['cau_hoi']['NoiDung'],
                        'MaDV' => $maDV,
                        'MaLoai' => $cauHoi['cau_hoi']['MaLoai'],
                        'MucDo' => $cauHoi['cau_hoi']['MucDo'],
                    ]);

                    $cauHoiModel->save();

                    foreach ($cauHoi['dap_an'] as $dapAn) {
                        $isDapAnDung = $dapAn['LaDapAnDung'];
                        $dapAnModel = new DapAn([
                            'NoiDungDapAn' => $dapAn['NoiDungDapAn'],
                            'LaDapAnDung' => $isDapAnDung,
                            'MaCH' => $cauHoiModel->MaCH,
                        ]);

                        $dapAnModel->save();
                    }
                }

                return redirect()->route('danh-sach-cau-hoi')->with('success', 'Đã thêm danh sách câu hỏi thành công');
            } else {
                // Định dạng không hỗ trợ
                return redirect()->route('danh-sach-cau-hoi')->with('error', 'Định dạng tệp chỉ hỗ trợ Excel');
            }
        }

        // Không có tệp được gửi lên
        return redirect()->route('danh-sach-cau-hoi')->with('error', 'Vui lòng chọn một tệp để xử lý');
    }

    private function processExcelFile($file)
    {
        $reader = new Xlsx();
        $spreadsheet = $reader->load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();

        $cauHoiData = [];

        for ($row = 2; $row <= $highestRow; $row++) {
            $cauHoi = [
                'NoiDung' => $sheet->getCell('F' . $row)->getValue(),
                'MaDV' => $this->getMaDV($sheet->getCell('C' . $row)->getValue()),
                'MaLoai' => $sheet->getCell('D' . $row)->getValue(),
                'MucDo' => $sheet->getCell('E' . $row)->getValue(),
            ];

            // Xử lý đáp án
            $dapAn = [];
            $loaiCauHoi = $sheet->getCell('D' . $row)->getValue();
            if ($loaiCauHoi == '3') {
                $dapAn[] = [
                    'NoiDungDapAn' => $sheet->getCell('G' . $row)->getValue(),
                    'LaDapAnDung' => true
                ];
            } else {
                for ($i = 'H'; $i <= 'M'; $i++) {
                    $luaChon = $sheet->getCell($i . $row)->getValue();
                    $tenCot = $sheet->getCell($i . 1)->getValue();
                    $kyTu = substr($tenCot, -1);


                    if (!empty($luaChon)) {
                        $dapAn[] = [
                            'NoiDungDapAn' => $luaChon,
                            'LaDapAnDung' => stripos($sheet->getCell('G' . $row)->getValue(), $kyTu) !== false
                        ];
                    }
                }
            }

            $cauHoiData[] = [
                'cau_hoi' => $cauHoi,
                'dap_an' => $dapAn,
            ];
        }

        return $cauHoiData;
    }

    private function getMaDV($tenDoanVan)
    {
        $doanVan = DoanVan::where('TenDV', $tenDoanVan)->first();

        return $doanVan ? $doanVan->MaDV : null;
    }

    public function themCauHoi(Request $request)
    {
        // Validate dữ liệu đầu vào từ form
        $request->validate([
            'MonHoc' => 'required',
            'MaChuong' => 'required',
            'DoanVan' => 'required',
            'NoiDung' => 'required',
            'MucDo' => 'required',
            'questionType' => 'required',
            'answer' => 'required|array',
        ]);

        // Tạo một câu hỏi mới
        $cauHoi = new CauHoi([
            'NoiDung' => $request->input('NoiDung'),
            'MaDV' => $request->input('DoanVan'),
            'MaLoai' => $request->input('questionType'),
            'MucDo' => $request->input('MucDo'),
        ]);

        // Lưu câu hỏi vào cơ sở dữ liệu
        $cauHoi->save();

        // Lấy danh sách câu trả lời từ request
        $answers = $request->input('answer');

        // Tạo các đáp án tương ứng và lưu vào cơ sở dữ liệu
        foreach ($answers as $key => $answer) {
            $dapAn = new DapAn([
                'NoiDungDapAn' => $answer,
                'LaDapAnDung' => $this->calculateLaDapAnDung($request->input('questionType'), $key),
                'MaCH' => $cauHoi->MaCH,
            ]);

            $dapAn->save();
        }

        return redirect()->back()->with('success', 'Câu hỏi đã được thêm thành công.');
    }

    private function calculateLaDapAnDung($questionType, $index)
    {
        if ($questionType == '1') {
            // Loại câu hỏi 1: Chọn 1 kết quả (radio)
            return $index == 0; // Chọn radio đầu tiên làm đáp án đúng
        } elseif ($questionType == '2') {
            // Loại câu hỏi 2: Chọn nhiều kết quả (checkbox)
            return true; // Tất cả đều là đáp án đúng
        } elseif ($questionType == '3') {
            // Loại câu hỏi 3: Điền khuyết
            return true; // Luôn luôn là đáp án đúng
        }

        return false;
    }
}
