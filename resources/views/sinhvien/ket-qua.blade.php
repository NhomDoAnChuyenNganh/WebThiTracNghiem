@extends('layouts.app', ['homeLink' => route('trang-chu-sinh-vien'),
'additionalLinks' => [['url' => route('thi'), 'label' => 'Vào thi'],
['url' => route('xem-ket-qua'), 'label' => 'Xem kết quả']]])

@section('content')
    <div class="noidung" style="height: 500px; width: 800px; background-color: white;margin: auto; text-align: center;">
        <h2>Kết Quả Thi</h2>

        <p>Điểm của bạn: {{ $diem }}</p>
        <p>Số câu đúng: {{ $soCauDung }}</p>

        <a href="{{ route('xem-ket-qua') }}" class="btn btn-primary">Quay lại trang chủ</a>
    </div>
@endsection
