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

<div class="noidung">
    <div class="container d-flex align-items-center min-vh-100">
        <div class="card mx-auto bg-info py-5" style="width: 38rem;">
            <h1 style="text-align: center;">Cập Nhật</h1>
            <div class="card-body">
                <form action="{{ route('update-user',['id' => $user->UserID]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hoten" class="form-label">Họ Tên </label>
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
                            <label for="ngaysinh" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control text-left" id="ngaysinh" name="ngaysinh" value="{{ $user->NgaySinh}}" required>

                            @if ($errors->has('ngaysinh'))
                            <span class="text-danger">{{ $errors->first('ngaysinh')}}</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phai" class="form-label">Giới tính</label>
                                <select name="phai" class="form-select">
                                    <option value="0" {{ $user->Phai == 0 ? 'selected' : '' }}>Nam</option>
                                    <option value="1" {{ $user->Phai == 1 ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>

                            @if ($errors->has('phai'))
                            <span class="text-danger">{{ $errors->first('phai') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role_id" class="form-label">Quyền</label>
                                <select name="role_id" id="role_id" class="form-select">
                                    @foreach($dsrole as $role)
                                    <option value="{{ $role->RoleID }}" {{ $user->RoleID == $role->RoleID ? 'selected' : '' }}>{{ $role->RoleName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="diachi" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control text-left" id="diachi" name="diachi" value="{{ $user->DiaChi}}" required>

                            @if ($errors->has('diachi'))
                            <span class="text-danger">{{ $errors->first('diachi') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="city" class="form-label">Tỉnh/Thành phố</label>
                            <select name="city" id="city" class="form-control">
                                <option value="" selected>{{ $user->TinhThanh}}</option>

                            </select>
                            @if ($errors->has('city'))
                            <span class="text-danger">{{ $errors->first('city') }}</span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label for="district" class="form-label">Quận/Huyện</label>
                            <select name="district" id="district" class="form-control">
                                <option value="" selected>{{ $user->QuanHuyen}}</option>
                            </select>
                            @if ($errors->has('district'))
                            <span class="text-danger">{{ $errors->first('district') }}</span>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <label for="ward" class="form-label">Xã/Phường</label>
                            <select name="ward" id="ward" class="form-control">
                                <option value="" selected>{{ $user->PhuongXa}}</option>
                            </select>
                            @if ($errors->has('ward'))
                            <span class="text-danger">{{ $errors->first('ward') }}</span>
                            @endif
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