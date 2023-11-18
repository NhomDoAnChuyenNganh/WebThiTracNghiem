@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('ql-user'), 'label' => 'Quản lý người dùng'],
['url' => route('ql-monhoc'), 'label' => 'Quản lý môn học'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân công giáo viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân công cán bộ'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân bổ sinh viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Thống kê']
]])

@section('content')
<div class="noidung" style="height: 1000px; width: 600px; background-color: white;margin: auto;">
    <form action="{{ route('processFile') }}" method="POST" enctype="multipart/form-data" id="fileForm">
        @csrf
        <div style="display: flex; align-items: center; margin-left: 20px;">
            <div style="margin-left: auto; margin-right: 85px; margin-top: 20px;">
                <a href="{{ route('insertUser') }}" class="btn btn-primary" style="max-width: 80px; margin-right: 10px;">Thêm</a>
                <label for="fileInput" class="btn btn-primary" style="max-width: 100px; margin: 0;">Add File</label>
                <input type="file" id="fileInput" name="user_file" accept=".xlsx, .docx" style="display: none;">
                <input type="submit" style="display: none;">
            </div>
        </div>
    </form>
    <script>
        document.getElementById('fileInput').addEventListener('change', function() {
            // Hiển thị sự kiện submit khi người dùng đã chọn tệp
            document.getElementById('fileForm').submit();
        });
    </script>
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
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Tên Môn Học</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monhocs as $monhoc)
            <tr>
                <td></td>
                <td>{{ $monhoc->TenMH }}</td>
                <td></td>
                <td>
                    <a href="" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xoá</a>
                    <a href="" class="btn btn-primary" style="max-width: 80px;">Sửa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection