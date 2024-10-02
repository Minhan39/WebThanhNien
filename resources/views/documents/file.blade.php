<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js"></script>

  <link rel="stylesheet" type="text/css" href="css/flipbook.style.css" />

  @vite(['resources/css/font-awesome.css','resources/css/header.css'])
  <!-- Icon -->
  <link
    rel="stylesheet"
    href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
    integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
    crossorigin="anonymous" />

  <!-- Bootstrap Css -->
  <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

  <script src="js/flipbook.min.js"></script>

  <?php
  $data = json_encode($documents);
  $storage = json_encode(asset('storage/'));
  ?>

  <script type="text/javascript">
    $(document).ready(function() {
      let dt = <?php echo $data ?>;
      let storageUrl = <?php echo $storage ?>;
      dt.forEach(function(item) {
        var pdfLink = storageUrl + "/" + item.pdf;
        // $(".book-" + item.id).on('click', function(){
        //   console.log(pdfLink);
        // });
        $(".book-" + item.id).flipBook({
          btnShare: {
            enabled: false
          },
          btnPrint: {
            hideOnMobile: true,
          },
          btnDownloadPages: {
            enabled: true,
            title: "Download pages",
            icon: "fa-download",
            icon2: "file_download",
            url: "images/pdf.rar",
            name: "allPages.zip",
            hideOnMobile: false,
          },
          pdfUrl: pdfLink,
          btnColor: "rgb(255,120,60)",
          sideBtnRadius: 60,
          sideBtnSize: 60,
          sideBtnBackground: "rgba(0,0,0,.7)",
          sideBtnColor: "rgb(255,120,60)",
          lightBox: true,
          viewMode: "3d",
          layout: 3,
          btnSound: {
            vAlign: "top",
            hAlign: "left"
          },
          btnAutoplay: {
            vAlign: "top",
            hAlign: "left"
          },
          currentPage: {
            vAlign: "bottom",
            hAlign: "left"
          },
        });
      });
    });
  </script>

  <style type="text/css">
    body {
      background-color: #f6f6f6;
    }

    h1 {
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      font-weight: 700;
      letter-spacing: 0.5px;
      line-height: 40px;
      font-size: 36px;
      margin: 0;
      text-transform: uppercase;
    }

    .bookshelf .thumb {
      display: inline-block;
      cursor: pointer;
      margin: 0px 0.5%;
      width: 15% !important;
      box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.3);
      max-width: 100px;
    }

    .bookshelf .thumb img {
      width: 100%;
      display: block;
      vertical-align: top;
    }

    .bookshelf .shelf-img {
      z-index: 0;
      height: auto;
      max-width: 100%;
      vertical-align: top;
      margin-top: -12px;
    }

    .bookshelf .covers {
      width: 100%;
      height: auto;
      z-index: 99;
      position: relative;
      text-align: center;
    }

    .bookshelf {
      text-align: center;
      padding: 0px;
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
      align-items: center;
      padding: 0px !important;
      margin: 0px;
    }
  </style>
  <link rel="icon" type="image/x-icon" href="{{ Vite::asset('resources/images/logo.png') }}" />
  <title>Tuổi trẻ Bến Cát</title>
</head>

<body>
  <header>
    <a href="{{route('home')}}"><img src="{{ Vite::asset('resources/images/logo.png') }}" height="128" width="128" class="logo" /></a>
    <h1>Văn kiện, nghị quyết</h1>
  </header>
  <div class="shelf">
    <div class="bookshelf">
      <div class="covers">
        <div style="display: none">{{$cnt = 0}}</div>
        @forelse($documents as $document)
        <div style="display: none">{{$class = "book-" . $document->id}}{{$cnt++}}</div>
        @if($cnt > 5 && $cnt % 5 == 1)
      </div>
      <img class="shelf-img" src="{{ Vite::asset('resources/images/shelf_wood.png') }}" />
    </div>
    <div class="bookshelf">
      <div class="covers">
        @endif
        <div class="thumb {{$class}}"><img src="{{ asset('storage/' . $document->image) }}" /></div>
        @empty
        <!-- <p>No documents available.</p> -->
         <p></p>
        @endforelse
      </div>
      <img class="shelf-img" src="{{ Vite::asset('resources/images/shelf_wood.png') }}" />
    </div>
    <footer>Khát vọng cống hiến, lẽ sống thanh niên</footer>
  </div>
  <!-- <div class="shelf">
      <div class="bookshelf">
        <div class="covers">
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
        </div>
        <img class="shelf-img" src="{{ Vite::asset('resources/images/shelf_wood.png') }}" />
      </div>
      <div class="bookshelf">
        <div class="covers">
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
          <div class="thumb book-1"><img src="{{ Vite::asset('resources/images/book2/1.jpg') }}" /></div>
        </div>
        <img class="shelf-img" src="{{ Vite::asset('resources/images/shelf_wood.png') }}" />
      </div>
      <div class="bookshelf">
        <div class="covers">
          <div class="thumb book-1"><img src="images/book2/1.jpg" /></div>
          <div class="thumb book-1"><img src="images/book2/1.jpg" /></div>
          <div class="thumb book-1"><img src="images/book2/1.jpg" /></div>
          <div class="thumb book-1"><img src="images/book2/1.jpg" /></div>
          <div class="thumb book-1"><img src="images/book2/1.jpg" /></div>
        </div>
        <img class="shelf-img" src="images/shelf_wood.png" />
      </div>
    </div> -->

  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
</body>

</html>