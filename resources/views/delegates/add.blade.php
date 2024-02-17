<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
    <title>Tuổi trẻ Bến Cát</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
      body{
        margin: 0px;
        padding: auto;
      }
      form{
        background-image: linear-gradient(
          rgba(17, 74, 160, 1),
          rgba(17, 74, 160, 1),
          #1434a4
        );
        height: 100vh;
        display: flex;
        align-items: center !important;
        justify-content: center !important;
        flex-direction: column !important;
      }
      .logo{
        border-radius: 8px;
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
      button{
        height: 40px;
        width: 100px;
        margin-top: 8px;
        background-color: white;
        border-radius: 2px;
        border: 0px;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.7px;
        font-weight: 500;
        margin-left: 8px;
      }
      h1 {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        font-weight: 700;
        letter-spacing: 0.5px;
        line-height: 40px;
        font-size: 36px;
        margin-bottom: 16px;
        text-transform: uppercase;
        color: white;
      }
    </style>
</head>
<body>
    <form id="form" action="">
      <a href="{{route('home')}}"><img src="{{ Vite::asset('resources/images/logo.png') }}" height="128" width="128" class="logo" /></a>
      <h1>Quét mã</h1>
      <div><input id="input" autocomplete="off" placeholder="Nhập số điện thoại"/><button style="submit"><i class="bi bi-search"></i> Xác nhận</button></div>
    </form>

    <script src="https://cdn.socket.io/4.7.4/socket.io.min.js"></script>
    <script>
      const socket = io.connect("http://127.0.0.1:3000");

      const form = document.getElementById("form");
      const input = document.getElementById("input");

      form.addEventListener("submit", (e) => {
        e.preventDefault();
        if (input.value) {
          socket.emit("chat message", input.value);
          input.value = "";
        }
      });
    </script>
</body>
</html>