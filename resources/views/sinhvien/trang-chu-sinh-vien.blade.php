@extends('layouts.app', ['homeLink' => route('trang-chu-sinh-vien'),
'additionalLinks' => [['url' => route('trang-chu-sinh-vien'), 'label' => 'Vào thi'],
['url' => route('trang-chu-sinh-vien'), 'label' => 'Xem kết quả']]])

@section('content')

<h1>Nội dung trang chủ sinh viên</h1>

@endsection