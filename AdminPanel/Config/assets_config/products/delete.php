<?php
session_start();
include_once "../../Database.php";

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

if (!isset($_GET['id'])) {
  echo "Ошибка: Идентификатор бренда не указан.";
  exit;
}

$products_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM `Products` WHERE `Id` = :products_id");
$stmt->bindParam(':products_id', $products_id);

if ($stmt->execute()) {
  header("Location: /AdminPanel/index.php");
  exit;
} else {
  echo "Ошибка при выполнении запроса на удаление администратора.";
  exit;
}
