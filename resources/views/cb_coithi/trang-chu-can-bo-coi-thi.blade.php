@extends('layouts.app', ['homeLink' => route('trang-chu-can-bo-coi-thi'),
'additionalLinks' => [['url' => route('trang-chu-can-bo-coi-thi'), 'label' => 'Danh sách sinh viên']]])

@section('content')

<h1>Nội dung trang chủ cán bộ coi thi</h1>

@endsection