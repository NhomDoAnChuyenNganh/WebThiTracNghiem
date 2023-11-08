<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="../img/logo.ico">
    <title>Reset Password</title>
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
    <div class="container text-center d-flex align-items-center min-vh-100">
        <div class="card mx-auto bg-info py-5" style="width: 25rem;">
            <h1>Đặt Lại Mật Khẩu</h1>
            <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label style="text-align: left;" for="matkhau" class="form-label">Mật Khẩu</label>
                    <input type="password" class="form-control" id="matkhau" name="matkhau" required>

                    @if ($errors->has('matkhau'))
                        <span class="text-danger">{{ $errors->first('matkhau') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="nhaplai" class="form-label">Nhập Lại</label>
                    <input type="password" class="form-control" id="nhaplai" name="nhaplai" required>

                    @if ($errors->has('nhaplai'))
                        <span class="text-danger">{{ $errors->first('nhaplai') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary" name="login">Submit</button><br><br>
                @csrf
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </form>
            </div>
        </div>
    </div>
</body>
</html>
