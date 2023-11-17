<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<div class="container">
    <h2>Thêm Câu Hỏi</h2>

    <form method="POST" action="/gv_soande/them-cau-hoi-dien-khuyet">
        @csrf

        <div class="form-group">
            <label for="MonHoc"><strong>Chọn Môn Học</strong></label>
            <select style="max-width: 350px;" class="form-control" id="MonHoc" name="MonHoc" required>
                <option value="">Chọn môn học</option>
                @foreach($monhocs as $monhoc)
                <option value="{{ $monhoc->MaMH }}">{{ $monhoc->TenMH }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="Chuong"><strong>Chọn Chương</strong></label>
            <select style="max-width: 350px;" class="form-control" id="Chuong" name="MaChuong" required>
                <option value="">Chọn chương</option>
            </select>
        </div>

        <div class="form-group">
            <label for="DoanVan">Chọn Đoạn Văn</label>
            <select style="max-width: 350px;" class="form-control" id="DoanVan" name="DoanVan" required>
                <option value="">Chọn đoạn văn</option>
            </select>
        </div>

        <div class="form-group">
            <label for="NoiDung">Nội Dung Câu Hỏi</label>
            <textarea style="max-width: 500px;" class="form-control" id="NoiDung" name="NoiDung" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="MucDo">Chọn Loại Câu Hỏi</label>
            <select style="max-width: 350px;" class="form-control" id="MucDo" name="MucDo" required>
                <option value="">Chọn mức độ</option>
                <!-- Thêm các option cho loại câu hỏi -->
                <option value="Giỏi">Giỏi</option>
                <option value="Khá">Khá</option>
                <option value="Trung Bình">Trung Bình</option>
            </select>
        </div>

        <div class="form-group">
            <label for="DapAn">Đáp Án</label>
            <input style="max-width: 500px;" type="text" class="form-control" id="DapAn" name="DapAn">
        </div>

        <button type="submit" class="btn btn-primary">Thêm Câu Hỏi</button>
    </form>
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
                        console.log(data); // Kiểm tra dữ liệu trả về
                        $('#Chuong').empty();
                        $('#Chuong').append('<option value="">Chọn chương</option>');
                        $.each(data, function(index, chuong) { // sửa ở đây
                            $('#Chuong').append('<option value="' + chuong.MaChuong + '">' + chuong.TenChuong + '</option>'); // sửa ở đây
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
            var machuong = $(this).val();
            if (machuong) {
                $.ajax({
                    type: 'GET',
                    url: '/get-doanvans/' + machuong,
                    success: function(data) {
                        $('#DoanVan').empty();
                        $('#DoanVan').append('<option value="">Chọn đoạn văn</option>');
                        $.each(data, function(index, doanvan) {
                            $('#DoanVan').append('<option value="' + doanvan.MaDV + '">' + doanvan.TenDV + '</option>');
                        });
                    }
                });
            } else {
                $('#DoanVan').empty();
            }
        });
    });
</script>
@endsection