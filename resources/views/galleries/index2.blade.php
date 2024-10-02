<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
    <title>Tuổi trẻ Bến Cát</title>

    <style>
      * {
        margin: 0px;
        padding: auto;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
        letter-spacing: 0.1px;
        font-weight: 400;
      }
      .logo {
        width: 160px;
        height: 160px;
        border-radius: 8px;
      }
      header {
        background: linear-gradient(
          60deg,
          rgba(17, 74, 160, 1) 0%,
          rgba(17, 74, 160, 1) 100%
        );
        height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .box {
        text-decoration: none;
        color: black;
        margin: 8px;
      }
      .cover:hover {
        border: black 1px solid;
        border-radius: 8px;
      }
      .cover {
        float: left;
        height: 120px;
        width: 320px;
        border: 1px solid #ccc;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
      }
      .container {
        padding-top: 8px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
      }
      footer {
        position: fixed;
        bottom: 8px;
        left: 0px;
        right: 0px;
        text-align: center;
      }
      @media (max-width: 768px) {
        .cover {
          height: 80px;
          width: 90vw;
        }
        .container {
          padding-bottom: 32px;
        }
      }
    </style>
  </head>
  <body>
    <header>
    <a href="{{route('home')}}"><img src="{{ Vite::asset('resources/images/logo.png') }}" height="128" width="128" class="logo" /></a>
    </header>
    <div class="container">
      <a class="box" href="{{route('my_phuoc')}}">
        <div class="cover">
          <p class="text-box">Ủy ban Hội phường Mỹ Phước</p>
        </div>
      </a>
      <a class="box" href="{{route('tan_dinh')}}">
        <div class="cover">
          <p class="text-box">Ủy ban Hội phường Tân Định</p>
        </div>
      </a>
      <a class="box" href="{{route('phu_an')}}">
        <div class="cover">
          <p class="text-box">Ủy ban Hội xã Phú An</p>
        </div>
      </a>
      <a class="box" href="{{route('hoa_loi')}}">
        <div class="cover">
          <p class="text-box">Ủy ban Hội phường Hòa Lợi</p>
        </div>
      </a>
      <a class="box" href="{{route('chanh_phu_hoa')}}">
        <div class="cover">
          <p class="text-box">Ủy ban Hội phường Chánh Phú Hòa</p>
        </div>
      </a>
      <a class="box" href="{{route('an_tay')}}">
        <div class="cover">
          <p class="text-box">Ủy ban Hội xã An Tây</p>
        </div>
      </a>
      <a class="box" href="{{route('an_dien')}}">
        <div class="cover">
          <p class="text-box">Ủy ban Hội xã An Điền</p>
        </div>
      </a>
    </div>
    <footer>Khát vọng cống hiến, lẽ sống thanh niên</footer>
  </body>
</html>
