@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('trang-chu-quan-ly'), 'label' => 'Phân công giáo viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân công cán bộ'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Phân bổ sinh viên'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Thống kê'],
['url' => route('ql-user'), 'label' => 'Quản lý người dùng']]])

@section('content')

<div class="row">
    <div class="col-sm-6 bg-primary text-white p-3">
        Lorem ipsum...
    </div>
    <div class="col-sm-6 bg-dark text-white p-3">
        Sed ut perspiciatis...
    </div>
</div>


@endsection