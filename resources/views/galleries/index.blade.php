<!DOCTYPE html>
<html>

<head>
  <script
    src="https://kit.fontawesome.com/aa80f1a8dd.js"
    crossorigin="anonymous"></script>
  <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trường Đại học Thủ Dầu Một</title>
  <link rel="stylesheet" href="{{asset('css/gallery.css')}}" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <style>
    *{
      font-family: "Montserrat", sans-serif !important;
      margin: 0;
      padding: auto;
    }
  </style>
</head>

<body>
  <header>
    <a href="{{route('home')}}"><img src="{{ Vite::asset('resources/images/logo.png') }}" height="128" width="128" class="logo" /></a>
    <h2>Thư viện ảnh hoạt động</h2>
  </header>

  <main>
    <div class="container_grid">
      <div class="modal">
        <div class="carousel">
          <div id="close-carousel">
            <div class="x">
              <div id="barra1"></div>
              <div id="barra2"></div>
            </div>
          </div>
          <div class="setas">
            <div class="seta-esq">
              <div id="prev-card">
              <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 320 512" style="left: 0;padding: 0 0 0 2%;"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M34.5 239L228.9 44.7c9.4-9.4 24.6-9.4 33.9 0l22.7 22.7c9.4 9.4 9.4 24.5 0 33.9L131.5 256l154 154.8c9.3 9.4 9.3 24.5 0 33.9l-22.7 22.7c-9.4 9.4-24.6 9.4-33.9 0L34.5 273c-9.4-9.4-9.4-24.6 0-33.9z"/></svg>
              </div>
            </div>
            <div class="seta-dir">
              <div id="next-card">
              <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 320 512" style="right: 0;padding: 0 2% 0 0;"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#ffffff" d="M285.5 273L91.1 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.7-22.7c-9.4-9.4-9.4-24.5 0-33.9L188.5 256 34.5 101.3c-9.3-9.4-9.3-24.5 0-33.9l22.7-22.7c9.4-9.4 24.6-9.4 33.9 0L285.5 239c9.4 9.4 9.4 24.6 0 33.9z"/></svg>
              </div>
            </div>
          </div>
          <div class="centered-container">
            <img class="modal-content" src="" alt="" />
          </div>
        </div>
        <span class="close"></span>
      </div>
      <div class="carousel-images">
        @forelse($images as $image)
        @php
            // Tạo số ngẫu nhiên từ 0 đến 3
            $randomIndex = rand(0, 3);
            
            // Sử dụng switch-case với số ngẫu nhiên
            switch ($randomIndex) {
                case 0:
                case 1:
                    $class = 'card_small';
                    break;
                case 2:
                    $class = 'card_medium';
                    break;
                case 3:
                    $class = 'card_large';
                    break;
            }
        @endphp

        <div class="{{ $class }} card_exp">
          <img
            loading="lazy"
            class="img_card"
            src="{{ asset('storage/' . $image->path) }}"
            alt="{{ $image->alt ?? '' }}" />
        </div>

        @empty
        <!-- <div style="text-align: center; display: flex; justify-content: center; align-items: center; height: 200px;">
          <p>Chưa có hình ảnh nào được thêm.</p>
        </div> -->
        @endforelse
      </div>
    </div>
  </main>
  <footer>Đoàn kết - Ứng dụng số - Kết nối - Sáng tạo - Bản lĩnh - Kiến tạo tương lai</footer>
  <script src="{{asset('js/gallery.js')}}"></script>
</body>

</html>