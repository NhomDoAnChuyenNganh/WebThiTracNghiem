@extends('layouts.app', ['homeLink' => route('trang-chu-can-bo-coi-thi'),
'additionalLinks' => [['url' => route('coi-thi'), 'label' => 'Coi Thi']]])
@section('content')

<h1>Nội dung trang chủ cán bộ coi thi</h1>

@endsection