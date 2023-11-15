<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-icon" href="../img/logo.ico">
    <title>{{ $title }}</title>
    <!-- Bổ sung các tài liệu CSS và JavaScript ở đây -->
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> -->
    <style>
        body {
            position: relative;
            min-height: 100vh;
            padding-top: 100px;
            padding-bottom: 400px;
        }

        header nav.navbar {
            box-shadow: 0 3px 5px rgba(57, 63, 72, 0.3);
        }

        footer {
            color: #fff;
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 20px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        ul li a {
            color: white;
            text-decoration: none;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .page-link-red {
            color: #ffffff;
            background-color: #ff0000;
            border-color: #ff0000;
        }
        body {
            background-image: url('/images/hinh1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container-fluid" style="height: 80px; max-width: 1200px">
                <a class="navbar-brand" href="/"><img src="/images/logo.png" style="max-height: 150px;" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Link 1</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Link 2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Link 3</a>
                        </li>
                    </ul>
                    <div class="ms-auto d-flex">
                        <a class="dropdown-item" href="{{ route('logout') }}">Đăng xuất</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main role="main">
        <div class="container">
            @yield('content') <!-- Đây là nơi nội dung cụ thể của từng trang sẽ được hiển thị -->
        </div>
    </main>

    <footer>
        <div class="container">
            <!-- Thêm thông tin footer của trang web ở đây -->
        </div>
    </footer>

    <!-- Bổ sung các tài liệu JavaScript ở đây -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>