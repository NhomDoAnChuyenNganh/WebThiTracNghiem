@extends('layouts.app', ['homeLink' => route('trang-chu-quan-ly'),
'additionalLinks' => [['url' => route('ql-user'), 'label' => 'Quản lý người dùng'],
['url' => route('ql-monhoc'), 'label' => 'Quản lý môn học'],
['url' => route('ql-phongthi'), 'label' => 'Quản lý phòng thi'],
['url' => route('phan-bo-sinh-vien'), 'label' => 'Phân bổ sinh viên'],
['url' => route('tao-de-thi'), 'label' => 'Tạo đề thi'],
['url' => route('ql-thi'), 'label' => 'Quản lý thi'],
['url' => route('thong-ke'), 'label' => 'Thống kê']
]])

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div style="background-color: white">
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="margin: auto;">Thống Kê</h1>
    </div>
    <canvas id="thongKeChart"></canvas>
</div>
<script>
    // Lấy dữ liệu từ PHP và chuyển đổi thành JavaScript
    var thongKeDataTrenNamDiem = {!! json_encode($thongKeDataTrenNamDiem) !!};
    var thongKeDataDuoiNamDiem = {!! json_encode($thongKeDataDuoiNamDiem) !!};
    var soluongthisinh = {!! json_encode($soluongthisinh) !!};

    // Lấy tất cả các tên môn học từ cả hai mảng
    var allSubjects = [...new Set([...thongKeDataTrenNamDiem.map(item => item.TenMH), ...thongKeDataDuoiNamDiem.map(item => item.TenMH)])];

    // Đảm bảo rằng cả hai mảng chứa thông tin cho cùng một danh sách các môn học
    thongKeDataTrenNamDiem = allSubjects.map(subject => {
        var subjectData = thongKeDataTrenNamDiem.find(item => item.TenMH === subject);
        return subjectData || { TenMH: subject, so_luong_sinh_vien: 0 };
    });

    thongKeDataDuoiNamDiem = allSubjects.map(subject => {
        var subjectData = thongKeDataDuoiNamDiem.find(item => item.TenMH === subject);
        return subjectData || { TenMH: subject, so_luong_sinh_vien: 0 };
    });

    // Tạo thẻ canvas
    var ctx = document.getElementById('thongKeChart').getContext('2d');

    // Tạo biểu đồ cột
    var thongKeChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: thongKeDataTrenNamDiem.map(item => item.TenMH), // Tên các cột (môn học)
            datasets: [
                {
                    label: 'Số lượng sinh viên từ 5 điểm trở lên',
                    data: thongKeDataTrenNamDiem.map(item => item.so_luong_sinh_vien), // Giá trị tương ứng với mỗi cột
                    backgroundColor: 'rgba(75, 192, 192, 1)', // Màu nền cột
                    borderColor: 'rgba(20, 175, 175, 1)', // Màu đường viền cột
                    borderWidth: 1
                },
                {
                    label: 'Số lượng sinh viên dưới 5',
                    data: thongKeDataDuoiNamDiem.map(item => item.so_luong_sinh_vien),
                    backgroundColor: 'rgba(255, 99, 132, 1)', // Màu nền cột
                    borderColor: 'rgba(255, 99, 132, 1)', // Màu đường viền cột
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    // max: soluongthisinh, // Đặt giá trị cao nhất cho trục y
                    title: {
                        display: true,
                        text: 'Số lượng sinh viên',
                        font: {
                            size: 16,
                            weight: 'bold'
                        }
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Môn học',
                        font: {
                            size: 20,
                            weight: 'bold'
                        }
                    }
                }
            }
        }
    });

    // Thêm đường giới hạn số lượng sinh viên
    var limitLine = {
        scaleID: 'y',
        value: soluongthisinh,
        borderColor: 'red',
        borderWidth: 2,
        label: {
            display: true,
            content: 'Số lượng sinh viên tối đa'
        }
    };
    thongKeChart.options.plugins.annotation = {
        annotations: {
            limitLine: limitLine
        }
    };
</script>
@endsection