<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,
     initial-scale=1.0" />
  <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
  <link rel="stylesheet" href="./Assets/styles/style.css" />
  <title>АирШоес</title>
</head>

<body>

  <?php
  require_once "header.php";
  session_status();
  require_once "Carousel.php";
  require_once "./brends.php";
  require_once "my.php";
  require_once "Location.php";
  require_once "Footer.php";
  ?>

  <script src="./Scripts/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./Scripts/index.js"></script>
</body>

</html>