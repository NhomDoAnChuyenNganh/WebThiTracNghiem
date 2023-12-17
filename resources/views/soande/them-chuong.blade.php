<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('danh-sach-cau-hoi'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<div class="noidung" style="height: 1000px; width: 600px; background-color: white;margin: auto;">
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">

        <a href="{{ route('them-doan') }}" class="btn btn-success" style="margin: 20px">Thêm Đoạn Văn</a>

        <h2>Thêm Chương</h2>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form method="POST" action="/soande/them-chuong">
            @csrf
            <div class="form-group">
                <label for="MonHoc"><strong>Chọn Môn Học</strong></label>
                <select style="max-width: 800px;" class="form-control" id="MonHoc" name="MonHoc" required>
                    <option value="">Chọn môn học</option>
                    @foreach($monhocs as $monhoc)
                    <option value="{{ $monhoc->MaMH }}">{{ $monhoc->TenMH }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="TenChuong"><strong>Tên Chương</strong></label>
                <input style="max-width: 800px;" type="text" class="form-control" id="TenChuong" name="TenChuong" placeholder="Nhập tên chương" required>
            </div>
            <button style="margin-top: 20px" type="submit" class="btn btn-primary">Thêm Chương</button>
        </form>

        <!-- Hiển thị danh sách chương -->
        <table class="table" style="background-color: aliceblue; margin-top: 20px;">
            <thead>
                <tr>
                    <th>Tên Chương</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody id="chuongs-table">
                <!-- Dữ liệu chương sẽ được thêm bởi JavaScript -->
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Lắng nghe sự kiện khi thay đổi môn học và nạp dữ liệu vào dropdown chương tương ứng.
        $('#MonHoc').on('change', function() {
            var mamh = $(this).val();
            if (mamh) {
                $.ajax({
                    type: 'GET',
                    url: '/get-chuongs/' + mamh,
                    success: function(data) {
                        $('#chuongs-table').empty();
                        $.each(data, function(index, chuong) { // sửa ở đây
                            $('#chuongs-table').append('<tr>' +
                                '<td>' + chuong.TenChuong + '</td>' +
                                '<td>' +
                                '<a class="btn btn-warning" href="/soande/sua-chuong/' + chuong.MaChuong + '">Sửa</a>' +
                                '<form method="POST" action="/soande/xoa-chuong/' + chuong.MaChuong + '" style="display: inline;">' +
                                '@csrf' +
                                '@method("DELETE")' +
                                '<button type="submit" class="btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa chương này không?\')">Xóa</button>' +
                                '</form>' +
                                '</td>' +
                                '</tr>'); // sửa ở đây
                        });
                    }
                });
            } else {
                $('#chuongs-table').empty();
            }
        });
    });
</script>
@endsection