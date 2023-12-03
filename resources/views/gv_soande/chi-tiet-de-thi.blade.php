@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
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
<div style="height: 1000px; width: 900px; background-color: white;margin: auto;">
    <div class="container">
        <h2 style="text-align: center">{{ $title }}</h2>
        <h3 style="text-align: center">Môn học: {{ $dethis->MonHoc->TenMH }}</h3>
        <h3 style="text-align: center">Đề thi: {{ $dethis->TenDeThi }}</h3>
        <h3 style="text-align: center">Số lượng câu hỏi: {{ $dethis->SoLuongCH }}</h3>

        <div style="margin-top: 30px; margin-left: 36%">
            <button id="toggleButton" class="btn btn-success" onclick="taoDeVoiCauHoiNgauNhien()">Tạo đề với câu hỏi ngẫu nhiên</button>
        </div>
        <div style="margin-top: 30px; text-align: center">
            <button class="btn btn-primary" onclick="toggleForm()">Tạo đề theo mức độ từng chương</button>
        </div>


        <!-- Form 2 -->
        <form id="form2" method="post" action="{{ route('luu-so-luong-cau-hoi', ['id' => $dethis->MaDe]) }}" style="display: none;">
            @csrf
            <div style="background-color: aqua; padding: 10px; border-radius: 10px;">
                <!-- Hiển thị thông tin chương và số lượng câu giỏi, khá, trung bình cho mỗi chương -->
                @foreach($cautaos as $sochuong => $cautao)
                <div>
                    <h4>Chương: {{ $sochuong + 1 }}</h4>
                    <h5> Số câu: {{$cautao->SoLuongCH }}</h5>
                    @foreach(['gioi' => 'giỏi', 'kha' => 'khá', 'trungbinh' => 'trung bình'] as $level => $md)
                    <label style="padding-left: 20px" for="{{ $level }}_{{ $cautao->MaChuong }}">Số câu {{ $md }}:</label>
                    <input size="15px" type="text" name="{{ $level }}_{{ $cautao->MaChuong }}" id="{{ $level }}_{{ $cautao->MaChuong }}" value="{{ old($level . '_' . $cautao->MaChuong) ?? 0 }}">
                    @endforeach
                </div>
                @endforeach
            </div>

            <button style="margin-top: 20px; margin-left: 45%" class="btn btn-primary" type="submit">Lưu</button>
        </form>

    </div>
</div>

<script>
    function taoDeVoiCauHoiNgauNhien() {
        // Thực hiện các hành động bạn muốn khi nhấp vào nút "Tạo đề với câu hỏi ngẫu nhiên"

        // Ví dụ: Chuyển hướng đến route 'them-cau-hoi-rand'
        window.location.href = "{{ route('them-cau-hoi-rand', ['id' => $dethis->MaDe]) }}";
    }
    var form2Visible = false;

    function toggleForm() {
        var form2 = document.getElementById('form2');
        var toggleButton = document.getElementById('toggleButton');

        // Đảo ngược trạng thái hiển thị của form2
        form2Visible = !form2Visible;

        // Hiển thị hoặc ẩn form2 và thay đổi nội dung của button
        if (form2Visible) {
            form2.style.display = 'block';
            toggleButton.style.display = 'none';
        } else {
            form2.style.display = 'none';
            toggleButton.style.display = 'block';
        }
    }
</script>

@endsection