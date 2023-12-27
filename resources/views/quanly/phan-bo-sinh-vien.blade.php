@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('ql-user'), 'label' => 'Quản lý người dùng'],
['url' => route('ql-monhoc'), 'label' => 'Quản lý môn học'],
['url' => route('ql-phongthi'), 'label' => 'Quản lý phòng thi'],
['url' => route('phan-bo-sinh-vien'), 'label' => 'Phân bổ sinh viên'],
['url' => route('tao-de-thi'), 'label' => 'Tạo đề thi'],
['url' => route('ql-thi'), 'label' => 'Quản lý thi'],
['url' => route('thong-ke'), 'label' => 'Thống kê']
]])

@section('content')

<div style="width: 1300px; background-color: white;margin: auto;">
    <div class="card-body" style="margin: 20px;">
        <form action="{{ route('getSinhVienByLichThi') }}" method="POST">
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
                        @if ($errors->has('monhoc_id'))
                        <span class="text-danger">{{ $errors->first('monhoc_id')}}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dethi_id" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Lịch Thi</label>
                        <select id="dethi_id" name="dethi_id" class="form-select" disabled>
                            <option value=""></option>
                            @foreach($dsmon as $mon)
                            <optgroup label=" Các đề thi {{ $mon->TenMH }}" id="dsLichThi-{{ $mon->MaMH }}">
                                @foreach($mon->dsLichThi as $lichthi)
                                <option value="{{ $lichthi->MaDe}}">{{ $lichthi->TenDeThi }} - {{ $lichthi->ThoiGianLamBai}} phút- {{ $lichthi->ThoiGianBatDau}}- {{ $lichthi->ThoiGianKetThuc}}</option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                        @if ($errors->has('dethi_id'))
                        <span class="text-danger">{{ $errors->first('dethi_id')}}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-2 text-center">
                    <button style="margin-top: 20px;" type="submit" class="btn btn-success btn-lg mx-2">Lọc Sinh Viên Chưa Thi</button>

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

            @csrf
        </form>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <h2 style="margin-left: 10px;">Danh Sách Sinh Viên</h2>
        </div>
        <div class="col-md-6 ">
            <form action="{{ route('addSinhVienToLichThi') }}" method="POST" id="addSinhVienForm">
                @csrf
                <!-- Các trường lọc -->
                <input type="hidden" name="monhoc_id" value="{{$monhoc_id}}">
                <input type="hidden" name="dethi_id" value="{{$dethi_id}}">

                <!-- Danh sách sinh viên -->
                <button style="margin-right: 30px;" type="button" class="btn btn-primary float-end" id="checkAll">Check 30 SV</button>
                <button style="margin-right: 30px;" type="submit" class="btn btn-primary float-end">Thêm Vào Lịch Thi</button>
            </form>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th style="text-align: center;">STT</th>
                <th>Họ Tên</th>
                <th>Ngày Sinh</th>
                <th>Phái</th>
                <th>Địa Chỉ</th>
                <th>Phường Xã</th>
                <th>Quận Huyện</th>
                <th>Tỉnh Thành</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @php
            $counter = 1;
            @endphp
            @foreach($dssinhvien as $sinhvien)
            <tr>
                <td style="text-align: center;">{{ $counter++ }}</td>
                <td>{{ $sinhvien->HoTen }}</td>
                <td>{{ date('d/m/Y', strtotime($sinhvien->NgaySinh)) }}</td>
                <td>
                    @if ($sinhvien->Phai == 0)
                    Nam
                    @elseif ($sinhvien->Phai == 1)
                    Nữ
                    @endif
                </td>
                <td>{{ $sinhvien->DiaChi }}</td>
                <td>{{ $sinhvien->PhuongXa }}</td>
                <td>{{ $sinhvien->QuanHuyen }}</td>
                <td>{{ $sinhvien->TinhThanh }}</td>
                <td>
                    <input type="checkbox" class="checkbox-sinhvien" name="sinhvien[]" value="{{ $sinhvien->UserID }}">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dssinhvien->onEachSide(1)->links() }}<br />
</div>





@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Sự kiện khi chọn môn học
        $('#monhoc_id').change(function() {
            // Lấy giá trị đã chọn

            var selectedMonHoc = $(this).val();
            // Disable dropdown đề thi và reset giá trị
            $('#dethi_id').prop('disabled', true).val('');

            // Nếu có môn học được chọn
            if (selectedMonHoc !== '') {
                // Hiển thị danh sách đề thi của môn học đã chọn
                $('optgroup').hide();
                $('#dsLichThi-' + selectedMonHoc).show();

                // Enable dropdown đề thi
                $('#dethi_id').prop('disabled', false);
            }

        });
        $('#checkAll').click(function() {
            // Lấy danh sách tất cả checkbox sinh viên
            var checkboxes = $('.checkbox-sinhvien');

            // Đảm bảo chỉ kiểm tra 30 checkbox đầu tiên
            checkboxes.slice(0, 30).prop('checked', true);
        });

        // Sự kiện khi nhấn từng checkbox sinh viên
        $('.checkbox-sinhvien').change(function() {
            var totalChecked = $('.checkbox-sinhvien:checked').length;
            var totalSinhVien = $('.checkbox-sinhvien').length;

            // Kiểm tra nếu tất cả checkbox đã được chọn, check nút kiểm tra tất cả
            $('#checkAll').prop('checked', totalChecked === totalSinhVien);
        });
        $('#addSinhVienForm').submit(function(e) {
            // Ngăn chặn hành động mặc định của form
            e.preventDefault();

            // Lấy danh sách sinh viên đã chọn
            var selectedSinhVien = [];
            $('.checkbox-sinhvien:checked').each(function() {
                selectedSinhVien.push($(this).val());
            });

            if (selectedSinhVien.length === 0) {
                // Hiển thị thông báo lỗi
                alert('Vui lòng chọn ít nhất một sinh viên để thêm vào lịch thi.');
            } else {
                // Thêm danh sách sinh viên đã chọn vào input ẩn trong form
                $('<input>').attr({
                    type: 'hidden',
                    name: 'selectedSinhVien',
                    value: selectedSinhVien.join(',')
                }).appendTo('#addSinhVienForm');

                // Submit form
                $('#addSinhVienForm').unbind('submit').submit();
            }
        });
    });
</script>