@extends('layouts.app', ['homeLink' => route('trang-chu-sinh-vien'),
'additionalLinks' => [['url' => route('thi'), 'label' => 'Vào thi'],
['url' => route('xem-ket-qua'), 'label' => 'Xem kết quả']]])

@section('content')



@endsection