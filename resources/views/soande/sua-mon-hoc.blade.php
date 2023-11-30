@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('danh-sach-cau-hoi'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<div class="noidung" style="height: 1000px; width: 600px; background-color: white;margin: auto;">
<div class="container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form method="post" action="{{ url('/soande/sua-mon-hoc/'.$monHoc->MaMH) }}">
        @csrf
        <div class="form-group">
            <label for="TenMH">Tên Môn Học:</label>
            <input type="text" name="TenMH" class="form-control" value="{{ $monHoc->TenMH }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
    </form>
</div>
</div>
@endsection