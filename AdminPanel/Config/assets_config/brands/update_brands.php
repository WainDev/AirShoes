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

$brands_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM `Brands` WHERE `Id` = :brands_id");
$stmt->bindParam(':brands_id', $brands_id);
$stmt->execute();
$brand = $stmt->fetch(PDO::FETCH_ASSOC);

if ($brand === false) {
    echo "Бренд не найден.";
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Если POST-запрос был выполнен, используем данные из $_POST
    $brandName = $_POST['brandname'];
    $brandUrl = $_POST['brandurl'];

    // Подготавливаем и выполняем запрос на обновление данных в базе
    $stmt = $conn->prepare("UPDATE `Brands` SET `NameBrands` = :brandname, `ImgUrl` = :brandurl WHERE `Id` = :brands_id");
    $stmt->bindParam(':brandname', $brandName);
    $stmt->bindParam(':brandurl', $brandUrl);
    $stmt->bindParam(':brands_id', $brands_id);

    if ($stmt->execute()) {
        $successMessage = "Данные успешно обновлены в базе данных.";
        header("Location: /AdminPanel/index.php");
        exit;
    } else {
        $errorMessage = "Ошибка при выполнении запроса: " . $stmt->errorInfo()[2];
    }
} else {
    // Если POST-запрос не был выполнен, используем данные из базы данных
    $brandName = $brand['NameBrands'];
    $brandUrl = $brand['ImgUrl'];
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
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $brands_id; ?>" class="admins_form">
                <input class="admin_input" type="text" name="brandname" placeholder="Логин" value="<?= $brandName ?>" />
                <input class="admin_input" type="text" name="brandurl" placeholder="Пароль" value="<?= $brandUrl ?>" />
                <button class="admin_button btn btn-success" type="submit">Сохранить</button>
            </form>
        </div>
    </div>
</body>

</html>