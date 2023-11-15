<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonHoc;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory;


class MonHocController extends Controller
{
    //

    public function themMonHocForm()
    {
        $monhocs = MonHoc::all();
        
        return view('/soande/them-mon-hoc', [
            'monhocs' => $monhocs,
            'title'=>'Thêm Môn Học'
        ]);
    }

    public function themMonHoc(Request $request)
    {
        $request->validate([
            'TenMH' => 'required',
        ]);

        $monHoc = new MonHoc;
        $monHoc->TenMH = $request->input('TenMH');
        $monHoc->save();

        return redirect('/soande/them-mon-hoc')->with('success', 'Thêm môn học thành công.');
    }

    public function suaMonHocForm($id)
    {
        $monHoc = MonHoc::find($id);

        return view('/soande/sua-mon-hoc', ['title' => 'Sửa Môn Học', 'monHoc' => $monHoc]);
    }

    public function suaMonHoc(Request $request, $id)
    {
        $request->validate([
            'TenMH' => 'required',
        ]);

        $monHoc = MonHoc::find($id);
        $monHoc->TenMH = $request->input('TenMH');
        $monHoc->save();

        return redirect('/soande/them-mon-hoc')->with('success', 'Sửa môn học thành công.');
    }

    public function xoaMonHoc($id)
    {
        $monHoc = MonHoc::find($id);
        // $monHoc->delete();

        // return redirect('/soande/them-mon-hoc')->with('success', 'Xóa môn học thành công.');
        if (!$monHoc) {
            return redirect('/soande/them-mon-hoc')->with('error', 'Không tìm thấy môn học.');
        }
    
        $monHoc->delete();
        return redirect('/soande/them-mon-hoc')->with('success', 'Xóa môn học thành công.');
    }

    public function themMonHocExcel(Request $request)
    {
        $file = $request->file('excel_file');

        if ($file) {
            $path = $file->store('uploads/excel_files');

            $reader = PHPExcel_IOFactory::load($path);
            $data = $reader->getActiveSheet()->toArray(null, true, true, true);

            foreach ($data as $row) {
                $monHoc = new MonHoc;
                $monHoc->TenMH = $row['TenMH'];
                $monHoc->save();
            }

            return redirect('/soande/them-mon-hoc')->with('success', 'Thêm môn học bằng file excel thành công.');
        } else {
            return redirect('/soande/them-mon-hoc')->with('error', 'Vui lòng chọn file excel.');
        }
    }

}
