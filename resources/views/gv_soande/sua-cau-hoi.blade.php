@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('them-chuong'), 'label' => 'Chương'],
['url' => route('them-doan'), 'label' => 'Đoạn văn'],
['url' => route('danh-sach-cau-hoi'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('soan-de'), 'label' => 'Soạn đề']]])

@section('content')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div style="background-color: white" class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">Sửa Câu Hỏi</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('cap-nhat-cau-hoi', ['id' => $cauhoi->MaCH]) }}">
                    @csrf
                    @method('PUT')

                    <!-- Các trường thông tin câu hỏi để người dùng nhập liệu -->
                    <div class="form-group">
                        <label for="NoiDung">Nội Dung Câu Hỏi</label>
                        <textarea style="max-width: 500px;" class="form-control" id="NoiDung" name="NoiDung" rows="3" required>{{ $cauhoi->NoiDung }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="MucDo">Chọn Mức Độ</label>
                        <select style="max-width: 350px;" class="form-control" id="MucDo" name="MucDo" required>
                            <option value="Giỏi" {{ $cauhoi->MucDo == 'Giỏi' ? 'selected' : '' }}>Giỏi</option>
                            <option value="Khá" {{ $cauhoi->MucDo == 'Khá' ? 'selected' : '' }}>Khá</option>
                            <option value="Trung Bình" {{ $cauhoi->MucDo == 'Trung Bình' ? 'selected' : '' }}>Trung Bình</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="MaLoai">Loại Câu Hỏi</label>
                        <select style="max-width: 350px;" class="form-control" id="MaLoai" name="MaLoai" disabled>
                            <option value="1" {{ $cauhoi->MaLoai == 1 ? 'selected' : '' }}>Trắc nghiệm một đáp án</option>
                            <option value="2" {{ $cauhoi->MaLoai == 2 ? 'selected' : '' }}>Trắc nghiệm nhiều đáp án</option>
                            <option value="3" {{ $cauhoi->MaLoai == 3 ? 'selected' : '' }}>Điền khuyết</option>
                        </select>

                        <input type="hidden" name="MaLoai" value="{{ $cauhoi->MaLoai }}">
                    </div>

                    @if ($cauhoi->MaLoai == 3)
                    <div class="form-group">
                        <label for="DapAn">Đáp Án</label>
                        <input value="{{ $cauhoi->dapan->first()->NoiDungDapAn }}" style="max-width: 500px;" type="text" class="form-control" id="DapAn" name="DapAn">
                    </div>
                    @else
                    <!-- Hiển thị số lượng đáp án -->
                    <div class="form-group" style="display: none">
                        <label for="SoLuongDapAn">Số Lượng Đáp Án</label>
                        <select style="max-width: 350px;" id="SoLuongDapAn" name="SoLuongDapAn" class="form-control" required>
                            <option value="4" {{ count($cauhoi->dapan) == 4 ? 'selected' : '' }}>4 Đáp Án</option>
                            <option value="5" {{ count($cauhoi->dapan) == 5 ? 'selected' : '' }}>5 Đáp Án</option>
                            <option value="6" {{ count($cauhoi->dapan) == 6 ? 'selected' : '' }}>6 Đáp Án</option>
                        </select>
                    </div>

                    <!-- Container để chứa các đáp án -->
                    <div id="dapAnContainer">
                        @foreach($cauhoi->dapan as $index => $dapAn)
                        <div class="form-group">
                            <label for="DapAn{{ $index + 1 }}">Đáp Án {{ $index + 1 }}</label>
                            <input style="max-width: 500px;" type="text" class="form-control" id="DapAn{{ $index + 1 }}" name="DapAn{{ $index + 1 }}" value="{{ $dapAn->NoiDungDapAn }}">
                            <input type="checkbox" id="DapAn{{ $index + 1 }}Checkbox" name="DapAnDung[]" value="{{ $index + 1 }}" {{ $dapAn->LaDapAnDung ? 'checked' : '' }}> Đáp án đúng
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <button type="submit" class="btn btn-primary">Cập Nhật Câu Hỏi</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection