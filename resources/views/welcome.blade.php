<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
    <title>Tuổi trẻ Bến Cát</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite('resources/css/styles.css')
    <style>
      .button img{
        height: 80px !important;
        width: auto !important;
      }
      @media (max-width: 768px){
        .content{
          margin-top: 24vh;
          position: relative;
          flex-direction: column;
          bottom: 0px;
        }
        footer{
          position: fixed;
          bottom: -8px;
          left: 0px;
          right: 0px;
        }
        .button{
          width: 240px;
          height: auto;
        }
        .button img{
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
          Trang tin đại hội XII<br />Thị xã Bến Cát<br /><span
            style="text-transform: lowercase"
            >(<i class="bi bi-hand-index-thumb-fill" style="font-size: 32px;"></i> daihoi.tuoitrebencat.com)</span
          >
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
          shape-rendering="auto"
        >
          <defs>
            <path
              id="gentle-wave"
              d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"
            />
          </defs>
          <g class="parallax">
            <use
              xlink:href="#gentle-wave"
              x="48"
              y="0"
              fill="rgba(255,255,255,0.7"
            />
            <use
              xlink:href="#gentle-wave"
              x="48"
              y="3"
              fill="rgba(255,255,255,0.5)"
            />
            <use
              xlink:href="#gentle-wave"
              x="48"
              y="5"
              fill="rgba(255,255,255,0.3)"
            />
            <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
          </g>
        </svg>
      </div>
      <!--Waves end-->
    </div>
    <!--Header ends-->

    <!--Content starts-->
    <div class="content flex">
      <a href="{{route('galleries')}}" target="_top" class="button"
        ><img src="{{asset('images/thumbnail_1.jpg')}}" /><span
          style="text-transform: uppercase"
          >Hình ảnh</span
        ></a
      >
      <a href="{{route('vankien')}}" target="_top" class="button"
        ><img src="{{asset('images/thumbnail_2.jpg')}}" /><span style="text-transform: uppercase"
          >Văn kiện</span
        ></a
      >
      <a href="{{route('delegates.search.form')}}" target="_top" class="button"
        ><img src="{{asset('images/thumbnail_3.jpg')}}" /><span
          style="text-transform: uppercase"
          >Thẻ đại biểu</span
        ></a
      >
      <a href="#" target="_top" class="button"
        ><img src="{{asset('images/thumbnail_4.jpg')}}" /><span
          style="text-transform: uppercase"
          >FANPAGE</span
        ></a
      >
      <a href="#" target="_top" class="button"
        ><img src="{{asset('images/thumbnail_5.jpg')}}" /><span
          style="text-transform: uppercase"
          >ZALO OA</span
        ></a
      >
    </div>
    <!--Content ends-->
    <footer>Khát vọng cống hiến, lẽ sống thanh niên</footer>
  </body>
</html>
