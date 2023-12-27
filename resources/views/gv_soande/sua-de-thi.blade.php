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
<div style="width: 1200px; background-color: white;margin: auto;">
    <div class="container">
        <h2 style="text-align: center">{{ $title }}</h2>
        <h3 style="text-align: center">Đề thi: {{ $dethis->TenDeThi }}</h3>
        <form method="post" action="{{ route('sua-chi-tiet-de-thi', ['id' => $dethis->MaDe]) }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <h4>Câu hỏi đã có trong đề thi</h4>
                    <div style="max-height: 800px; overflow-y: auto">
                        <table style="background-color: blanchedalmond" class="table table-bordered">
                            <thead>
                                <tr style="background-color: aqua">
                                    <th>STT</th>
                                    <th>Nội dung câu hỏi</th>
                                    <th>Mức độ</th>
                                    <th>Loại câu hỏi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($chitietdethis as $index => $chitiet)
                                <tr>
                                    {{-- <td>{{ $chitiet->cauhoi->MaCH }}</td> --}}
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $chitiet->cauhoi->NoiDung }}</td>
                                    <td>{{ $chitiet->cauhoi->MucDo }}</td>
                                    <td>{{ $chitiet->cauhoi->loaicauhoi->TenLoai }}</td>
                                    <td>
                                        <button class="btn btn-danger" onclick="deleteCauHoi({{ $chitiet->cauhoi->MaCH }}, {{ $dethis->MaDe }})">Xoá</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-6">
                    <h4>Tất cả câu hỏi của môn học</h4>
                    <table style="background-color: blanchedalmond" class="table table-bordered" id="tableAllCauHoi">
                        <thead>
                            <tr style="background-color: aqua">
                                <th>STT</th>
                                <th>Nội dung câu hỏi</th>
                                <th>Mức độ</th>
                                <th>Loại câu hỏi</th>
                                <th>Chọn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cauhoisChuaCo as $index => $cauhoi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $cauhoi->NoiDung }}</td>
                                <td>{{ $cauhoi->MucDo }}
                                <td>{{ $cauhoi->loaicauhoi->TenLoai }}</td>

                                <td>
                                    <input type="checkbox" name="cauhoi_id[]" value="{{ $cauhoi->MaCH }}">
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $cauhoisChuaCo->onEachSide(1)->links() }}<br />
                </div>
            </div>

            <div style="text-align: right; padding-right:20px; padding-bottom: 20px">
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tableAllCauHoi input[type="checkbox"]').change(function() {});
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
                success: function(data) {
                    // Xoá dòng câu hỏi khỏi bảng
                    alert('Xoá câu hỏi thành công!');
                    window.location.reload(); // Có thể sử dụng cách khác để cập nhật giao diện mà không cần load lại trang
                },
                error: function(error) {
                    alert('Đã xảy ra lỗi khi xoá câu hỏi.');
                    console.log(error);
                }
            });
        }
        event.preventDefault();
    }
</script>
@endsection