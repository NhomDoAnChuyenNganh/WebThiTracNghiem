<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
<div class="row justify-content-center bg-white">
    <h2>Thêm Câu Hỏi</h2>

    <div class="col-md-6">
        <form method="POST" action="/gv_soande/them-cau-hoi-dien-khuyet">
            @csrf

            <div class="form-group">
                <label for="MonHoc"><strong>Chọn Môn Học</strong></label>
                <select style="max-width: 600px;" class="form-control" id="MonHoc" name="MonHoc" required>
                    <option value="">Chọn môn học</option>
                    @foreach($monhocs as $monhoc)
                    <option value="{{ $monhoc->MaMH }}">{{ $monhoc->TenMH }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="Chuong"><strong>Chọn Chương</strong></label>
                <select style="max-width: 600px;" class="form-control" id="Chuong" name="MaChuong" required>
                    <option value="">Chọn chương</option>
                </select>
            </div>

            <div class="form-group">
                <label for="DoanVan"><strong>Chọn Đoạn Văn</strong></label>
                <select style="max-width: 600px;" class="form-control" id="DoanVan" name="DoanVan" required>
                    <option value="">Chọn đoạn văn</option>
                </select>
            </div>

            <div class="form-group">
                <label for="NoiDung"><strong>Nội Dung Câu Hỏi</strong></label>
                <textarea style="max-width: 600px;" class="form-control" id="NoiDung" name="NoiDung" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="MucDo"><strong>Chọn Loại Câu Hỏi</strong></label>
                <select style="max-width: 600px;" class="form-control" id="MucDo" name="MucDo" required>
                    <option value="">Chọn mức độ</option>
                    <!-- Thêm các option cho loại câu hỏi -->
                    <option value="Giỏi">Giỏi</option>
                    <option value="Khá">Khá</option>
                    <option value="Trung Bình">Trung Bình</option>
                </select>
            </div>

            <div class="form-group">
                <label for="DapAn"><strong>Đáp Án</strong></label>
                <input style="max-width: 600px;" type="text" class="form-control" id="DapAn" name="DapAn">
            </div>

            <div style="text-align: center; margin-top: 20px;">
                <button style=" margin-bottom: 50px; padding-left: 50px; padding-right: 50px;" type="submit" class="btn btn-primary">Thêm</button>
            </div>

        </form>
    </div>
    <div class="col-md-6" style="max-height: 550px; overflow: auto">
        <table class="table" style="background-color: aliceblue; margin-top: 20px;">
            <thead id='name-table'>
                <tr>
                </tr>
            </thead>
            <tbody id="value-table">
                <!-- Dữ liệu chương sẽ được thêm bởi JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Lắng nghe sự kiện khi thay đổi môn học và nạp dữ liệu vào dropdown chương tương ứng.
        $('#MonHoc').on('change', function() {
            $('#name-table').empty();
            $('#value-table').empty();
            var mamh = $(this).val();
            if (mamh) {
                $.ajax({
                    type: 'GET',
                    url: '/get-chuongs/' + mamh,
                    success: function(data) {
                        var chuongs = data; // Lưu trữ dữ liệu chương
                        console.log(data); // Kiểm tra dữ liệu trả về
                        $('#Chuong').empty();
                        $('#DoanVan').empty();
                        $('#Chuong').append('<option value="">Chọn chương</option>');
                        $('#name-table').append('<tr>' +
                            '<td>Tên Chương</td>' +
                            '<td>Thao tác</td>' +
                            '</tr>');
                        $.each(data, function(index, chuong) { // sửa ở đây
                            $('#Chuong').append('<option value="' + chuong.MaChuong + '">' + chuong.TenChuong + '</option>'); // sửa ở đây

                            $('#value-table').append('<tr>' +
                                '<td>' + chuong.TenChuong + '</td>' +
                                '<td>' +
                                '<a class="btn btn-warning" href="/soande/sua-chuong/' + chuong.MaChuong + '">Sửa</a>' +
                                '<form method="POST" action="/soande/xoa-chuong/' + chuong.MaChuong + '" style="display: inline;">' +
                                '@csrf' +
                                '@method("DELETE")' +
                                '<button type="submit" class="btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa chương này không?\')">Xóa</button>' +
                                '</form>' +
                                '</td>' +
                                '</tr>');
                        });
                    }
                });
            } else {
                $('#Chuong').empty();
                $('#DoanVan').empty();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Chuong').on('change', function() {
            $('#name-table').empty();
            $('#value-table').empty();
            var machuong = $(this).val();
            if (machuong) {
                $.ajax({
                    type: 'GET',
                    url: '/get-doanvans/' + machuong,
                    success: function(data) {
                        $('#DoanVan').empty();
                        $('#DoanVan').append('<option value="">Chọn đoạn văn</option>');
                        $('#name-table').append('<tr>' +
                            '<td>Tên Đoạn Văn</td>' +
                            '<td>Thao tác</td>' +
                            '</tr>');
                        $.each(data, function(index, doanvan) {
                            $('#DoanVan').append('<option value="' + doanvan.MaDV + '">' + doanvan.TenDV + '</option>');

                            $('#value-table').append('<tr>' +
                                '<td>' + doanvan.TenDV + '</td>' +
                                '<td>' +
                                '<a class="btn btn-warning" href="/soande/sua-doan-van/' + doanvan.MaDV + '">Sửa</a>' +
                                '<form method="POST" action="/soande/xoa-doan-van/' + doanvan.MaDV + '" style="display: inline;">' +
                                '@csrf' +
                                '@method("DELETE")' +
                                '<button type="submit" class="btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa đoạn văn này không?\')">Xóa</button>' +
                                '</form>' +
                                '</td>' +
                                '</tr>');
                        });
                    }
                });
            } else {
                $('#DoanVan').empty();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#DoanVan').on('change', function() {
            $('#name-table').empty();
            $('#value-table').empty();
            var madv = $(this).val();
            if (madv) {
                $.ajax({
                    type: 'GET',
                    url: '/get-cauhois/' + madv,
                    success: function(data) {
                        $('#name-table').append('<tr>' +
                            '<td>Nội dung câu hỏi</td>' +
                            '<td>Mức độ</td>' +
                            '<td>Thao tác</td>' +
                            '</tr>');
                        $.each(data, function(index, cauhoi) {
                            $('#value-table').append('<tr>' +
                                '<td>' + cauhoi.NoiDung + '</td>' +
                                '<td>' + cauhoi.MucDo + '</td>' +
                                '<td>' +
                                '<a class="btn btn-warning" href="sua-cau-hoi/' + cauhoi.MaCH + '">Sửa</a>' +
                                '<form method="POST" action="/gv_soande/xoa-cau-hoi/' + cauhoi.MaCH + '" style="display: inline;">' +
                                '@csrf' +
                                '@method("DELETE")' +
                                '<button type="submit" class="btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa câu hỏi này không?\')">Xóa</button>' +
                                '</form>' +
                                '</td>' +
                                '</tr>');
                        });
                    }
                });
            } else {}
        });
    });
</script>
@endsection