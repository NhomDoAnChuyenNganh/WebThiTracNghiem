@extends('layouts.app')

@section('content')
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
@endsection
