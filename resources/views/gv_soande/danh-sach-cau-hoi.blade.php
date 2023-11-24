@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('danh-sach-cau-hoi'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn đề']]])

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
<a href="{{ route('them-cau-hoi-dien-khuyet') }}" class="btn btn-primary">Thêm câu hỏi điền khuyết</a>
<a href="{{ route('them-cau-hoi-trac-nghiem') }}" class="btn btn-primary">Thêm câu hỏi trắc nghiệm</a>
<form action="{{ route('process-file-cauhoi') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="user_file" accept=".xlsx">
    <button type="submit">Import File</button>
</form>
<h1>Danh sách câu hỏi</h1>

@if(count($cauhois) > 0)
<table class="table table-light">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Nội dung</th>
            <th scope="col">Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cauhois as $key => $cauhoi)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $cauhoi->NoiDung }}</td>
            <td>
                <a href="#" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')">Xoá</a>
                <a href="#" class="btn btn-primary" style="max-width: 80px;">Sửa</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $cauhois->onEachSide(1)->links() }}
@else
<p>Không có câu hỏi nào.</p>
@endif
@endsection