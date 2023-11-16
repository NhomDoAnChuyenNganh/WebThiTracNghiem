@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<div class="container">
    <h2>Thêm Chương</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/soande/them-doan">Thêm Đoạn Văn</a>
            </li>
        </ul>
    </div>
    <form method="POST" action="/soande/them-chuong">
        @csrf
        <div class="form-group">
            <label for="MonHoc">Chọn Môn Học</label>
            <select class="form-control" id="MonHoc" name="MonHoc">
                @foreach($monhocs as $monhoc)
                <option value="{{ $monhoc->MaMH }}">{{ $monhoc->TenMH }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="TenChuong">Tên Chương</label>
            <input type="text" class="form-control" id="TenChuong" name="TenChuong" placeholder="Nhập tên chương">
        </div>
        <button type="submit" class="btn btn-primary">Thêm Chương</button>
    </form>

</div>
@endsection