@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<a href="{{ route('them-cau-hoi-dien-khuyet') }}" class="btn btn-primary">Thêm câu hỏi điền khuyết</a>
<a href="{{ route('them-cau-hoi-trac-nghiem') }}" class="btn btn-primary">Thêm câu hỏi trắc nghiệm</a>
<div class="container">
    <h1>{{ $title }}</h1>
    <h2>Danh sách đề thi</h2>

    <table class="table" style="background-color: aliceblue; margin-top: 20px;">
        <thead>
            <tr>
                <th>Tên Đề Thi</th>
                <th>Thao Tác</th>
            </tr>
        </thead>
        <tbody id="chuongs-table">
            @foreach ($dethis as $dethi)
                <tr>
                    <td>{{ $dethi->TenDeThi }}</td>
                    <td>
                        <a href="{{ route('sua-de-thi', ['id' => $dethi->MaDe]) }}" class="btn btn-warning">Sửa</a>
                        <form method="POST" action="{{ route('xoa-de-thi', ['id' => $dethi->MaDe]) }}" style="display: inline;">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa đề thi này không?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
