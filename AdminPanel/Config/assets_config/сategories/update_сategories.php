<?php

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
    echo "Ошибка: Идентификатор администратора не указан.";
    exit;
}

$categories_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM `Categories` WHERE `Id` = :categories_id");
$stmt->bindParam(':categories_id', $categories_id);
$stmt->execute();
$categories = $stmt->fetch(PDO::FETCH_ASSOC);

if ($categories === false) {
    echo "Бренд не найден.";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Если POST-запрос был выполнен, используем данные из $_POST
    $categoriesName = $_POST['categoriesname'];

    // Подготавливаем и выполняем запрос на обновление данных в базе
    $stmt = $conn->prepare("UPDATE `Categories` SET `NameCategories` = :categoriesname WHERE `Id` = :categories_id");
    $stmt->bindParam(':categoriesname', $categoriesName);
    $stmt->bindParam(':categories_id', $categories_id);

    if ($stmt->execute()) {
        $successMessage = "Данные успешно обновлены в базе данных.";
        header("Location: /AdminPanel/index.php");
        exit;
    } else {
        $errorMessage = "Ошибка при выполнении запроса: " . $stmt->errorInfo()[2];
    }
} else {
    // Если POST-запрос не был выполнен, используем данные из базы данных
    $categoriesName = $categories['NameCategories'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/AdminPanel/assets/styles/bootstrap.min.css">
    <link rel="stylesheet" href="/AdminPanel/assets/styles/style.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <div class="admins_list mt-5 shadow-lg p-3 mb-5 bg-body rounded">
            <div class="header_form d-flex align-items-center justify-content-between p-2">
                <h1>Редактирование брендов</h1> <a href="/AdminPanel/index.php"><img src="../../../Assets/image/close.svg" alt=""></a>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $categories_id; ?>" class="admins_form">
                <input class="admin_input" type="text" name="categoriesname" placeholder="Логин" value="<?= $categoriesName ?>" />
                <button class="admin_button btn btn-success" type="submit">Сохранить</button>
            </form>
        </div>
    </div>
</body>

</html>