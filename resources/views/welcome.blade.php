<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
  <title>Trường Đại học Thủ Dầu Một</title>
  <meta http-equiv="ScreenOrientation" content="autoRotate:disabled">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  @vite('resources/css/styles.css')
  <style>
    .button img {
      height: 80px !important;
      width: auto !important;
    }

    *{
      font-family: "Montserrat", sans-serif !important;
    }

    footer {
      background-color: #f4f4f4;
      position: fixed !important;
      bottom: 0px;
      left: 0px;
      right: 0px;
      height: 48px;
      display: flex;
      justify-content: center;
      font-size: 0.8rem;
      line-height: 18px;
      letter-spacing: 0.7px;
      align-items: center;
    }

    .menu {
      padding-bottom: 48px !important;
    }

    @media (max-width: 768px) {
      .content {
        margin-top: 24vh;
        position: relative;
        flex-direction: column;
        bottom: 0px;
      }

      .menu {
        padding-bottom: 260px !important;
      }

      .button {
        width: 240px;
        height: auto;
      }

      .button img {
        width: 224px;
        height: 112px;
      }
    }
  </style>
</head>

<body>
  <div class="header">
    <img src="{{ Vite::asset('resources/images/logo.png') }}" class="logo" />
    <!--Content before waves-->
    <div class="inner-header flex">
      <h1>
        <span class="large" style="color: #ffffff; font-weight: bold">ĐẠI HỘI ĐẠI BIỂU</span><br/><span class="medium" style="color: #ffff00; font-weight: bold">ĐOÀN TNCS HỒ CHÍ MINH TRƯỜNG ĐẠI HỌC THỦ DẦU MỘT</span><br/><span class="medium" style="color: #cccccc; font-weight: normal;">LẦN THỨ VII NHIỆM KỲ 2024 - 2027</span>
      </h1>
    </div>

    <!--Waves Container-->
    <div>
      <svg
        class="waves"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        viewBox="0 24 150 28"
        preserveAspectRatio="none"
        shape-rendering="auto">
        <defs>
          <path
            id="gentle-wave"
            d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
        </defs>
        <g class="parallax">
          <use
            xlink:href="#gentle-wave"
            x="48"
            y="0"
            fill="rgba(255,255,255,0.7" />
          <use
            xlink:href="#gentle-wave"
            x="48"
            y="3"
            fill="rgba(255,255,255,0.5)" />
          <use
            xlink:href="#gentle-wave"
            x="48"
            y="5"
            fill="rgba(255,255,255,0.3)" />
          <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
        </g>
      </svg>
    </div>
    <!--Waves end-->
  </div>
  <!--Header ends-->

  <!--Content starts-->
  <div class="content flex menu">
    <a href="{{route('galleries')}}" target="_top" class="button"><img src="{{asset('images/thumbnail_1.png')}}" /><span
        style="text-transform: uppercase">Hình ảnh</span></a>
    <a href="{{route('trienlam')}}" target="_top" class="button"><img src="{{asset('images/thumbnail_6.png')}}" /><span
        style="text-transform: uppercase">Triển lãm</span></a>
    <a href="{{route('vankien')}}" target="_top" class="button"><img src="{{asset('images/thumbnail_2.png')}}" /><span style="text-transform: uppercase">Văn kiện</span></a>
    <!-- <a href="{{route('delegates.search.form')}}" target="_top" class="button"><img src="{{asset('images/thumbnail_3.jpg')}}" /><span
        style="text-transform: uppercase">Thẻ đại biểu</span></a> -->
    <a href="https://www.facebook.com/hsvdhtdm/?locale=vi_VN" target="_top" class="button"><img src="{{asset('images/thumbnail_4.png')}}" /><span
        style="text-transform: uppercase">FANPAGE</span></a>
    <a href="https://tuoitre.tdmu.edu.vn/" target="_top" class="button"><img src="{{asset('images/thumbnail_5.png')}}" /><span
        style="text-transform: uppercase">WEBSITE</span></a>
  </div>
  <!--Content ends-->
  <footer>Đoàn kết - Ứng dụng số - Kết nối - Sáng tạo - Bản lĩnh - Kiến tạo tương lai</footer>
</body>

</html>