@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('danh-sach-cau-hoi'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<div class="noidung" style="height: 1000px; width: 600px; background-color: white;margin: auto;">
    <div class="container">

        <button class="btn btn-primary" style="margin: 20px" onclick="window.location.href='{{ route('them-chuong') }}'">Thêm Chương</button>

        <button class="btn btn-success" style="margin: 20px" onclick="window.location.href='{{ route('them-doan') }}'">Thêm Đoạn Văn</button>


        <h2>Thêm Môn Học</h2>
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="/soande/them-mon-hoc">
            @csrf
            <div class="form-group">
                <label for="TenMH"><strong>Tên Môn Học</strong></label>
                <input style="margin-top: 10px; max-width: 350px;" maxlength="70px" type="text" class="form-control" id="TenMH" name="TenMH" placeholder="Nhập tên môn học" required>
            </div>
            <button type="submit" class="btn btn-primary" style="margin-top: 20px">Thêm Môn Học</button>
        </form>

        {{-- <form method="POST" action="{{ route('import.monhoc') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file"><strong> Chọn File Excel</strong></label>
            <input type="file" name="file" class="form-control" accept=".xlsx, .xls">
        </div>
        <button type="submit" class="btn btn-primary">Import từ Excel</button>
        </form> --}}


        <form action="{{ route('them-mon-hoc-excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="excel_file" class="form-control" accept=".xlsx, .xls">
            <button type="submit" class="btn btn-primary">Thêm Môn Học</button>
        </form>

        <table class="table" style="background-color: aliceblue; margin-top: 20px;">
            <thead>
                <tr>
                    <th>Tên Môn Học</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monhocs as $monhoc)
                <tr>
                    <td>{{ $monhoc->TenMH }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ url('/soande/sua-mon-hoc/'.$monhoc->MaMH) }}">Sửa</a>
                        <!-- Thêm form xóa cho môn học -->
                        <form method="POST" action="{{ url('/soande/xoa-mon-hoc/'.$monhoc->MaMH) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa môn học này không?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection