@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
    'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
    ['url' => route('them-doan'), 'label' => 'Đoạn văn'],
    ['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
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
    <a href="{{ route('them-cau-hoi-dien-khuyet') }}" class="btn btn-primary">Thêm câu hỏi điền khuyết</a>
    <a href="{{ route('them-cau-hoi-trac-nghiem') }}" class="btn btn-primary">Thêm câu hỏi trắc nghiệm</a>
    <div class="container">
        <h2 style="text-align: center">{{ $title }}</h2>
        <h3 style="text-align: center">Đề thi: {{ $dethis->TenDeThi }}</h3>

        <form method="post" action="{{ route('luu-cau-hoi-them', ['id' => $dethis->MaDe]) }}">
            @csrf

            <div class="row">
                <div class="col-md-6" style="">
                    <h4>Câu hỏi đã có trong đề thi</h4>
                    <table style="background-color: blanchedalmond" class="table table-bordered">
                        <thead>
                        <tr style="background-color: aqua">
                            <th>STT</th>
                            <th>Nội dung câu hỏi</th>
                            <th>Xoá</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($chitietdethis as $index => $chitiet)
                                <tr>
                                    {{-- <td>{{ $chitiet->cauhoi->MaCH }}</td> --}}
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $chitiet->cauhoi->NoiDung }}</td>
                                    <td>
                                        <button class="btn btn-danger" onclick="deleteCauHoi({{ $chitiet->cauhoi->MaCH }}, {{ $dethis->MaDe }})">Xoá</button>
                                    </td>
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

    <script>
        $(document).ready(function () {
            $('#tableAllCauHoi input[type="checkbox"]').change(function () {
            });
        });
    </script>
    <script>
        function deleteCauHoi(maCauHoi, maDe) {
            var confirmation = confirm('Bạn có chắc chắn muốn xoá câu hỏi này khỏi đề thi không?');
            
            if (confirmation) {
                // Gửi yêu cầu xoá câu hỏi
                $.ajax({
                    type: 'POST',
                    url: '{{ route("xoacauhoi") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        maCauHoi: maCauHoi,
                        maDe: maDe,
                    },
                    success: function (data) {
                        // Xoá dòng câu hỏi khỏi bảng
                        alert('Xoá câu hỏi thành công!');
                        window.location.reload(); // Có thể sử dụng cách khác để cập nhật giao diện mà không cần load lại trang
                    },
                    error: function (error) {
                        alert('Đã xảy ra lỗi khi xoá câu hỏi.');
                        console.log(error);
                    }
                });
            }
            event.preventDefault();
        }
    </script>
@endsection
