<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="../img/logo.ico">
    <title>{{ $title }}</title>
    <style>
    body {
        background-image: url('/images/hinh1.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
</style>
</head>
<body>
    <div class="container d-flex align-items-center min-vh-100">
        <div class="card mx-auto bg-info py-5" style="width: 38rem;">
            <h1 style="text-align: center;">Đăng Ký</h1>
            <div class="card-body">
                <form action="/user/register" method="post">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label style="text-align:left;" for="username" class="form-label">Tên Đăng Nhập</label>
                            <input type="text" class="form-control text-left" id="username" name="username" required>

                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control text-left" id="password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control text-left" id="email" name="email" required>

                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="ho_ten" class="form-label">Họ Tên </label>
                            <input type="text" class="form-control text-left" id="hoten" name="hoten" required>

                            @if ($errors->has('hoten'))
                                <span class="text-danger">{{ $errors->first('hoten') }}</span>
                            @endif
                        </div>  
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                                <label for="ngay_sinh" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control text-left" id="ngaysinh" name="ngaysinh" required>

                                @if ($errors->has('ngay_sinh'))
                                    <span class="text-danger">{{ $errors->first('ngay_sinh')}}</span>
                                @endif
                        </div>
                        <div  class="col-md-4">
                            <div class="form-group">
                                <label for="phai" class="form-label">Giới tính</label>
                                <select name="phai" class="form-select form-select-sm">
                                    <option value=""></option>
                                    <option value="0">Nam</option>
                                    <option value="1">Nữ</option>
                                </select>
                            </div>
                                @if ($errors->has('phai'))
                                    <span class="text-danger">{{ $errors->first('phai') }}</span>
                                @endif
                        </div>
                        <div class="col-md-4">
                            <label for="dia_chi" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control text-left" id="diachi" name="diachi" required>

                            @if ($errors->has('dia_chi'))
                                <span class="text-danger">{{ $errors->first('dia_chi') }}</span>
                            @endif
                        </div>                
                    </div>

                    <div class="row mb-3">
                        <div>
                            <select name="city" class="form-select form-select-sm mb-3" id="city" aria-label=".form-select-sm">
                            <option value="" selected>Chọn tỉnh thành</option>           
                            </select>
                                @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                @endif   

                            <select name="district" class="form-select form-select-sm mb-3" id="district" aria-label=".form-select-sm">
                            <option value="" selected>Chọn quận huyện</option>
                            </select>
                                @if ($errors->has('district'))
                                    <span class="text-danger">{{ $errors->first('district') }}</span>
                                @endif    

                            <select name="ward" class="form-select form-select-sm" id="ward" aria-label=".form-select-sm">
                            <option value="" selected>Chọn phường xã</option>
                            </select>
                                @if ($errors->has('ward'))
                                    <span class="text-danger">{{ $errors->first('ward') }}</span>
                                @endif   
                        </div>
                                
                    </div>
        

                    <div  style="text-align: center;" class="mb-3">
                        <button  type="submit" class="btn btn-primary">Đăng Ký</button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</body>
</html>
