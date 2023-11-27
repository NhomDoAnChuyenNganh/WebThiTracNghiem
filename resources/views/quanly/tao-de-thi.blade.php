@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('ql-user'), 'label' => 'Quản lý người dùng'],
['url' => route('ql-monhoc'), 'label' => 'Quản lý môn học'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân công giáo viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân công cán bộ'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân bổ sinh viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Thống kê']
]])

@section('content')
   <div class="container">
        <h1>Tạo đề thi</h1>

        <form action="{{ route('luu_de_thi') }}" method="post">
            @csrf
            <label for="ten_de_thi">Tên Đề Thi:</label>
            <input type="text" name="ten_de_thi" required>
    
            <label for="so_luong_cau_hoi">Số Lượng Câu Hỏi:</label>
            <input type="number" name="so_luong_cau_hoi" required>
    
            <label for="ma_gvsd">Chọn Giáo Viên Soạn Đề:</label>
            <select name="ma_gvsd" required>
                @foreach ($gvsds as $gvsd)
                    <option value="{{ $gvsd->UserID }}">{{ $gvsd->Email }}</option>
                @endforeach
            </select>
    
            <label for="ma_mon_hoc">Chọn Môn Học:</label>
            <select name="ma_mon_hoc" required>
                @foreach ($monhocs as $monhoc)
                    <option value="{{ $monhoc->MaMH }}">{{ $monhoc->TenMH }}</option>
                @endforeach
            </select>
    
            <!-- Thêm các trường khác nếu cần -->
    
            <button class="btn btn-primary" type="submit">Tạo Đề Thi</button>
        </form>
    </div>

@endsection