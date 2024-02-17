<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tuổi trẻ Bến Cát</title>
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite('resources/css/header.css')
    <style>
      body {
        margin: 0px;
        padding: 0px;
      }
      header {
        display: block !important;
        height: auto;
        padding-bottom: 0px !important;
      }
      .logo {
        margin-bottom: 16px !important;
      }
      input {
        padding-left: 8px;
        height: 40px;
        width: 320px;
        border-radius: 2px;
        border: 0px;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.7px;
        outline: 0px;
      }
      .form {
        display: flex;
        flex-direction: column;
        align-items: center;
      }
      button {
        height: 40px;
        width: 100px;
        margin-top: 8px;
        background-color: white;
        border-radius: 2px;
        border: 0px;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.7px;
        font-weight: 500;
      }
      h1 {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 700;
        letter-spacing: 0.5px;
        font-size: 36px;
        margin-top: 16px;
        text-transform: uppercase;
      }
      .card {
        height: 60vh;
      }
      .cover {
        text-align: center;
        padding-top: 16px;
        padding-bottom: 64px;
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
        font-size: 14px;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        line-height: 18px;
        letter-spacing: 0.7px;
      }
      .cover-error {
        text-align: center;
      }
      @media (max-width: 768px) {
        .logo {
          height: 80px;
          width: 80px;
          border-radius: 2px !important;
        }
      }
    </style>
  </head>
  <body>
    <header>
    <a href="{{route('home')}}"><img src="{{ Vite::asset('resources/images/logo.png') }}" height="128" width="128" class="logo" /></a>
      <form class="form" action="{{ route('delegates.search') }}" method="POST">
      @csrf
        <input type="text" placeholder="Nhập mã" maxlength="15" id="phone" name="phone" required>
        <button type="submit"><i class="bi bi-search"></i> Tìm kiếm</button>
        <h1>Thẻ đại biểu</h1>
      </form>
    </header>
    @isset($delegate)
    <div class="cover">
        <img src="{{ asset('storage/' . $delegate->card) }}" class="card" />
    </div>
    @else
        @if(!isset($status))
        <div class="cover-error"><p class="error">Không tìm thấy số điện thoại trên!</p></div>
        @endif
    @endisset
    <footer>
      Nhập số điện thoại của Đại biểu <br />để lấy mã QR check-in tại Đại hội
    </footer>
  </body>
</html>

