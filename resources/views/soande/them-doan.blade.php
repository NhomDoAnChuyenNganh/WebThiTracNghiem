@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn đề']]])

@section('content')
<div class="container">
    <h2>Thêm Đoạn Văn</h2>
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('doanvan.them') }}">
        @csrf
        <div class="form-group">
            <label for="MonHoc">Chọn Môn Học</label>
            <select class="form-control" id="MonHoc" name="MonHoc" required>
                <option value="">Chọn môn học</option>
                @foreach($monhocs as $monhoc)
                <option value="{{ $monhoc->MaMH }}">{{ $monhoc->TenMH }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="Chuong">Chọn Chương</label>
            <select class="form-control" id="Chuong" name="MaChuong" required>
                <option value="">Chọn chương</option>
            </select>
        </div>

        <div class="form-group">
            <label for="TenDV">Tên Đoạn Văn</label>
            <input type="text" class="form-control" id="TenDV" name="TenDV" placeholder="Nhập tên đoạn văn" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Đoạn Văn</button>
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
@endsection