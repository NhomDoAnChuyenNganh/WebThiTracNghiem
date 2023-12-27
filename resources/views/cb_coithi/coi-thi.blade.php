@extends('layouts.app', ['homeLink' => route('trang-chu-can-bo-coi-thi'),
'additionalLinks' => [['url' => route('coi-thi'), 'label' => 'Coi thi']]])


@section('content')
<div class="noidung" style="height: 2000px; width: 1350px; background-color: white;margin: auto;">
    <h2>Lịch Thi Được Phân Công</h2>
    <form action="{{ route('getMonHocByRole') }}" method="POST">
        @csrf
        <div style="display: flex; align-items: center; margin-left: 20px;">
            <p style="font-size: 25px; font-weight: bold;">Lọc Lịch Theo Môn:</p>
            <select id="monhoc_id" name="monhoc_id" style="font-size: 20px; font-weight: bold; margin-bottom: 12px;">
                <option value="">Tất Cả</option>
                @foreach($dsmonhoc as $monhoc)
                <option value="{{ $monhoc->MaMH }}">{{ $monhoc->TenMH }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary" style="max-width: 80px; margin-left: 10px; margin-bottom: 10px;">Lọc</button>
        </div>
    </form>
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
                $ngayThi = strtotime($dethi->NgayThi);
                $ngayHienTai = strtotime(now()->toDateString());
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
                    @if ($thoiGianHienTai >= $thoiGianBatDau && $thoiGianHienTai <= $thoiGianKetThuc && $ngayThi == $ngayHienTai) 
                            <a href="{{ route('coi-thi-de', ['id' => $dethi->MaDe]) }}" class="btn btn-primary">Coi Thi</a>
                        @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dslichthi->onEachSide(1)->links() }}<br />
</div>
@endsection