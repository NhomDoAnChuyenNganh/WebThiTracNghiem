@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<a href="{{ route('them-cau-hoi-dien-khuyet') }}" class="btn btn-primary">Thêm câu hỏi điền khuyết</a>
<a href="{{ route('them-cau-hoi-trac-nghiem') }}" class="btn btn-primary">Thêm câu hỏi trắc nghiệm</a>
@endsection