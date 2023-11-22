@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('danh-sach-cau-hoi'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<div class="container">

    <h2>Sửa Đoạn Văn</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ url('/soande/sua-doan-van/'.$doanVan->MaDV) }}">
        @csrf
        <div class="form-group">
            <label for="MonHoc"><strong>Môn Học</strong></label>
            <span style="max-width: 350px;" class="form-control" id="MonHoc" name="MonHoc">{{ $doanVan->chuong->monhoc->TenMH }}</span>
        </div>
        <div class="form-group">
            <label for="Chuong"><strong>Chương</strong></label>
            <span style="max-width: 350px;" class="form-control" id="Chuong" name="Chuong">{{ $doanVan->chuong->TenChuong }}</span>
        </div>
        <div class="form-group">
            <label for="TenDV"><strong>Tên Đoạn Văn</strong></label>
            <input style="max-width: 350px;" type="text" class="form-control" id="TenDV" name="TenDV" value="{{ $doanVan->TenDV }}" required>
        </div>

        <button style="margin-top: 20px" type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
    </form>

</div>
@endsection