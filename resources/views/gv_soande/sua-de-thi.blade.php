@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<a href="{{ route('them-cau-hoi-dien-khuyet') }}" class="btn btn-primary">Thêm câu hỏi điền khuyết</a>
<a href="{{ route('them-cau-hoi-trac-nghiem') }}" class="btn btn-primary">Thêm câu hỏi trắc nghiệm</a>
<div class="container">
    <h2>{{ $title }}</h2>
    <h3>Đề thi: {{ $dethis->TenDeThi }}</h3>

    <form method="post" action="{{ route('luu-so-luong-cau-hoi', ['id' => $dethis->MaDe]) }}">
        @csrf
        <!-- Hiển thị thông tin chương và số lượng câu giỏi, khá, trung bình cho mỗi chương -->
        @foreach($chuongs as $chuong)
        <div style="background-color: aliceblue">
            <h4>Chương: {{ $chuong->TenChuong }}</h4>
            @foreach(['gioi', 'kha', 'trungbinh'] as $level)
                <label for="{{ $level }}_{{ $chuong->MaChuong }}">Số lượng câu {{ $level }}:</label>
                <input type="text" name="{{ $level }}_{{ $chuong->MaChuong }}" id="{{ $level }}_{{ $chuong->MaChuong }}" value="{{ old($level . '_' . $chuong->MaChuong) ?? 0 }}">
            @endforeach
        </div>
    @endforeach

        <button class="btn btn-primary" type="submit">Lưu</button>
    </form>
</div>
@endsection
