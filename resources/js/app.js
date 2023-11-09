import './bootstrap';

    $(document).ready(function() {
        // Lắng nghe sự kiện khi thay đổi môn học và nạp dữ liệu vào dropdown chương tương ứng.
        $('#MonHoc').on('change', function() {
            var mamh = $(this).val();
            if (mamh) {
                $.ajax({
                    type: 'GET',
                    url: '/get-chuongs/' + mamh,
                    success: function(data) {
                        $('#Chuong').empty();
                        $.each(data, function(key, value) {
                            $('#Chuong').append('<option value="' + key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('#Chuong').empty();
            }
        });
    });