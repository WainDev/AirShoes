<?php
session_start();
include_once "Config/Database.php"; // Подключаем файл с конфигурацией базы данных

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

$user = $_SESSION['user']; // Получаем данные пользователя из сессии

// Создаем экземпляр класса Database и получаем соединение
$database = new Database();
$pdo = $database->getConnection();

// Получаем данные пользователя из базы данных
$query = $pdo->prepare("SELECT Name, Surname, MiddleName, EmailAddress, Password FROM User WHERE Id = :id");
$query->execute(['id' => $user['Id']]);
$userData = $query->fetch(PDO::FETCH_ASSOC);

// Используйте $userData для отображения информации о пользователе в профиле
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
  <link rel="stylesheet" href="./Assets/styles/style.css" />
  <title>Profile</title>
</head>

<body>

  <div class="container">
    <?php require_once "header.php"; ?>
    <div class="d-flex align-items-start">
      <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
          Профиль
        </button>
        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
          Мои заказы
        </button>
      </div>
      <div class="tab-content" id="v-pills-tabContent">
        <div class="testDead tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
          <p>Обо мне</p>
          <form method="post" action="update_profile.php">
            <div class="input__profil d-flex align-items-center justify-content-between mb-3">
              <p>Имя</p>
              <input type="text" name="name" class="input__profil__style p-2" placeholder="Натиг-Намиг-Оглы" value="<?= htmlspecialchars($userData['Name'] ?? '') ?>" />
            </div>
            <div class="input__profil d-flex align-items-center justify-content-between mb-3">
              <p>Фамилия</p>
              <input type="text" name="surname" class="input__profil__style p-2" placeholder="Иванов" value="<?= htmlspecialchars($userData['Surname'] ?? '') ?>" />
            </div>
            <div class="input__profil d-flex align-items-center justify-content-between mb-3">
              <p>Отчество</p>
              <input type="text" name="middlename" class="input__profil__style p-2" placeholder="Дмитреевич" value="<?= htmlspecialchars($userData['MiddleName'] ?? '') ?>" />
            </div>
            <div class="input__profil d-flex align-items-center justify-content-between mb-3">
              <p>Email</p>
              <input type="email" name="email" class="input__profil__style p-2" placeholder="ivanov@yandex.ru" value="<?= htmlspecialchars($userData['EmailAddress'] ?? '') ?>" />
            </div>
            <div class="input__profil d-flex align-items-center justify-content-between mb-3">
              <p>Пароль</p>
              <input type="password" name="password" class="input__profil__style p-2" placeholder="12343" />
            </div>
            <button type="submit" class="w-100 p-2 mt-3 button__profil">Сохранить</button>
          </form>
        </div>
        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          заказы
        </div>
      </div>
    </div>
    <h3 class="mt-3">Как офрмить заказ:</h3>
    <div class="container__cards d-flex flex-wrap justify-content-around">
      <div class="profil_card text-center">
        <img src="./Assets/image/icon1.svg" alt="" />
        <p>Войти в личный кабинет</p>
      </div>
      <div class="profil_card text-center">
        <img src="./Assets/image/icon2.svg" alt="" />
        <p>
          Добавить понравивщийся <br />
          товар в корзину
        </p>
      </div>
      <div class="profil_card text-center">
        <img src="./Assets/image/icon3.svg" alt="" />
        <p>Выбрать способ доставкиc</p>
      </div>
      <div class="profil_card text-center">
        <img src="./Assets/image/icon4.svg" alt="" />
        <p>
          Оплатите заказ и <br />
          проверьте оплату
        </p>
      </div>
      <div class="profil_card text-center">
        <img src="./Assets/image/icon5.svg" alt="" />
        <p>
          Дождитесь уведомлений о <br />
          готовкности заказа
        </p>
      </div>
    </div>
  </div>
  <script src="./Scripts/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./Scripts/index.js"></script>
</body>

</html>