@extends('layouts.app', ['homeLink' => route('trang-chu-can-bo-coi-thi'),
'additionalLinks' => [['url' => route('coi-thi'), 'label' => 'Coi thi']]])

@section('content')
<div class="noidung" style="height: 2000px; width: 1300px; background-color: white;margin: auto;">
    <h2>Danh Sách Sinh Viên Trong Phòng</h2>
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
                <th>Họ Tên</th>
                <th>Phái</th>
                <th>Ngày Sinh</th>
                <th>Email</th>
                <th>Tên Đăng Nhập</th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 1;
            @endphp
            @foreach($dssinhvien as $sinhvien)
            <tr>
                <td style="text-align: center;">{{ $counter++ }}</td>
                <td>{{ $sinhvien->user->HoTen }}</td>
                <td>
                    @if ($sinhvien->user->Phai == 0)
                    Nam
                    @elseif ($sinhvien->user->Phai == 1)
                    Nữ
                    @endif
                </td>
                <td>{{ date('d/m/Y', strtotime($sinhvien->user->NgaySinh)) }}</td>
                <td>{{ $sinhvien->user->Email }}</td>
                <td>{{ $sinhvien->user->UserName }}</td>
                <td>
                    <button class="btn btn-primary" style="max-width: 80px;" onclick="showEditForm('{{ $counter }}')">Đổi MK</button>
                    <!-- Form sửa ẩn đi ban đầu -->
                    <div class="editForm" id="editForm{{ $counter }}" style="display: none;">
                        <form action="{{ route('update-matkhau', ['id' => $sinhvien->user->UserID]) }}" method="POST">
                            @csrf
                            <input type="text" name="matkhau_edit">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
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