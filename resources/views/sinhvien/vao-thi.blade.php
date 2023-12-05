@extends('layouts.app', ['homeLink' => route('trang-chu-can-bo-coi-thi'),
'additionalLinks' => [['url' => route('trang-chu-can-bo-coi-thi'), 'label' => 'Coi thi']]])


@section('content')
<div style="background-color: white">
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
   
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="margin: auto;">Bài Làm</h1>
        {{-- Nội dung khác của trang --}}
    </div>
    <form name="FormThi" method="post" action="{{ route('ket-qua', ['id' => $dethi->MaDe])}}">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div style="margin-left: 60px;">
                    @if(isset($dsCauHoiVaDapAn) && !empty($dsCauHoiVaDapAn))
                        @php
                            // Xáo trộn mảng câu hỏi và đáp án
                            shuffle($dsCauHoiVaDapAn);
                        @endphp

                        @foreach($dsCauHoiVaDapAn as $index => $item)
                            @php
                                // Kiểm tra nếu là câu hỏi điền khuyết
                                $isCauHoiDienKhuyet = ($item['LoaiCauHoi'] == "Điền khuyết");
                                $soLuongDapAnDung = count(array_filter($item['DanhSachDapAn'], function($dapAn) {
                                    return $dapAn['LaDapAnDung'] == true;
                                }));
                                
                                // Thay thế dấu "..." bằng ô nhập liệu
                                $noiDungCauHoi = $isCauHoiDienKhuyet ? str_replace('...', '<input type="text" name="dap_an_dien_khuyet['.$item['MaCauHoi'].']">', $item['NoiDungCauHoi']) : $item['NoiDungCauHoi'];
                            @endphp
                            @if ($soLuongDapAnDung > 1)
                                <p>Câu hỏi {{ $index + 1 }}: {!! $noiDungCauHoi !!} (Câu chọn  {{ $soLuongDapAnDung }} đáp án)</p>
                            @else
                                <p>Câu hỏi {{ $index + 1 }}: {!! $noiDungCauHoi !!}</p>
                            @endif

                            @if (!$isCauHoiDienKhuyet)
                                <ul style="list-style-type: none; padding-left: 0;">
                                    @php
                                        // Xáo trộn mảng đáp án
                                        shuffle($item['DanhSachDapAn']);
                                    @endphp
                                    @if ($soLuongDapAnDung > 1)
                                        @foreach($item['DanhSachDapAn'] as $dapAn)
                                            <li style="margin-left: 30px;">
                                                <input type="checkbox" name="dap_an[{{ $item['MaCauHoi'] }}][]" value="{{ $dapAn['MaDapAn'] }}">
                                                {{ $dapAn['NoiDungDapAn'] }}
                                            </li>
                                        @endforeach  
                                    @else
                                        @foreach($item['DanhSachDapAn'] as $dapAn)
                                            <li style="margin-left: 30px;">
                                                <input type="radio" name="dap_an[{{ $item['MaCauHoi'] }}][]" value="{{ $dapAn['MaDapAn'] }}">
                                                {{ $dapAn['NoiDungDapAn'] }}
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            @endif
                        @endforeach
                    @else
                        <p>Không có dữ liệu câu hỏi và đáp án.</p>
                    @endif
                    </div>
                </div>
                <div class="col-md-5">
                    <div style="margin-left: 60px;">
                        <p><strong>Môn học:</strong> {{ optional($dethi->MonHoc)->TenMH}}</p>
                        <p><strong>Thời gian làm bài:</strong> {{ $dethi->ThoiGianLamBai }} Phút</p>
                        <p><strong>Ngày thi:</strong> {{ date('d/m/Y', strtotime($dethi->NgayThi)) }}</p>
                        <p><strong>Thời gian còn lại:</strong> <span id="thoiGianConLai"></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <button style=" margin-bottom: 50px; padding-left: 50px; padding-right: 50px;" type="submit" class="btn btn-primary">Nộp bài</button>
        </div>
    </form>
</div>
<script>
    // Lấy thời gian còn lại từ PHP và chuyển đổi thành giây
    var thoiGianConLai = {{ $dethi->ThoiGianLamBai * 60 }}; // Thời gian làm bài theo phút

    // Hàm cập nhật thời gian còn lại và hiển thị
    function capNhatThoiGian() {
        var phut = Math.floor(thoiGianConLai / 60);
        var giay = thoiGianConLai % 60;

        // Hiển thị thời gian còn lại
        document.getElementById('thoiGianConLai').innerHTML = phut + ' phút ' + giay + ' giây';

        // Giảm thời gian còn lại
        thoiGianConLai--;

        // Kiểm tra nếu thời gian còn lại hết, có thể thêm xử lý ở đây
        if (thoiGianConLai < 0) {
            alert('Hết thời gian làm bài!');
            // Tự động nộp form
            document.forms["FormThi"].submit();
        }
    }

    // Gọi hàm cập nhật mỗi giây
    setInterval(capNhatThoiGian, 1000);
</script>
@endsection
