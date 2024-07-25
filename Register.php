<?php
session_start();
include_once "Config/Database.php";

$database = new Database();
$pdo = $database->getConnection();

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $phoneNumber = $_POST['number'];
    $login = $_POST['login'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'false';

    // Проверьте, есть ли уже такой пользователь
    $query = $pdo->prepare("SELECT * FROM User WHERE EmailAddress = :email OR Login = :login");
    $query->execute(['email' => $email, 'login' => $login]);
    if ($query->rowCount() > 0) {
        $error = "Пользователь с таким email или логином уже существует.";
    } else {
        // Вставьте нового пользователя в базу данных
        $query = $pdo->prepare("INSERT INTO User (EmailAddress, PhoneNumber, Login, Password, Role) VALUES (:email, :phoneNumber, :login, :password, :role)");
        if ($query->execute(['email' => $email, 'phoneNumber' => $phoneNumber, 'login' => $login, 'password' => $password, 'role' => $role])) {
            $userId = $pdo->lastInsertId();
            // Получаем полную информацию о пользователе
            $query = $pdo->prepare("SELECT * FROM User WHERE Id = :id");
            $query->execute(['id' => $userId]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            // Сохраняем полную информацию о пользователе в сессии
            $_SESSION['user'] = $user;

            header("Location: profile.php");
            exit();
        } else {
            $error = "Ошибка при регистрации.";
        }
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
    <title>Регистрация</title>
</head>

<body>

    <div class="container w-25">
        <div class="title__auth d-flex justify-content-between align-items-center   ">
            <h1 class="mt-5 text-center">Регистрация</h1>
            <a href="index.php" class="reg__button">
                <img src="./Assets/image/CloseRed.svg" alt="крестик">
            </a>
        </div>
        <?php if ($error) : ?>
            <p style="color:red;"><?= $error ?></p>
        <?php endif; ?>
        <form method="post" class=" mt-5">
            <div class="form-group">
                <input type="email" name="email" placeholder="Почта" class="icon__reg icon__reg__email form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required="required">
            </div>
            <div class="form-group">
                <input type="tel" name="number" placeholder="Номер телефона" class="icon__reg icon__reg__phone form-control" id="exampleInputNumber1" pattern="^\+7\d{10}$" required="required">
            </div>
            <div class="form-group">
                <input type="text" name="login" placeholder="Логин" class="icon__reg form-control" id="exampleInputLogin1" required="required">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Пароль" class="icon__reg__bottom icon__reg form-control" id="exampleInputPassword1" required="required">
            </div>
            <button type="submit" class="btn mt-3 w-100 btn-primary">Регистрация</button>
            <a href="login.php" type="button" class="reg btn mt-1 w-100 btn-link">У меня уже есть аккаунт!</a>
        </form>
    </div>
</body>

</html>