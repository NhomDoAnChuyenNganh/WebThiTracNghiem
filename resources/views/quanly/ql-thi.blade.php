@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('ql-user'), 'label' => 'Quản lý người dùng'],
['url' => route('ql-monhoc'), 'label' => 'Quản lý môn học'],
['url' => route('ql-phongthi'), 'label' => 'Quản lý phòng thi'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân bổ sinh viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Thống kê']
]])

@section('content')
<div class="noidung" style="height: 1000px; width: 1200px; background-color: white;margin: auto;">
    <div class="card-body" style="margin: 20px;">
    <form action="{{ route('getUsersByRole') }}" method="POST">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="monhoc_id" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Môn Thi</label>
                    <select id="monhoc_id" name="monhoc_id" class="form-select">
                        <option value=""></option>
                        @foreach($dsmon as $mon)
                            <option value="{{ $mon->MaMH }}">{{ $mon->TenMH }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="dethi_id" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Đề Thi</label>
                    <select id="dethi_id" name="dethi_id" class="form-select" disabled>
                        <option value=""></option>
                        @foreach($dsmon as $mon)
                            <optgroup label=" Các đề thi {{ $mon->TenMH }}" id="dsDeThi-{{ $mon->MaMH }}">
                                @foreach($mon->dsDeThi as $dethi)
                                    <option value="{{ $dethi->MaDeThi}}">{{ $dethi->TenDeThi }} - {{ $dethi->ThoiGianLamBai}} phút</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="ngay_thi" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Ngày Thi</label>
                    <input type="date" class="form-control text-left" id="ngaysinh" name="ngaysinh" required>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="start_time" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Thời Gian Bắt Đầu</label>
                    <select id="start_time" name="start_time" class="form-select">
                        <option value=""></option>
                        @for ($hour = 0; $hour <= 24; $hour++)
                            @for ($minute = 0; $minute < 60; $minute += 5)
                                <option value="{{ sprintf('%02d', $hour) }}:{{ sprintf('%02d', $minute) }}">{{ sprintf('%02d', $hour) }}:{{ sprintf('%02d', $minute) }}</option>
                            @endfor
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="end_time" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Thời Gian Kết Thúc</label>
                    <select id="end_time" name="end_time" class="form-select">
                        <option value=""></option>
                        @for ($hour = 0; $hour <= 24; $hour++)
                            @for ($minute = 0; $minute < 60; $minute += 5)
                                <option value="{{ sprintf('%02d', $hour) }}:{{ sprintf('%02d', $minute) }}">{{ sprintf('%02d', $hour) }}:{{ sprintf('%02d', $minute) }}</option>
                            @endfor
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="phong_id" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Phòng Thi</label>
                    <select id="phong_id" name="phong_id" class="form-select">
                        <option value=""></option>
                        @foreach($dsphong as $phong)
                            <option value="{{ $phong->MaPT}}">{{ $phong->TenPT }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @csrf
    </form>
    </div>
</div>




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
@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
   $(document).ready(function () {
    // Sự kiện khi chọn môn học
    $('#monhoc_id').change(function () {
        // Lấy giá trị đã chọn
        
        var selectedMonHoc = $(this).val();
        // Disable dropdown đề thi và reset giá trị
        $('#dethi_id').prop('disabled', true).val('');

        // Nếu có môn học được chọn
        if (selectedMonHoc !== '') {
            // Hiển thị danh sách đề thi của môn học đã chọn
            $('optgroup').hide();
            $('#dsDeThi-' + selectedMonHoc).show();

            // Enable dropdown đề thi
            $('#dethi_id').prop('disabled', false);
        }
        
    });
    $('#end_time').change(function () {
            // Lấy giá trị thời gian kết thúc
            var endTime = $(this).val();

            // Lấy giá trị thời gian bắt đầu
            var startTime = $('#start_time').val();

            // Kiểm tra nếu thời gian kết thúc nhỏ hơn hoặc bằng thời gian bắt đầu
            if (startTime !== '' && endTime !== '' && endTime <= startTime) {
                alert('Thời gian kết thúc phải lớn hơn thời gian bắt đầu');
                // Đặt giá trị thời gian kết thúc về rỗng
                $(this).val('');
            }
        });
});
</script>