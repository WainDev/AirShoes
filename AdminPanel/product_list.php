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

$sql = "SELECT `Id`, `NameProducts`, `DescriptionProducts`, `Size`, `Price`, 
`Quantity`, `ImageUrl`, `Sale`, `Color`, `Brands_Id`, `Categories_Id` FROM `Products`";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
  <link rel="stylesheet" href="./Assets/styles/style.css" />
  <title>Список Товаров</title>
</head>

<body>
  <div class="d-flex text-center align-items-start">
    <div class="nav apanel flex-column nav-pills me-3 p-5">
      <h1 class="logo_panel">Админ панель</h1>
      <a href="/index.php" class="nav-link">
        <img src="./Assets/image/iconspanel/person.svg" alt="" />
        Главная
      </a>
      <a href="./admin_list.php" class="nav-link">
        <img src="./Assets/image/iconspanel/person.svg" alt="" />
        Админы
      </a>
      <a href="./product_list.php" class="nav-link active">
        <img src="./Assets/image/iconspanel/tovar.svg" alt="" />
        Товары
      </a>
      <a href="brands_list.php" class="nav-link">
        <img class="" src="./Assets/image/iconspanel/brand.svg" alt="" />
        Бренды
      </a>
      <a href="./categories_list.php" class="nav-link">
        <img src="./Assets/image/iconspanel/categorias.svg" alt="" />
        Категории
      </a>
      <a href="logout.php" class="btn">Выход</a>
    </div>
    <div class="container">
      <div class="admins_list mt-5 shadow-lg p-3 mb-5 bg-body rounded">
        <h1>Список Товаров</h1>
        <form action="./Config/assets_config/products/add_product.php">
          <button class="btn_apanel w-100" type="submit">+ Добавить</button>
        </form>
        <ul class="header_info_table mt-3 d-flex align-items-center justify-content-around">
          <li>Айди</li>
          <li>Название</li>
          <li>Размер</li>
          <li>Цена</li>
          <li>Скидка</li>
          <li>Цвет</li>
          <li>Бренд</li>
          <li>Категория</li>
          <li>Действие</li>
        </ul>
        <?php
        if ($result->rowCount() > 0) {
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $brandQuery = $conn->prepare("SELECT `NameBrands` FROM `Brands` WHERE `Id` = :brand_id");
            $brandQuery->bindParam(':brand_id', $row['Brands_Id']);
            $brandQuery->execute();
            $brand = $brandQuery->fetch(PDO::FETCH_ASSOC);
            $categoryQuery = $conn->prepare("SELECT `NameCategories` FROM `Categories` WHERE `Id` = :category_id");

            $categoryQuery->bindParam(':category_id', $row['Categories_Id']);
            $categoryQuery->execute();
            $category = $categoryQuery->fetch(PDO::FETCH_ASSOC);


            echo "<ul class=' admin_list d-flex align-items-center justify-content-around'>";
            echo "<li>" . $row['Id'] . "</li>";
            echo "<li>" . $row['NameProducts'] . "</li>";
            echo "<li>" . $row['Size'] . "</li>";
            echo "<li>" . $row['Price'] . "</li>";
            echo "<li>" . $row['Quantity'] . "</li>";
            echo "<li>" . $row['Sale'] . "</li>";
            echo "<li>" . $row['Color'] . "</li>";
            echo "<li>" . ($brand ? $brand['NameBrands'] : 'Нет данных') . "</li>"; // Полное название бренда
            echo "<li>" . ($category ? $category['NameCategories'] : 'Нет данных') . "</li>"; // Полное название категории
            echo "<li class='d-block'>";
            echo "<a href='./Config/assets_config/products/update_products.php?id=" . $row['Id'] . "'><img src='./Assets/image/pencil.svg' /></a>";
            echo " <a href='./Config/assets_config/products/delete.php?id=" . $row['Id'] . " '><img src='./Assets/image/close.svg' /></a>";
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