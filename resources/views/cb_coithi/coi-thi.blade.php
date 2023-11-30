@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('ql-user'), 'label' => 'Quản lý người dùng'],
['url' => route('ql-monhoc'), 'label' => 'Quản lý môn học'],
['url' => route('ql-phongthi'), 'label' => 'Quản lý phòng thi'],
['url' => route('phan-bo-sinh-vien'), 'label' => 'Phân bổ sinh viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Thống kê']
]])

@section('content')
<div class="noidung" style="height: 2000px; width: 1350px; background-color: white;margin: auto;">
    <h2>Lịch Thi Được Phân Công</h2>
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
                <th>Môn Thi</th>
                <th>Tên Đề</th>
                <th>Số Phút</th>
                <th>Ngày Thi</th>
                <th>Bắt Đầu</th>
                <th>Kết Thúc</th>
                <th>Số Câu</th>
                <th>Phòng Thi</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($dslichthi as $dethi)
            @php
                $thoiGianBatDau = strtotime($dethi->ThoiGianBatDau);
                $thoiGianKetThuc = strtotime($dethi->ThoiGianKetThuc);
                $thoiGianHienTai = strtotime(now());
            @endphp
            <tr>
                <td>{{ optional($dethi->MonHoc)->TenMH }}</td>
                <td>{{ $dethi->TenDeThi }}</td>
                <td>{{ $dethi->ThoiGianLamBai }} Phút</td>
                <td>{{ date('d/m/Y', strtotime($dethi->NgayThi)) }}</td>
                <td>{{ $dethi->ThoiGianBatDau }}</td>
                <td>{{ $dethi->ThoiGianKetThuc }}</td>
                <td>{{ $dethi->SoLuongCH }}</td>
                <td>{{ optional($dethi->phongThi)->TenPT }}</td>
                <td>
                    @if ($thoiGianHienTai >= $thoiGianBatDau && $thoiGianHienTai <= $thoiGianKetThuc)
                        <a href="{{ route('coi-thi-de', ['id' => $dethi->MaDe]) }}" class="btn btn-primary">Coi Thi</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection