<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    </style>
</head>
<body>
    <img id="image" />
    <?php
      $storage = json_encode(asset('storage/'));
    ?>
    <script src="https://cdn.socket.io/4.7.4/socket.io.min.js"></script>
    <script>
      const socket = io.connect("http://127.0.0.1:3000");

      socket.on("info", (data) => {
        // Assuming `data` is an array of objects with the structure you provided

        console.log(data);
        let storageUrl = <?php echo $storage ?>;
        document.getElementById("image").src = storageUrl + "/" + data.delegate.image;     
        document.getElementById("image").style.height = "100%";   
        document.getElementById("image").style.width = "auto";   
      });
    </script>
</body>
</html>
