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
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="container">
        <a href="{{ route('them-chuong') }}" class="btn btn-success" style="margin: 20px">Thêm Chương</a>
        <h2>Thêm Đoạn Văn</h2>
        <form method="POST" action="{{ route('doanvan.them') }}">
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
                <label for="Chuong"><strong>Chọn Chương</strong></label>
                <select style="max-width: 800px;" class="form-control" id="Chuong" name="MaChuong" required>
                    <option value="">Chọn chương</option>
                </select>
            </div>

            <div class="form-group">
                <label for="TenDV"><strong>Đoạn Văn</strong></label>
                <textarea style="max-width: 800px;" class="form-control" id="TenDV" name="TenDV" rows="5" placeholder="Nhập đoạn văn" required></textarea>
            </div>
            <button style="margin-top: 20px" type="submit" class="btn btn-primary">Thêm Đoạn Văn</button>
        </form>

        <!-- Hiển thị danh sách đoạn văn -->
        <table class="table" style="background-color: aliceblue; margin-top: 20px;">
            <thead>
                <tr>
                    <th>Đoạn Văn</th>
                    <th>Thao Tác</th>
                </tr>
            </thead>
            <tbody id="doanvan-table">
                <!-- Dữ liệu đoạn văn sẽ được thêm bởi JavaScript -->
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
                        $('#Chuong').empty();
                        $.each(data, function(index, chuong) { // sửa ở đây
                            $('#Chuong').append('<option value="' + chuong.MaChuong + '">' + chuong.TenChuong + '</option>'); // sửa ở đây
                        });
                    }
                });
            } else {
                $('#Chuong').empty();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Lắng nghe sự kiện khi thay đổi chương và nạp dữ liệu vào bảng đoạn văn tương ứng.
        $('#Chuong').on('click', function() {
            var machuong = $(this).val();
            if (machuong) {
                $.ajax({
                    type: 'GET',
                    url: '/get-doanvans/' + machuong,
                    success: function(data) {
                        $('#doanvan-table').empty();
                        $.each(data, function(index, doanVan) {
                            $('#doanvan-table').append('<tr>' +
                                '<td>' + doanVan.TenDV + '</td>' +
                                '<td>' +
                                '<a class="btn btn-warning" href="/soande/sua-doan-van/' + doanVan.MaDV + '">Sửa</a>' +
                                '<form method="POST" action="/soande/xoa-doan-van/' + doanVan.MaDV + '" style="display: inline;">' +
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
                $('#doanvan-table').empty();
            }
        });
    });
</script>
@endsection