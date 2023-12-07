@extends('layouts.app', ['homeLink' => route('trang-chu-can-bo-coi-thi'),
'additionalLinks' => [['url' => route('trang-chu-can-bo-coi-thi'), 'label' => 'Coi thi']]])

@section('content')
    <div class="noidung" style="height: 500px; width: 800px; background-color: white;margin: auto; text-align: center;">
        <h2>Kết Quả Thi</h2>

        <p>Điểm của bạn: {{ $diem }}</p>
        <p>Số câu đúng: {{ $soCauDung }}</p>

        <a href="{{ route('trang-chu-can-bo-coi-thi') }}" class="btn btn-primary">Quay lại trang chủ</a>
    </div>
@endsection
