<?php
// Начинаем сессию
session_start();

// Проверяем, установлена ли сессия пользователя
$isLoggedIn = isset($_SESSION['user']);

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
  <link rel="stylesheet" href="./Assets/styles/style.css" />

</head>

<body>

  <div class="wrapper">
    <div class="favorit p-2">
      <div class="favorit_header d-flex align-items-center justify-content-between">
        <h4>Избранное</h4>
        <button id="favorit_closes" class="favorrit_button favorit_close">
          <img src="./Assets/image/Close.svg" alt="" />
        </button>
      </div>
      <div class="favorit_main p-2">

      </div>
    </div>
  </div>
  <div class="container">

    <nav class="navbar navbar-expand-lg p-2 mt-5 bg-light rounded d-none d-lg-block">
      <div class="d-flex align-items-center justify-content-between flex-grow-1">
        <a class="navbar-brand" href="#">Москва</a>
        <div class="links">

          <a href="./Card.php" class="link link-dark text-decoration-none"> Каталог </a>

        </div>
        8-800-77-07-999
      </div>
    </nav>
    <nav class="navbar navbar-expand-lg p-2 mb-5 bg-light rounded fixed">
      <div class="d-flex align-items-center justify-content-between flex-grow-1">
        <a class="navbar-brand" href="/index.php">
          <img src="./Assets/image/logo.svg" alt="" />
        </a>
        <form class="d-none d-lg-block">
          <input type="search" id="searchInput" placeholder="Search" class="form-control p-2 me-2 mb-2 mt-2" aria-label="Search" />
        </form>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <div class="me-auto my-lg-2" style="max-height: 100px; overflow-y: auto"></div>
        <div class="links d-lg-none">
          <a href="./Card.php" class="link link-dark text-decoration-none"> Каталог </a>
        </div>
        <form class="d-lg-none">
          <input type="search" placeholder="Search" aria-label="Search" class="form-control p-2 me-2 mb-2 mt-2" />
        </form>
        <div class="text-center">
          <a href="#" id="favorit_open" class="favorit_open btn me-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="41" height="38" viewBox="0 0 41 38" fill="white">
              <path d="M30.3936 1C23.965 1 20.7963 7.54543 20.7963 7.54543C20.7963 7.54543 17.6275 1 11.1989 1C5.97441 1 1.8372 5.5143 1.78373 10.901C1.6748 22.0824 10.3721 30.0341 19.9051 36.7166C20.1679 36.9012 20.4784 37 20.7963 37C21.1141 37 21.4247 36.9012 21.6875 36.7166C31.2195 30.0341 39.9168 22.0824 39.8088 10.901C39.7553 5.5143 35.6181 1 30.3936 1Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </a>
          <a href="pay.php" class="btn me-2 btn-">
            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="45" viewBox="0 0 42 45" fill="white">
              <path d="M11.614 18.875V20.5C11.614 23.0859 12.642 25.5658 14.4718 27.3943C16.3015 29.2228 18.7833 30.25 21.371 30.25C23.9587 30.25 26.4404 29.2228 28.2702 27.3943C30.1 25.5658 31.1279 23.0859 31.1279 20.5V18.875 M11.614 14V10.75C11.614 8.16414 12.642 5.68419 14.4718 3.85571C16.3015 2.02723 18.7833 1 21.371 1C23.9587 1 26.4404 2.02723 28.2702 3.85571C30.1 5.68419 31.1279 8.16414 31.1279 10.75V14M3.48322 14C3.05193 14 2.63831 14.1712 2.33335 14.476C2.02838 14.7807 1.85706 15.194 1.85706 15.625V37.5625C1.85706 40.6337 4.47517 43.25 7.54861 43.25H35.1933C38.2668 43.25 40.8849 40.7607 40.8849 37.6895V15.625C40.8849 15.194 40.7136 14.7807 40.4086 14.476C40.1036 14.1712 39.69 14 39.2587 14H3.48322Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </a>

          <a href="profile.php" class=" btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="42" height="44" viewBox="0 0 42 44" fill="white">
              <path d="M30.0525 10.6343C29.6588 15.9402 25.6336 20.2687 21.2147 20.2687C16.7958 20.2687 12.7636 15.9412 12.377 10.6343C11.9752 5.11466 15.892 1 21.2147 1C26.5375 1 30.4542 5.21502 30.0525 10.6343Z M21.2148 26.6914C12.4774 26.6914 3.60954 31.5086 1.96853 40.601C1.77068 41.6969 2.39133 42.7486 3.53924 42.7486H38.8903C40.0392 42.7486 40.6599 41.6969 40.462 40.601C38.82 31.5086 29.9521 26.6914 21.2148 26.6914Z" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </a>
          <?php if ($isLoggedIn) : ?>
            <a href="logout.php" class="btn">Выход</a>
          <?php endif; ?>
        </div>
      </div>
    </nav>
    <div id="searchResults" class=""></div>
  </div>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./Scripts/index.js"></script>
</body>

</html>