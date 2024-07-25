<?php
include_once "../../Database.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!class_exists('Database')) {
        $errorMessage = "Ошибка: Класс Database не найден.";
    } else {
        $db = new Database();

        if (!$db->getConnection()) {
            $errorMessage = "Ошибка подключения к базе данных.";
        } else {
            $conn = $db->getConnection();


            if (!empty($_POST['categoriesname']) && !empty($_POST['priority'])) {

                $stmt = $conn->prepare("INSERT INTO `Categories` (`Id`, `NameCategories`, `Priority`) VALUES (NULL, :categoriesname, :priority)");


                $stmt->bindParam(':categoriesname', $_POST['categoriesname']);
                $stmt->bindParam(':priority', $_POST['priority']);


                if ($stmt->execute()) {
                    $successMessage = "Данные успешно добавлены в базу данных.";

                    header("Location: /AdminPanel/index.php");
                    exit;
                } else {
                    $errorMessage = "Ошибка при выполнении запроса: " . $stmt->errorInfo()[2];
                }
            } else {
                $errorMessage = "Ошибка: Не все данные были переданы.";
            }
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
    <title>Добавление категории</title>
</head>

<body>
    <div class="container">
        <div class="admins_list mt-5 shadow-lg p-3 mb-5 bg-body rounded">
            <div class="header_form d-flex align-items-center justify-content-between p-2">
                <h1>Добавление категории</h1> <a href="/AdminPanel/index.php"><img src="../../../Assets/image/close.svg" alt=""></a>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="admins_form">
                <input class="admin_input" type="text" name="categoriesname" placeholder="Имя категории" />
                <input class="admin_input" type="text" name="priority" placeholder="Приоритет" />
                <button class="admin_button btn btn-success" type="submit">Добавить</button>
            </form>
        </div>
    </div>
</body>

</html>