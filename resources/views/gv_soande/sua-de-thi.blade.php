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
        <h2 style="text-align: center">{{ $title }}</h2>
        <h3 style="text-align: center">Đề thi: {{ $dethis->TenDeThi }}</h3>
        <form method="post" action="{{ route('luu-cau-hoi-them', ['id' => $dethis->MaDe]) }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h4>Câu hỏi đã có trong đề thi</h4>
                    <table style="background-color: blanchedalmond" class="table table-bordered">
                        <thead>
                        <tr style="background-color: aqua">
                            <th>STT</th>
                            <th>Nội dung câu hỏi</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($chitietdethis as $index => $chitiet)
                                <tr>
                                    {{-- <td>{{ $chitiet->cauhoi->MaCH }}</td> --}}
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $chitiet->cauhoi->NoiDung }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h4>Tất cả câu hỏi của môn học</h4>
                    <table style="background-color: blanchedalmond" class="table table-bordered" id="tableAllCauHoi">
                        <thead>
                        <tr style="background-color: aqua">
                            <th>STT</th>
                            <th>Nội dung câu hỏi</th>
                            <th>Mức độ</th>
                            <th>Chọn</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cauhoisChuaCo as $index => $cauhoi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $cauhoi->NoiDung }}</td>
                                <td>{{ $cauhoi->MucDo }}
                                <td>
                                    <input type="checkbox" name="cauhoi_id[]" value="{{ $cauhoi->MaCH }}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>
    <script>
        $(document).ready(function () {
            $('#tableAllCauHoi input[type="checkbox"]').change(function () {
            });
        });
    </script>
@endsection
