<!DOCTYPE html>
<html>

<head>
  <script
    src="https://kit.fontawesome.com/aa80f1a8dd.js"
    crossorigin="anonymous"></script>
  <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
  <title>Tuổi trẻ Bến Cát</title>
  <link rel="stylesheet" href="{{asset('css/gallery.css')}}" />
</head>

<body>
  <header>
    <a href="{{route('home')}}"><img src="{{ Vite::asset('resources/images/logo.png') }}" height="128" width="128" class="logo" /></a>
    <h2>Ảnh hoạt động</h2>
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
                <i class="fa-solid fa-angle-left" style="color: #ffffff"></i>
              </div>
            </div>
            <div class="seta-dir">
              <div id="next-card">
                <i class="fa-solid fa-angle-right" style="color: #ffffff"></i>
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
        // Sử dụng switch-case để chọn lớp CSS dựa trên index % 4
        switch ($loop->index % 4) {
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
            class="img_card"
            src="{{ asset('storage/' . $image->path) }}"
            alt="" />
        </div>

        @empty
        <!-- <div style="text-align: center; display: flex; justify-content: center; align-items: center; height: 200px;">
          <p>Chưa có hình ảnh nào được thêm.</p>
        </div> -->
        @endforelse
      </div>
    </div>
  </main>
  <script src="{{asset('js/gallery.js')}}"></script>
</body>

</html>