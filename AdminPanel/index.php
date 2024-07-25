<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
    <link rel="stylesheet" href="./Assets/styles/style.css" />
    <title>Document</title>
  </head>
  <body>
      <div class="d-flex text-center align-items-start">
      <div
        class="nav apanel flex-column nav-pills me-3 p-5"
        id="v-pills-tab"
        role="tablist"
        aria-orientation="vertical"
      >
        <h1 class="logo_panel">Админ панель</h1>
        <a
          href="#"
          class="nav-link active"
          id="v-pills-home-tab"
          data-bs-toggle="pill"
          data-bs-target="#v-pills-home"
          type="button"
          role="tab"
          aria-controls="v-pills-home"
          aria-selected="true"
        >
          <img src="./Assets/image/iconspanel/person.svg" alt="" />
          Главная
        </a>
        <a
          href="./admin_list.php"
          class="nav-link"
          id="v-pills-home-tab"
          data-bs-toggle="pill"
          data-bs-target="#v-pills-admins"
          type="button"
          role="tab"
          aria-controls="v-pills-admins"
          aria-selected="false"
        >
          <img src="./Assets/image/iconspanel/person.svg" alt="" />
          Админы
        </a>
        <a
          href="./product_list.php"
          class="nav-link"
          id="v-pills-profile-tab"
          data-bs-toggle="pill"
          data-bs-target="#v-pills-profile"
          type="button"
          role="tab"
          aria-controls="v-pills-profile"
          aria-selected="false"
        >
          <img src="./Assets/image/iconspanel/tovar.svg" alt="" />
          Товары
        </a>
        <a
          href="./brands_list.php"
          class="nav-link"
          id="v-pills-profile-tab"
          data-bs-toggle="pill"
          data-bs-target="#v-pills-brands"
          type="button"
          role="tab"
          aria-controls="v-pills-brands"
          aria-selected="false"
        >
          <img class="" src="./Assets/image/iconspanel/brand.svg" alt="" />
          Бренды
        </a>
        <a
          href="./categories_list.php"
          class="nav-link"
          id="v-pills-profile-tab"
          data-bs-toggle="pill"
          data-bs-target="#v-pills-categorii"
          type="button"
          role="tab"
          aria-controls="v-pills-categorii"
          aria-selected="false"
        >
          <img src="./Assets/image/iconspanel/categorias.svg" alt="" />
          Категории
        </a>
        <a href="logout.php" class="btn">Выход</a>
      </div>
      <div class="container">    
      <!-- Content -->
      <div class="tab-content w-100" id="v-pills-tabContent">
        <!-- карточки на главной -->
        <div
          class="testDead tab-pane fade show active"
          id="v-pills-home"
          role="tabpanel"
          aria-labelledby="v-pills-home-tab"
        >
          <div class="container__admin">

          <?php

            session_start();
            include_once "Config/Database.php";

            if (!class_exists('Database')) {
              echo "Ошибка: Класс Database не найден.";
              exit;
            }

            $db = new Database();

            if (!$db->getConnection()) {
              echo "Ошибка подключения к базе данных.";
              exit;
            }

            $conn = $db->getConnection();

            // Выполнение SQL-запроса для подсчета количества администраторов в таблице Admin
            $sql = "SELECT COUNT(*) AS total_users FROM Admin";
            $stmt = $conn->query($sql);

            if ($stmt) {
              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              $totalUsers = $row['total_users'];
            } else {
              // Обработка ошибки, если запрос не удался
              echo "Ошибка выполнения запроса.";
            }

          ?>
            <div class="admin__cards">
              <div class="admin__cards__container d-flex">
                <div class="admin__cards__top">
                  <img
                    class="admin__cards__img"
                    src="./Assets/image/iconadmin1.svg"
                    alt="icon"
                  />
                </div>
                <div class="admin__cards__midle">
                  <h3 class="title__admin__cards">Администраторов</h3>
                  <p class="quantity__admin__cards w-25"><?php echo $totalUsers; ?></p> 
                </div>
              </div>
              <div class="admin__cards__bottom d-flex">
                <img
                  class="admin__cards__strel"
                  src="./Assets/image/strel.svg"
                  alt="strel"
                />
                <p class="text__admin__cards">На текущий момент</p>
              </div>
            </div>
            <div class="admin__cards">
              <div class="admin__cards__container d-flex">
                <div class="admin__cards__top">
                  <img
                    class="admin__cards__img"
                    src="./Assets/image/iconadmin2.svg"
                    alt="icon"
                  />
                </div>
                <div class="admin__cards__midle">
                  <h3 class="title__admin__cards">Оставшиеся товары</h3>
                  <p class="quantity__admin__cards w-25">156</p>
                </div>
              </div>
              <div class="admin__cards__bottom d-flex">
                <img
                  class="admin__cards__strel"
                  src="./Assets/image/strel.svg"
                  alt="strel"
                />
                <p class="text__admin__cards">На текущий момент</p>
              </div>
            </div>
            <div class="admin__cards">
              <div class="admin__cards__container d-flex">
                <div class="admin__cards__top">
                  <img
                    class="admin__cards__img"
                    src="./Assets/image/iconadmin3.svg"
                    alt="icon"
                  />
                </div>
                <div class="admin__cards__midle">
                  <h3 class="title__admin__cards">Активные промокоды</h3>
                  <p class="quantity__admin__cards w-25">5</p>
                </div>
              </div>
              <div class="admin__cards__bottom d-flex">
                <img
                  class="admin__cards__strel"
                  src="./Assets/image/strel.svg"
                  alt="strel"
                />
                <p class="text__admin__cards">На текущий момент</p>
              </div>
            </div>
            <div class="admin__cards">
              <div class="admin__cards__container d-flex">
                <div class="admin__cards__top">
                  <img
                    class="admin__cards__img"
                    src="./Assets/image/iconadmin4.svg"
                    alt="icon"
                  />
                </div>
                <div class="admin__cards__midle">
                  <h3 class="title__admin__cards">Успешные платежи</h3>
                  <p class="quantity__admin__cards w-25">15</p>
                </div>
              </div>
              <div class="admin__cards__bottom d-flex">
                <img
                  class="admin__cards__strel"
                  src="./Assets/image/strel.svg"
                  alt="strel"
                />
                <p class="text__admin__cards">За 24 часа</p>
              </div>
            </div>
            <div class="admin__cards">
              <div class="admin__cards__container d-flex">
                <div class="admin__cards__top">
                  <img
                    class="admin__cards__img"
                    src="./Assets/image/iconadmin5.svg"
                    alt="icon"
                  />
                </div>
                <div class="admin__cards__midle">
                  <h3 class="title__admin__cards">Неоплаченые платежи</h3>
                  <p class="quantity__admin__cards w-25">4</p>
                </div>
              </div>
              <div class="admin__cards__bottom d-flex">
                <img
                  class="admin__cards__strel"
                  src="./Assets/image/strel.svg"
                  alt="strel"
                />
                <p class="text__admin__cards">За 24 часа</p>
              </div>
            </div>
            <div class="admin__cards">
              <div class="admin__cards__container d-flex">
                <div class="admin__cards__top">
                  <img
                    class="admin__cards__img"
                    src="./Assets/image/iconadmin6.svg"
                    alt="icon"
                  />
                </div>
                <div class="admin__cards__midle">
                  <h3 class="title__admin__cards">Всего платежей</h3>
                  <p class="quantity__admin__cards w-25">33</p>
                </div>
              </div>
              <div class="admin__cards__bottom d-flex">
                <img
                  class="admin__cards__strel"
                  src="./Assets/image/strel.svg"
                  alt="strel"
                />
                <p class="text__admin__cards">За 24 часа</p>
              </div>
            </div>
          </div>
          </div>
          </div>
  </body>
</html>
