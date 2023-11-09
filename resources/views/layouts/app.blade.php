<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIÁO VIÊN SOẠN ĐỀ</title>

    <!-- Bổ sung các tài liệu CSS và JavaScript ở đây -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/">Trang chủ</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
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
