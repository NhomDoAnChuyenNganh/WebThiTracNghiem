@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('ql-user'), 'label' => 'Quản lý người dùng'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân công giáo viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân công cán bộ'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân bổ sinh viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Thống kê']
]])

@section('content')

<div class="noidung">
    <div class="container d-flex align-items-center min-vh-100">
        <div class="card mx-auto bg-info py-5" style="width: 38rem;">
            <h1 style="text-align: center;">Cập Nhật</h1>
            <div class="card-body">
                <form action="{{ route('update-user', ['id' => $user->UserID]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ho_ten" class="form-label">Họ Tên </label>
                            <input type="text" class="form-control text-left" id="hoten" name="hoten" value="{{ $user->HoTen }}" required>
                            @if ($errors->has('ho_ten'))
                            <span class="text-danger">{{ $errors->first('ho_ten') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control text-left" id="email" name="email" value="{{ $user->Email }}" required>
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ngay_sinh" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control text-left" id="ngaysinh" name="ngaysinh" value="{{ $user->NgaySinh}}" required>

                            @if ($errors->has('ngay_sinh'))
                            <span class="text-danger">{{ $errors->first('ngay_sinh')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label for="dia_chi" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control text-left" id="diachi" name="diachi" value="{{ $user->DiaChi}}" required>

                            @if ($errors->has('dia_chi'))
                            <span class="text-danger">{{ $errors->first('dia_chi') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phai" class="form-label">Giới tính</label>
                                <select name="phai" class="form-control">
                                    <option value="0" {{ $user->Phai == 0 ? 'selected' : '' }}>Nam</option>
                                    <option value="1" {{ $user->Phai == 1 ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>

                            @if ($errors->has('phai'))
                            <span class="text-danger">{{ $errors->first('phai') }}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role_id" class="form-label">Quyền</label>
                                <select name="role_id " class="form-control">
                                    @foreach($dsrole as $role)
                                    <option value="{{ $role->RoleID }}" {{ $user->RoleID == $role->RoleID ? 'selected' : '' }}>{{ $role->RoleName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="text-align: center;" class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection