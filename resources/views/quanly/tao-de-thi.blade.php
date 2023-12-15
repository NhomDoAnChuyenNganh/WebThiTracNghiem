@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('ql-user'), 'label' => 'Quản lý người dùng'],
['url' => route('ql-monhoc'), 'label' => 'Quản lý môn học'],
['url' => route('ql-phongthi'), 'label' => 'Quản lý phòng thi'],
['url' => route('phan-bo-sinh-vien'), 'label' => 'Phân bổ sinh viên'],
['url' => route('tao-de-thi'), 'label' => 'Tạo đề thi'],
['url' => route('ql-thi'), 'label' => 'Quản lý thi'],
['url' => route('thong-ke'), 'label' => 'Thống kê']
]])

@section('content')
<div class="noidung" style="height: 1000px; width: 800px; background-color: white;margin: auto;">
    <div class="container">
        <div class="card-body">
            <h1>Tạo đề thi</h1>
            <form action="{{ route('luu_de_thi') }}" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label style="font-size: 25px; font-weight: bold;" for="ten_de_thi">Tên Đề Thi:</label>
                        <input type="text" class="form-control text-left" name="ten_de_thi" required>
                    </div>
                    <div class="col-md-4">
                        <label style="font-size: 25px; font-weight: bold;" for="so_luong_cau_hoi">Số Lượng Câu Hỏi:</label>
                        <input type="number" class="form-control text-left" name="so_luong_cau_hoi" required>
                    </div>
                    <div class="col-md-4">
                        <label style="font-size: 25px; font-weight: bold;" for="thoi-gian-lam-bai">Thời gian làm bài</label>
                        <input type="number" class="form-control text-left" name="thoi-gian-lam-bai" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label style="font-size: 25px; font-weight: bold;" for="ma_gvsd">Chọn Giáo Viên Soạn Đề:</label>
                        <select name="ma_gvsd" class="form-select text-left" required>
                            <option value=""></option>
                            @foreach ($gvsds as $gvsd)
                            <option value="{{ $gvsd->UserID }}">{{ $gvsd->HoTen }} - {{ $gvsd->Email }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label style="font-size: 25px; font-weight: bold;" for="ma_mon_hoc">Chọn Môn Học:</label>
                        <select name="ma_mon_hoc" class="form-select text-left" required>
                            <option value=""></option>
                            @foreach ($monhocs as $monhoc)
                            <option value="{{ $monhoc->MaMH }}">{{ $monhoc->TenMH }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="row mb-3 justify-content-center">
                    <div class="col-md-6 text-center">
                        <button type="submit" class="btn btn-success btn-lg mx-2">Tạo Đề Thi</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Môn Thi</th>
                <th>Tên Đề</th>
                <th>Số Câu</th>
                <th>Giáo Viên Soạn</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($desthies as $dethi)
            <tr>
                <td>{{ optional($dethi->MonHoc)->TenMH }}</td>
                <td>{{ $dethi->TenDeThi }}</td>
                <td>{{ $dethi->SoLuongCH }}</td>
                <td>{{ optional($dethi->giaoVienSoanDe)->HoTen }}</td>
                <td>
                    <a href="{{ route('xoa-de', ['id' => $dethi->MaDe]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch thi này?')">Xoá</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection