<!DOCTYPE html>
<html>
  <head>
    <script
      src="https://kit.fontawesome.com/aa80f1a8dd.js"
      crossorigin="anonymous"
    ></script>
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
    <title>Tuổi trẻ Bến Cát</title>
    <link rel="stylesheet" href="{{asset('css/gallery.css')}}" />
  </head>
  <body>
    <header>
        <a href="{{route('home')}}"><img src="{{ Vite::asset('resources/images/logo.png') }}" height="128" width="128" class="logo" /></a>
      <h2>Uỷ ban Hội phường Mỹ Phước</h2>
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
          <div class="card_small card_exp">
            <img
              class="img_card"
              src="{{asset('images/my_phuoc/my_phuoc_1.jpg')}}"
              alt=""
            />
          </div>
          <div class="card_small card_exp">
            <img
              class="img_card"
              src="{{asset('images/my_phuoc/my_phuoc_2.jpg')}}"
              alt=""
            />
          </div>
          <!-- <div class="card_medium card_exp">
            <img
              class="img_card"
              src="{{asset('images/tan_dinh/tan_dinh_3.jpg')}}"
              alt=""
            />
          </div>
          <div class="card_large card_exp">
            <img
              class="img_card"
              src="{{asset('images/tan_dinh/tan_dinh_4.jpg')}}"
              alt=""
            />
          </div>
          <div class="card_small card_exp">
            <img
              class="img_card"
              src="{{asset('images/tan_dinh/tan_dinh_5.jpg')}}"
              alt=""
            />
          </div>
          <div class="card_small card_exp">
            <img
              class="img_card"
              src="{{asset('images/tan_dinh/tan_dinh_6.jpg')}}"
              alt=""
            />
          </div> -->
          <!-- <div class="card_medium card_exp">
            <img
              class="img_card"
              src="https://i.pinimg.com/736x/09/45/b8/0945b873ddd15f862b82890f82767e39.jpg"
              alt=""
            />
          </div>
          <div class="card_large card_exp">
            <img
              class="img_card"
              src="https://c.wallhere.com/photos/ab/f5/AI_art_landscape_digital_art_ocean_view_reflection_rocks_sunset_clouds-2223954.jpg!d"
              alt=""
            />
          </div> -->
        </div>
      </div>
    </main>
    <script src="{{asset('js/gallery.js')}}"></script>
  </body>
</html>
