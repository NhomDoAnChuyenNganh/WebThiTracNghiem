@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Thêm Môn Học</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/soande/them-chuong">Thêm Chương</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/soande/them-doan">Thêm Đoạn Văn</a>
            </li>
        </ul>
    </div>
    <form method="POST" action="/soande/them-mon-hoc">
        @csrf
        <div class="form-group">
            <label for="TenMH">Tên Môn Học</label>
            <input type="text" class="form-control" id="TenMH" name="TenMH" placeholder="Nhập tên môn học">
        </div>
        <button type="submit" class="btn btn-primary">Thêm Môn Học</button>
    </form>


</div>
@endsection
