@extends('layouts.app', ['homeLink' => route('trang-chu-giao-vien-soan-de'),
'additionalLinks' => [['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn ngân hàng câu hỏi'],
['url' => route('trang-chu-giao-vien-soan-de'), 'label' => 'Soạn đề']]])

@section('content')

<ul class="nav nav-fill nav-tabs" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="fill-tab-0" data-bs-toggle="tab" href="#fill-tabpanel-0" role="tab" aria-controls="fill-tabpanel-0" aria-selected="true"> Ngân hàng câu hỏi </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="fill-tab-1" data-bs-toggle="tab" href="#fill-tabpanel-1" role="tab" aria-controls="fill-tabpanel-1" aria-selected="false"> Môn học </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="fill-tab-2" data-bs-toggle="tab" href="#fill-tabpanel-2" role="tab" aria-controls="fill-tabpanel-2" aria-selected="false"> Chương </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="fill-tab-3" data-bs-toggle="tab" href="#fill-tabpanel-3" role="tab" aria-controls="fill-tabpanel-2" aria-selected="false"> Đoạn văn </a>
    </li>
</ul>
<div class="tab-content pt-5" id="tab-content">
    <div class="tab-pane active" id="fill-tabpanel-0" role="tabpanel" aria-labelledby="fill-tab-0">
        <a href="#" class="btn btn-primary">Thêm câu hỏi</a>
    </div>
    <div class="tab-pane" id="fill-tabpanel-1" role="tabpanel" aria-labelledby="fill-tab-1">
        <a href="/gv_soande/them-mon-hoc" class="btn btn-primary">Thêm môn học</a>
    </div>
    <div class="tab-pane" id="fill-tabpanel-2" role="tabpanel" aria-labelledby="fill-tab-2">
        <a href="/gv_soande/them-chuong" class="btn btn-primary">Thêm chương</a>
    </div>
    <div class="tab-pane" id="fill-tabpanel-3" role="tabpanel" aria-labelledby="fill-tab-2">
        <a href="/gv_soande/them-doan" class="btn btn-primary">Thêm đoạn văn</a>
    </div>
</div>

@endsection