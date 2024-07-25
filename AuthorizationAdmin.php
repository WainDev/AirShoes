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

if (isset($_POST['login']) && isset($_POST['password'])) {
  $login = $_POST['login'];
  $password = $_POST['password'];

  $sql = "SELECT id FROM Admin WHERE Login = ? AND Password = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute([$login, $password]); // Передача параметров в метод execute

  if ($stmt->fetch()) {
    $userId = $stmt->fetchColumn(0); // Получение ID пользователя из первого столбца
    $_SESSION['user_id'] = $userId;
    header('Location: admins.php'); // Перенаправление на страницу администрирования
    exit;
  } else {
    // Авторизация не удалась
    $errorMessage = "Неверный логин или пароль";
  }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
  <link rel="stylesheet" href="./Assets/styles/style.css" />
  <title>Авторизация</title>
</head>

<body>
  <div class="container w-25">
    <?php if (isset($errorMessage)) : ?>
      <div class="alert alert-danger">
        <?php echo $errorMessage; ?>
      </div>
    <?php endif; ?>
    <div class="title__auth d-flex justify-content-between align-items-center   ">
      <h1 class="mt-5 text-center">Авторизация</h1>
      <button class="reg__button">
        <img src="./Assets/image/CloseRed.svg" alt="крестик">
      </button>
    </div>
    <form class=" mt-5" method="post">
      <div class="form-group">
        <input type="text" placeholder="Логин" name="login" class="icon__reg form-control" id="exampleInputLogin1" required="required">
      </div>
      <div class="form-group">
        <input type="password" placeholder="Пароль" name="password" class="icon__reg__bottom icon__reg form-control" id="exampleInputPassword1" required="required">
      </div>
      <button type="submit" class="btn mt-3 w-100 btn-primary">Войти</button>
    </form>
  </div>
</body>

</html>