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

$sql = "SELECT Id, login, password FROM Admin";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
    <link rel="stylesheet" href="./Assets/styles/style.css" />
    <title>Список администратор</title>
  </head>
  <body>
  <div class="d-flex text-center align-items-start">
      <div
        class="nav apanel flex-column nav-pills me-3 p-5"
      >
        <h1 class="logo_panel">Админ панель</h1>
        <a
          href="/index.php"
          class="nav-link"
        >
          <img src="./Assets/image/iconspanel/person.svg" alt="" />
          Главная
        </a>
        <a
          href="./admin_list.php"
          class="nav-link active"
        >
          <img src="./Assets/image/iconspanel/person.svg" alt="" />
          Админы
        </a>
        <a
          href="./product_list.php"
          class="nav-link "
        >
          <img src="./Assets/image/iconspanel/tovar.svg" alt="" />
          Товары
        </a>
        <a
          href="brands_list.php"
          class="nav-link"
        >
          <img class="" src="./Assets/image/iconspanel/brand.svg" alt="" />
          Бренды
        </a>
        <a
          href="./categories_list.php"
          class="nav-link"
        >
          <img src="./Assets/image/iconspanel/categorias.svg" alt="" />
          Категории
        </a>
        <a href="logout.php" class="btn">Выход</a>
      </div>
    <div class="container">
      <div class="admins_list mt-5 shadow-lg p-3 mb-5 bg-body rounded">
        <h1>Список администраторов</h1>
        <form action="./Config/assets_config/admin/add_admin.php">
          <button class="btn_apanel w-100" type="submit">+ Добавить</button>
        </form>
        <ul class="header_info_table mt-3 d-flex align-items-center justify-content-around">
          <li>Айди</li>
          <li>Логин</li>
          <li>Пароль</li>
          <li>Действия</li>
        </ul>
        <?php
          if ($result->rowCount() > 0) {
            while ($row = $result -> fetch(PDO::FETCH_ASSOC)) {
              echo "<ul class='admin_list d-flex align-items-center justify-content-around'>";
              echo "<li>" . $row['Id'] . "</li>";
              echo "<li>" . $row['login'] . "</li>";
              echo "<li>" . $row['password'] . "</li>";
              echo "<li class='d-block'>";
              echo "<a href='./Config/assets_config/admin/update_admin.php?id=" . $row['Id'] . "'><img src='./Assets/image/pencil.svg' /></a>";
              echo " <a href='./Config/assets_config/admin/delete.php?id=" . $row['Id'] . " '><img src='./Assets/image/close.svg' /></a>";
              echo "</li>";
              echo "</ul>";
            } 
          } else {
            echo "0 результатов";
          }

        ?>

      </div>
    </div>
    <!-- модалька добавления -->
   
    </div>
    <script src="./Scripts/bootstrap.min.js"></script>
  </body>
</html>
