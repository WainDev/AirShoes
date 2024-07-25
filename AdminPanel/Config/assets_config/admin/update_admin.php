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

$user_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM `Admin` WHERE `Id` = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user === false) {
    echo "Администратор не найден.";
    exit;
}

$login = $user['Login'];
$password = $user['Password'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['login']) || empty($_POST['password'])) {
        $errorMessage = "Ошибка: Не все данные были переданы.";
    } else {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("UPDATE `Admin` SET `Login` = :login, `Password` = :password WHERE `Id` = :user_id");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            $successMessage = "Данные успешно обновлены в базе данных.";
            header("Location: /AdminPanel/index.php");
            exit;
        } else {
            $errorMessage = "Ошибка при выполнении запроса: " . $stmt->errorInfo()[2];
        }
    }
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
                <h1>Редактирование администраторов</h1> <a href="/AdminPanel/index.php"><img src="../../../Assets/image/close.svg" alt=""></a>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $user_id; ?>" class="admins_form">
                <input class="admin_input" type="text" name="login" placeholder="Логин" value="<?= $login ?>" />
                <input class="admin_input" type="text" name="password" placeholder="Пароль" value="<?= $password ?>" />
                <button class="admin_button btn btn-success" type="submit">Сохранить</button>
            </form>
        </div>
    </div>
</body>

</html>