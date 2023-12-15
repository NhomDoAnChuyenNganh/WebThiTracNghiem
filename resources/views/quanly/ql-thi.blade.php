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

<div class="noidung" style="height: 1000px; width: 1300px; background-color: white;margin: auto;">
    <div class="card-body" style="margin: 20px;">
        <form action="{{ route('taolichthi') }}" method="POST">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dethi_id" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Đề Thi</label>
                        <select id="dethi_id" name="dethi_id" class="form-select" disabled>
                            <option value=""></option>
                            @foreach($dsmon as $mon)
                            <optgroup label=" Các đề thi {{ $mon->TenMH }}" id="dsDeThi-{{ $mon->MaMH }}">
                                @foreach($mon->dsDeThi as $dethi)
                                <option value="{{ $dethi->MaDe}}">{{ $dethi->TenDeThi }} - {{ $dethi->ThoiGianLamBai}} phút</option>
                                @endforeach
                            </optgroup>
                            @endforeach
                        </select>
                        @if ($errors->has('dethi_id'))
                        <span class="text-danger">{{ $errors->first('dethi_id')}}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="ngay_thi" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Ngày Thi</label>
                        <input type="date" class="form-control text-left" id="ngay_thi" name="ngay_thi" required>
                    </div>
                    @if ($errors->has('ngay_thi'))
                    <span class="text-danger">{{ $errors->first('ngay_thi')}}</span>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="start_time" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Thời Gian Bắt Đầu</label>
                        <select id="start_time" name="start_time" class="form-select">
                            <option value=""></option>
                            @for ($hour = 7; $hour <= 22; $hour++) @for ($minute=0; $minute < 60; $minute +=5) <option value="{{ sprintf('%02d', $hour) }}:{{ sprintf('%02d', $minute) }}">{{ sprintf('%02d', $hour) }}:{{ sprintf('%02d', $minute) }}</option>
                                @endfor
                                @endfor
                        </select>
                        @if ($errors->has('start_time'))
                        <span class="text-danger">{{ $errors->first('start_time')}}</span>
                        @endif
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
                        @if ($errors->has('phong_id'))
                        <span class="text-danger">{{ $errors->first('phong_id')}}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="canbo_id" class="form-label" style="font-size: 25px; font-weight: bold;">Chọn Cán Bộ Coi Thi</label>
                        <select id="canbo_id" name="canbo_id" class="form-select">
                            <option value=""></option>
                            @foreach($dscanbo as $canbo)
                            <option value="{{ $canbo->UserID}}">{{ $canbo->HoTen }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('canbo_id'))
                        <span class="text-danger">{{ $errors->first('canbo_id')}}</span>
                        @endif
                    </div>
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
            <div class="row mb-3 justify-content-center">
                <div class="col-md-6 text-center">
                    <button type="submit" class="btn btn-success btn-lg mx-2">Tạo Lịch</button>
                </div>
            </div>
            @csrf
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Môn Thi</th>
                <th>Tên Đề</th>
                <th>Số Phút</th>
                <th>Ngày Thi</th>
                <th>Bắt Đầu</th>
                <th>Kết Thúc</th>
                <th>Số Câu</th>
                <th>Giáo Viên Soạn</th>
                <th>Cán Bộ</th>
                <th>Phòng Thi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dsdethi as $dethi)
            <tr>
                <td>{{ optional($dethi->MonHoc)->TenMH }}</td>
                <td>{{ $dethi->TenDeThi }}</td>
                <td>{{ $dethi->ThoiGianLamBai }} Phút</td>
                <td>{{ date('d/m/Y', strtotime($dethi->NgayThi)) }}</td>
                <td>{{ $dethi->ThoiGianBatDau }}</td>
                <td>{{ $dethi->ThoiGianKetThuc }}</td>
                <td>{{ $dethi->SoLuongCH }}</td>
                <td>{{ optional($dethi->giaoVienSoanDe)->HoTen }}</td>
                <td>{{ optional($dethi->canBoCoiThi)->HoTen }}</td>
                <td>{{ optional($dethi->phongThi)->TenPT }}</td>
                <td>
                    <a href="{{ route('delete-lichthi', ['id' => $dethi->MaDe]) }}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa lịch thi này?')">Xoá</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $dsdethi->onEachSide(1)->links() }}<br />
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
                $('#dsDeThi-' + selectedMonHoc).show();

                // Enable dropdown đề thi
                $('#dethi_id').prop('disabled', false);
            }

        });
    });
</script>