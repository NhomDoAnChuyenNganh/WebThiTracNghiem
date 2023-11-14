@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly')])

@section('content')

<div class="noidung" style="height: 2000px; width: 1200px; background-color: white; margin: 0 auto;">
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
            <div style="margin-left: auto; margin-right: 85px;">
                <a href="{{ route('forgot-password') }}" class="btn btn-primary" style="max-width: 80px; margin-right: 10px;">Thêm</a>
                <a href="{{ route('register') }}" class="btn btn-primary" style="max-width: 100px;">Add File</a>
            </div>
        </div>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>Họ Tên</th>
                <th>Phái</th>
                <th>Địa Chỉ</th>
                <th>Ngày Sinh</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dsusers as $user)
                <tr>
                    <td >{{ $user->HoTen }}</td>
                    <td >
                        @if ($user->Phai == 0)
                            Nam
                        @elseif ($user->Phai == 1)
                            Nữ
                        @endif
                    </td>
                    <td >{{ $user->DiaChi }}</td>
                    <td >{{ date('d/m/Y', strtotime($user->NgaySinh)) }}</td>
                    <td >{{ $user->Email }}</td>
                    <td >
                        <a href="{{ route('delete-user', ['id' => $user->UserID]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">Xoá</a>
                        <a href="{{ route('edit-user', ['id' => $user->UserID]) }}" class="btn btn-primary" style="max-width: 80px;">Sửa</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
</div>
@endsection