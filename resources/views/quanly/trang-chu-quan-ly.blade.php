@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('ql-user'), 'label' => 'Quản lý người dùng'],
['url' => route('ql-monhoc'), 'label' => 'Quản lý môn học'],
['url' => route('ql-phongthi'), 'label' => 'Quản lý phòng thi'],
['url' => route('ql-thi'), 'label' => 'Quản lý thi'],
['url' => route('trang-chu-quan-ly'), 'label' => 'Thống kê']
]])

@section('content')



@endsection