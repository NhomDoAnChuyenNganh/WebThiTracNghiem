@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('soan-de'), 'label' => 'Soạn đề']]])

@section('content')
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
<div class="noidung" style="height: 1000px; width: 800px; background-color: white;margin: auto;">
    <div class="container">
        <h2 style="text-align: center">{{ $title }}</h2>
        <h3 style="text-align: center">Đề thi: {{ $dethis->TenDeThi }}</h3>

        <form method="post" action="{{ route('luu-so-luong-cau-hoi', ['id' => $dethis->MaDe]) }}">
            @csrf
            <div style="background-color: aqua; padding: 10px; border-radius: 10px;">
                <!-- Hiển thị thông tin chương và số lượng câu giỏi, khá, trung bình cho mỗi chương -->
                @foreach($chuongs as $chuong)
                    <div>
                        <h4>Chương: {{ $chuong->TenChuong }}</h4>
                        <label for="tongcau_{{ $chuong->MaChuong }}">Tổng số lượng câu:</label>
                        <input size="8px" type="text" name="tongcau_{{ $chuong->MaChuong }}" id="tongcau_{{ $chuong->MaChuong }}" value="{{ old('tongcau_' . $chuong->MaChuong) ?? 0 }}">
                        @foreach(['gioi' => 'giỏi', 'kha' => 'khá', 'trungbinh' => 'trung bình'] as $level => $md)
                            <label style="padding-left: 50px" for="{{ $level }}_{{ $chuong->MaChuong }}">Số câu {{ $md }}:</label>
                            <input size="15px" type="text" name="{{ $level }}_{{ $chuong->MaChuong }}" id="{{ $level }}_{{ $chuong->MaChuong }}" value="{{ old($level . '_' . $chuong->MaChuong) ?? 0 }}">
                        @endforeach
                    </div>
                @endforeach
            </div>

            <button style="margin-top: 20px;" class="btn btn-primary" type="submit">Lưu</button>

        </form>
    </div>
</div>
@endsection