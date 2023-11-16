<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonHoc;

class MonHocController extends Controller
{
    //

    public function themMonHocForm()
    {
        return view(
            '/gv_soande/them-mon-hoc',
            ['title' => 'Thêm môn học']
        );
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
}
