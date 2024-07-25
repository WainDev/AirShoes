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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $middlename = $_POST['middlename'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Обновляем данные пользователя в базе данных
    if ($password) {
        $query = $pdo->prepare("UPDATE User SET Name = :name, Surname = :surname, MiddleName = :middlename, EmailAddress = :email, Password = :password WHERE Id = :id");
        $query->execute(['name' => $name, 'surname' => $surname, 'middlename' => $middlename, 'email' => $email, 'password' => $password, 'id' => $user['Id']]);
    } else {
        $query = $pdo->prepare("UPDATE User SET Name = :name, Surname = :surname, MiddleName = :middlename, EmailAddress = :email WHERE Id = :id");
        $query->execute(['name' => $name, 'surname' => $surname, 'middlename' => $middlename, 'email' => $email, 'id' => $user['Id']]);
    }

    // Обновляем данные в сессии
    $_SESSION['user']['Name'] = $name;
    $_SESSION['user']['Surname'] = $surname;
    $_SESSION['user']['MiddleName'] = $middlename;
    $_SESSION['user']['EmailAddress'] = $email;
    if ($password) {
        $_SESSION['user']['Password'] = $password;
    }

    header("Location: profile.php");
    exit();
}
