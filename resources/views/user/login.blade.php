<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="../img/logo.ico">
    <style>
        
        body{
            background-image: url("C:/Users/Admin/Downloads/hinhwed/hinh1.jpg");
        }
        
    </style>
</head>
<body>
    <div class="container text-center d-flex align-items-center min-vh-100">
        <div class="card mx-auto bg-info py-5" style="width: 25rem;">
            <h1>Đăng Nhập</h1>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên Đăng Nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Submit</button><br><br>
                    <a href="forget-password.php" class="btn btn-primary" style="max-width: 200px;">Forget Password</a>
                    <a href="forget-password.php" class="btn btn-primary" style="max-width: 200px;">Register</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
