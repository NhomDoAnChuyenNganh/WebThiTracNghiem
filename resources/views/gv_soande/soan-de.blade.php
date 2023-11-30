@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('danh-sach-cau-hoi'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('soan-de'), 'label' => 'Soạn đề']]])

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
<div class="noidung" style="height: 1000px; width: 800px; background-color: white;margin: auto;">
    <div class="container">
        <h1>{{ $title }}</h1>
        <h2>Danh sách đề thi</h2>

        <table class="table" style="background-color: aliceblue; margin-top: 20px;">
            <thead>
                <tr>
                    <th>Môn Học</th>
                    <th>Tên Đề Thi</th>
                    <th>Số Lượng Câu Hỏi</th>
                    <th >Thao Tác</th>
                </tr>
            </thead>
            <tbody id="chuongs-table">
                @foreach ($dethis as $dethi)
                    <tr>
                        <td>{{ optional($dethi->MonHoc)->TenMH }}</td>
                        <td>{{ $dethi->TenDeThi }}</td>
                        <td style="text-align: center;">{{ $dethi->SoLuongCH }}</td>
                        <td>
                            <a href="{{ route('sua-de-thi', ['id' => $dethi->MaDe]) }}" class="btn btn-warning">Soạn đề</a>
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
</div>
@endsection