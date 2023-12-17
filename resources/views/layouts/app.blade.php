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

        ul.navbar-nav {
            width: 100%;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        ul.navbar-nav li.nav-item {
            margin-right: 20px;
        }

        ul.navbar-nav li.nav-item a {
            color: black;
        }

        ul.navbar-nav li.nav-item a.nav-link.active {
            color: #0d6efd;
        }

        ul li a {
            color: white;
            text-decoration: none;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
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
            <div class="container-fluid" style="height: 80px; max-width: 1300px">
                <a class="navbar-brand" href="{{ $homeLink }}"><img src="/images/logo.png" style="max-height: 150px;" /></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @foreach ($additionalLinks as $link)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="dropdown">
                        <a class="btn btn-link position-relative" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user" style="color: black;"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('trang-chu-sinh-vien') }}">Dành cho sinh viên</a>
                            <a class="dropdown-item" href="{{ route('trang-chu-giao-vien-soan-de') }}">Dành cho giáo viên soạn đề</a>
                            <a class="dropdown-item" href="{{ route('trang-chu-can-bo-coi-thi') }}">Dành cho cán bộ coi thi</a>
                            <a class="dropdown-item" href="{{ route('trang-chu-quan-ly') }}">Dành cho quản lý</a>
                        </div>
                    </div>
                    <div class="ms-auto d-flex">
                        @if (!session('user'))
                        <a class="dropdown-item" href="{{ route('login') }}">Đăng nhập</a>
                        @else
                        <a class="dropdown-item" href="{{ route('logout') }}">Đăng xuất</a>
                        @endif
                    </div>

                </div>
            </div>
        </nav>
    </header>

    <main role="main">
        <div class="container mt-3" style="min-height: 1000px;">
            @yield('content') <!-- Đây là nơi nội dung cụ thể của từng trang sẽ được hiển thị -->
        </div>
    </main>

    <footer class="text-center text-lg-start text-dark" style="background-color: #ECEFF1">
        <div class="container">
            <section class="">
                <div class="container text-center text-md-start mt-5">
                    <div class="row mt-3">
                        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                            <h6 class="text-uppercase fw-bold">NHCQuiz</h6>
                            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />
                            <p>
                                Hệ thống thi trắc nghiệm online dành cho các trường đại học tại Việt Nam
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold">Điều khoản</h6>
                            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />
                            <p>
                                <a href="#!" class="text-dark">Điều khoản sử dụng</a>
                            </p>
                            <p>
                                <a href="#!" class="text-dark">Điều khoản bảo mật thông tin</a>
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold">Liên kết</h6>
                            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />
                            <p>
                                <a href="{{ $homeLink }}" class="text-dark">Trang chủ</a>
                            </p>
                            <p>
                                <a href="#!" class="text-dark">Hướng dẫn</a>
                            </p>
                            <p>
                                <a href="#!" class="text-dark">Liên hệ</a>
                            </p>
                        </div>
                        <!-- Grid column -->

                        <!-- Grid column -->
                        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                            <!-- Links -->
                            <h6 class="text-uppercase fw-bold">Thông tin liên hệ</h6>
                            <hr class="mb-4 mt-0 d-inline-block mx-auto" style="width: 60px; background-color: #7c4dff; height: 2px" />
                            <p><i class="fas fa-home mr-3"></i> 140, Lê Trọng Tấn, Thành Phố Hồ Chí Minh</p>
                            <p><i class="fas fa-envelope mr-3"></i> nhat7858@gmail.com</p>
                            <p><i class="fas fa-phone mr-3"></i> (+84) 936 018 006</p>
                            <p><i class="fas fa-print mr-3"></i> (+84) 936 018 006</p>
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                </div>
            </section>
            <!-- Section: Links  -->

            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
                © 2023 Copyright:
                <a class="text-dark" href="/">NHCQuiz</a>
            </div>
            <!-- Copyright -->
        </div>

    </footer>
    <!-- Footer -->

    <!-- Bổ sung các tài liệu JavaScript ở đây -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        var citis = document.getElementById("city");
        var districts = document.getElementById("district");
        var wards = document.getElementById("ward");

        var Parameter = {
            url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
            method: "GET",
            responseType: "application/json",
        };

        var promise = axios(Parameter);
        promise.then(function (result) {
            renderCity(result.data);
        });

        function renderCity(data) {
            for (const x of data) {
                citis.options[citis.options.length] = new Option(x.Name, x.Name);
            }
            citis.onchange = function () {
                district.length = 1;
                ward.length = 1;
                if (this.value !== "") {
                    const result = data.filter(n => n.Name === this.value);

                    for (const k of result[0].Districts) {
                        district.options[district.options.length] = new Option(k.Name, k.Name);
                    }
                }
            };
            district.onchange = function () {
                ward.length = 1;
                const dataCity = data.filter((n) => n.Name === citis.value);
                if (this.value !== "") {
                    const dataWards = dataCity[0].Districts.filter(n => n.Name === this.value)[0].Wards;

                    for (const w of dataWards) {
                        wards.options[wards.options.length] = new Option(w.Name, w.Name);
                    }
                }
            };
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
</body>

</html>