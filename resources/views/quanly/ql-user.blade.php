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
<div style=" width: 1350px; background-color: white;margin: auto;">
    <form action="{{ route('getUsersByRole') }}" method="POST">
        @csrf
        <div style="display: flex; align-items: center; margin-left: 20px;">
            <p style="font-size: 25px; font-weight: bold;">Lọc Lại Theo Quyền:</p>
            <select id="role_id" name="role_id" style="font-size: 20px; font-weight: bold; margin-bottom: 12px;">
                <option value="">Tất Cả</option>
                @foreach($dsrole as $role)
                <option value="{{ $role->RoleID }}">{{ $role->RoleName }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary" style="max-width: 80px; margin-left: 10px; margin-bottom: 10px;">Lọc</button>
        </div>
    </form>
    <form action="{{ route('processFile') }}" method="POST" enctype="multipart/form-data" id="fileForm">
        @csrf
        <div style="display: flex; align-items: center; margin-left: 20px;">
            <div style="margin-left: auto; margin-right: 85px;">
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
                <th>Họ Tên</th>
                <th>Phái</th>
                <th>Địa Chỉ</th>
                <th>Phường Xã</th>
                <th>Quận Huyện</th>
                <th>Tỉnh Thành</th>
                <th>Ngày Sinh</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dsusers as $user)
            <tr>
                <td>{{ $user->HoTen }}</td>
                <td>
                    @if ($user->Phai == 0)
                    Nam
                    @elseif ($user->Phai == 1)
                    Nữ
                    @endif
                </td>
                <td>{{ $user->DiaChi }}</td>
                <td>{{ $user->PhuongXa }}</td>
                <td>{{ $user->QuanHuyen }}</td>
                <td>{{ $user->TinhThanh }}</td>
                <td>{{ date('d/m/Y', strtotime($user->NgaySinh)) }}</td>
                <td>{{ $user->Email }}</td>
                <td>
                    <a href="{{ route('delete-user', ['id' => $user->UserID]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xoá</a>
                    <a href="{{ route('edit-user', ['id' => $user->UserID]) }}" class="btn btn-primary" style="max-width: 80px;">Sửa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dsusers->onEachSide(1)->links() }}<br />
</div>
@endsection