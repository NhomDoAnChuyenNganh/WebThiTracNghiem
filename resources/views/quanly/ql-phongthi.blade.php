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
<div class="noidung" style="height: 1000px; width: 600px; background-color: white;margin: auto;">
    <div>
        <form action="{{ route('insert-phongthi') }}" method="POST" style="display: inline-block;">
            @csrf
            <div style="display:block; align-items: center; margin-left: 20px;">
                <div style="margin-left: auto; margin-right: 10px;"> <!-- Giảm margin-right để giữ nút "Thêm File" sát bên -->
                    <label for="ten_phong">Tên Phòng Thi:</label>
                    <input type="text" id="ten_phong" name="ten_phong" required>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </form>

        <form action="{{ route('processFilePT') }}" method="POST" enctype="multipart/form-data" id="fileForm" style="display: inline-block;">
            @csrf
            <div style="display: flex; align-items: center; margin-left: 20px;">
                <div style="margin-top: 20px;"> <!-- Giảm margin-top để giữ nút "Thêm File" sát bên -->
                    <label for="fileInput" class="btn btn-primary" style="max-width: 100px; margin: 0;">Thêm File</label>
                    <input type="file" id="fileInput" name="pt_file" accept=".xlsx, .docx" style="display: none;">
                    <input type="submit" style="display: none;">
                </div>
            </div>
        </form>
    </div>
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
                <th style="text-align: center;">STT</th>
                <th>Tên Phòng</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 1;
            @endphp
            @foreach($dsphong as $phong)
            <tr>
                <td style="text-align: center;">{{ $counter++ }}</td>
                <td>{{ $phong->TenPT }}</td>
                <td></td>
                <td>
                    <a href="{{ route('delete-phongthi', ['id' => $phong->MaPT]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa phòng thi này?')">Xoá</a>
                    <button class="btn btn-primary" style="max-width: 80px;" onclick="showEditForm('{{ $counter }}')">Sửa</button>
                    <!-- Form sửa ẩn đi ban đầu -->
                    <div class="editForm" id="editForm{{ $counter }}" style="display: none;">
                        <form action="{{ route('update-phongthi', ['id' => $phong->MaPT]) }}" method="POST">
                            @csrf
                            <input type="text" name="ten_phong_edit" value="{{ $phong->TenPT }}">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dsphong->onEachSide(1)->links() }}<br />
</div>
<script>
    function showEditForm(counter) {
        // Lấy đối tượng div chứa form sửa dựa trên counter
        var editForm = document.getElementById('editForm' + counter);

        // Hiển thị hoặc ẩn form sửa tùy thuộc vào trạng thái hiện tại
        if (editForm.style.display === 'none' || editForm.style.display === '') {
            editForm.style.display = 'block';
        } else {
            editForm.style.display = 'none';
        }
    }
</script>
@endsection