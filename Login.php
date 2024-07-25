<?php
session_start();
include_once "Config/Database.php";

$error = "";

// Создаем экземпляр класса Database и получаем соединение
$database = new Database();
$pdo = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = $pdo->prepare("SELECT * FROM User WHERE Login = :login");
    $query->execute(['login' => $login]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user'] = $user;  // Сохраняем всю информацию о пользователе в сессии
        header("Location: profile.php");
        exit();
    } else {
        $error = "Неверный логин или пароль.";
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
        <div class="title__auth d-flex justify-content-between align-items-center   ">
            <h1 class="mt-5 text-center">Авторизация</h1>
            <a href="index.php" class="reg__button">
                <img src="./Assets/image/CloseRed.svg" alt="крестик">
            </a>
        </div>
        <form method="POST" class="mt-5">
            <div class="form-group">
                <input type="text" name="login" placeholder="Логин" class="icon__reg form-control" id="exampleInputLogin1" required="required">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Пароль" class="icon__reg__bottom icon__reg form-control" id="exampleInputPassword1" required="required">
            </div>
            <button type="submit" class="btn mt-3 w-100 btn-primary">Войти</button>
            <a href="register.php" type="button" class="reg btn mt-1 w-100 btn-link">Зарегистрироваться!</a>
        </form>

        <!-- Вывод сообщения об ошибке, если оно есть -->
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
</body>

</html>