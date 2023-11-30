@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('danh-sach-cau-hoi'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<div class="noidung" style="height: 1000px; width: 600px; background-color: white;margin: auto;">
    <div class="container">
        <h2>Sửa Chương</h2>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ url('/soande/sua-chuong/'.$chuong->MaChuong) }}">
            @csrf
            <div class="form-group">
                <label for="MonHoc"><strong>Môn Học</strong></label>
                <span class="form-control" id="MonHoc" name="MonHoc">{{ $chuong->monhoc->TenMH }}</span>
            </div>
            <div class="form-group">
                <label for="TenChuong"><strong>Tên Chương</strong></label>
                <input type="text" class="form-control" id="TenChuong" name="TenChuong" value="{{ $chuong->TenChuong }}" required>
            </div>
            <button style="margin-top:20px;" type="submit" class="btn btn-primary">Lưu Chương</button>
        </form>
    </div>
</div>
@endsection