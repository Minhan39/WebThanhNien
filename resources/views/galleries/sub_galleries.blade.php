<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
    <title>Trường Đại học Thủ Dầu Một</title>
    <link rel="stylesheet" href="{{asset('css/gallery.css')}}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        *{
        font-family: "Montserrat", sans-serif !important;
        margin: 0;
      padding: auto;
        }
        body {
            margin: 0 auto;
        }
        .container{
            max-width: 1200px;
            padding: 20px;
            justify-self: center;
            padding-bottom: 4rem;
        }
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            margin-bottom: 30px;
            border-radius: 16px;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 1rem;
        }
        .menu-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .menu-item:hover {
            transform: translateY(-5px);
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <header>
        <a href="{{route('home')}}"><img src="{{ Vite::asset('resources/images/logo.png') }}" height="128" width="128" class="logo" /></a>
        <h2>Triển lãm hoạt động</h2>
    </header>
    <div class="container">
    <div class="video-container">
        <iframe 
            src="https://www.youtube.com/embed/lsPeE-LBfy4?si=I0E2HZHKtJeTuopG" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
        </iframe>
    </div>

    <div class="menu-grid">
        <a href="http://127.0.0.1:3000/1" class="menu-item">
            Công tác giáo dục
        </a>
        <a href="http://127.0.0.1:3000/2" class="menu-item">
            Tổ chức các phong trào hành động cách mạng phát huy vai trò xung kích, tình nguyện, sáng tạo
        </a>
        <a href="http://127.0.0.1:3000/3" class="menu-item">
            Tổ chức các chương trình đồng hành với thanh niên
        </a>
        <a href="http://127.0.0.1:3000/4" class="menu-item">
            Công tác xây dựng Đoàn, mở rộng mặt trận đoàn kết tập hợp thanh niên
        </a>
    </div>
    </div>
    <footer>Đoàn kết - Ứng dụng số - Kết nối - Sáng tạo - Bản lĩnh - Kiến tạo tương lai</footer>
</body>
</html>