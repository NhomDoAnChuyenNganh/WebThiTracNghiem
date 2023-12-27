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
    <div class="container text-center d-flex align-items-center min-vh-100">
        <div class="card mx-auto bg-info py-5" style="width: 25rem;">
            <h1>Đăng Nhập</h1>
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <div class="card-body">
                <form action="/user/login" method="post">
                    <div class="mb-3">
                        <label style="text-align: left;" for="username" class="form-label">Tên Đăng Nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required>

                        @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>

                        @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Submit</button><br><br>
                    <a href="{{ route('forgot-password') }}" class="btn btn-primary" style="max-width: 200px;">Quên Mật Khẩu</a>
                    <a href="{{ route('register') }}" class="btn btn-primary" style="max-width: 200px;">Đăng Ký</a>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</body>

</html>