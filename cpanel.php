<?php
session_start();
include_once "Config/Database.php";

// Проверяем, аутентифицирован ли пользователь
if (!isset($_SESSION['user'])) {
    header("Location: /error.html"); // Укажите правильный путь к странице 502
    exit();
}

$user = $_SESSION['user']; // Получаем данные пользователя из сессии

// Проверяем роль пользователя
if ($user['Role'] == 'True') {
    header("Location: /AdminPanel/index.php");
    exit();
} else {
    header("Location: /error.html"); // Укажите правильный путь к странице 502
    exit();
}
