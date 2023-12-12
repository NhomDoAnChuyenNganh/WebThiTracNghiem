@extends('layouts.app', ['homeLink' => route('trang-chu-sinh-vien'),
'additionalLinks' => [['url' => route('thi'), 'label' => 'Vào thi'],
['url' => route('xem-ket-qua'), 'label' => 'Xem kết quả']]])


@section('content')
<div class="noidung" style="height: 2000px; width: 1350px; background-color: white;margin: auto;">
    <h2>Lịch Thi Của Bạn</h2>
    <form action="{{ route('getMonHocBySinhVien') }}" method="POST">
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
                <th>Số Phút</th>
                <th>Ngày Thi</th>
                <th>Bắt Đầu</th>
                <th>Kết Thúc</th>
                <th>Số Câu</th>
                <th>Phòng Thi</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($dslichthi as $thi)
            @php
                $deThi = $thi->deThi;
                $thoiGianBatDau = strtotime($deThi->ThoiGianBatDau);
                $thoiGianKetThuc = strtotime($deThi->ThoiGianKetThuc);
                $thoiGianHienTai = strtotime(now());
                $ngayThi = strtotime($deThi->NgayThi);
                $ngayHienTai = strtotime(now()->toDateString());
            @endphp
            <tr>
                <td>{{ optional($deThi->MonHoc)->TenMH }}</td>
                <td>{{ $deThi->ThoiGianLamBai }} Phút</td>
                <td>{{ date('d/m/Y', strtotime($deThi->NgayThi)) }}</td>
                <td>{{ $deThi->ThoiGianBatDau }}</td>
                <td>{{ $deThi->ThoiGianKetThuc }}</td>
                <td>{{ $deThi->SoLuongCH }}</td>
                <td>{{ optional($deThi->phongThi)->TenPT }}</td>
                <td>
                    @if ($thoiGianHienTai >= $thoiGianBatDau && $thoiGianHienTai <= $thoiGianKetThuc && $ngayThi == $ngayHienTai) 
                        <a href="{{ route('vao-thi', ['id' => $deThi->MaDe]) }}" class="btn btn-primary">Vào Thi</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $dslichthi->onEachSide(1)->links() }}<br />
</div>
@endsection