@extends('layouts.app', ['homeLink' => route('trang-chu-sinh-vien'),
'additionalLinks' => [['url' => route('thi'), 'label' => 'Vào thi'],
['url' => route('xem-ket-qua'), 'label' => 'Xem kết quả']]])


@section('content')
<div class="noidung" style="height: 2000px; width: 1350px; background-color: white;margin: auto;">
    <h2>Kết Quả Của Bạn</h2>
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
                <th>Phòng Thi</th>
                <th>Ngày Thi</th>
                <th>Số Câu</th>
                <th>Số Phút</th>
                <th>Số Câu Đúng</th>
                <th>Điểm</th>  
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($dslichthi as $thi)
            @php
                
                $deThi = $thi->deThi;
            @endphp
            <tr>
                <td>{{ optional($deThi->MonHoc)->TenMH }}</td>
                <td>{{ optional($deThi->phongThi)->TenPT }}</td>
                <td>{{ date('d/m/Y', strtotime($deThi->NgayThi)) }}</td>
                <td>{{ $deThi->SoLuongCH }}</td>
                <td>{{ $deThi->ThoiGianLamBai }} Phút</td>
                <td>{{ $thi->SoCauDung}}</td>
                <td>{{ $thi->Diem}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $dslichthi->onEachSide(1)->links() }}<br />
</div>
@endsection