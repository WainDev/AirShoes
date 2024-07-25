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

$products_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM `Products` WHERE `Id` = :products_id");
$stmt->bindParam(':products_id', $products_id);
$stmt->execute();
$products = $stmt->fetch(PDO::FETCH_ASSOC);

if ($products === false) {
    echo "Бренд не найден.";
    exit;
}

// Определение переменных перед открытием тега <form>
$descritpionproduct = isset($products['DescriptionProducts']) ? $products['DescriptionProducts'] : '';
$sizeproduct = isset($products['Size']) ? $products['Size'] : '';
$priceproduct = isset($products['Price']) ? $products['Price'] : '';
$quantityproduct = isset($products['Quantity']) ? $products['Quantity'] : '';
$imgproduct = isset($products['ImageUrl']) ? $products['ImageUrl'] : '';
$saleproduct = isset($products['Sale']) ? $products['Sale'] : '';
$color = isset($products['Color']) ? $products['Color'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Если POST-запрос был выполнен, используем данные из $_POST
    $productname = $_POST['productname'];
    $descritpionproduct = $_POST['descritpionproduct'];
    $sizeproduct = $_POST['sizeproduct'];
    $priceproduct = $_POST['priceproduct'];
    $quantityproduct = $_POST['quantityproduct'];
    $imgproduct = $_POST['imgproduct'];
    $saleproduct = $_POST['saleproduct'];
    $color = $_POST['Color'];

    // Подготавливаем и выполняем запрос на обновление данных в базе
    $stmt = $conn->prepare("UPDATE `Products` SET `NameProducts` = :productname, `DescriptionProducts` = :descritpionproduct,
    `Size` = :sizeproduct, `Price` = :priceproduct, `Quantity` = :quantityproduct,  `ImageUrl` = :imgproduct, 
    `Sale` = :saleproduct, `Color` = :color WHERE `Id` = :products_id");

    $stmt->bindParam(':productname', $productname);
    $stmt->bindParam(':descritpionproduct', $descritpionproduct);
    $stmt->bindParam(':sizeproduct', $sizeproduct);
    $stmt->bindParam(':priceproduct', $priceproduct);
    $stmt->bindParam(':quantityproduct', $quantityproduct);
    $stmt->bindParam(':imgproduct', $imgproduct);
    $stmt->bindParam(':saleproduct', $saleproduct);
    $stmt->bindParam(':color', $color);
    $stmt->bindParam(':products_id', $products_id);

    if ($stmt->execute()) {
        $successMessage = "Данные успешно обновлены в базе данных.";
        header("Location: /index.php");
        exit;
    } else {
        $errorMessage = "Ошибка при выполнении запроса: " . $stmt->errorInfo()[2];
    }
} else {
    // Если POST-запрос не был выполнен, используем данные из базы данных
    $productname = $products['NameProducts'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/AdminPanel/assets/styles/bootstrap.min.css">
    <link rel="stylesheet" href="/AdminPanel/assets/styles/style.css">
    <title>Редактирование товара</title>
</head>

<body>
    <div class="container">
        <div class="admins_list mt-5 shadow-lg p-3 mb-5 bg-body rounded">
            <div class="header_form d-flex align-items-center justify-content-between p-2">
                <h1>Редактирование товара</h1> <a href="/AdminPanelindex.php"><img src="../../../assets/close.svg" alt=""></a>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $products_id; ?>" class="admins_form">
                <input class="admin_input" type="text" name="productname" placeholder="Имя товара" value="<?= $productname ?>" />
                <input class="admin_input" type="text" name="descritpionproduct" placeholder="Описание" value="<?= $descritpionproduct ?>" />
                <input class="admin_input" type="text" name="sizeproduct" placeholder="Размер" value="<?= $sizeproduct ?>" />
                <input class="admin_input" type="text" name="priceproduct" placeholder="цена" value="<?= $priceproduct ?>" />
                <input class="admin_input" type="text" name="quantityproduct" placeholder="колличество товара" value="<?= $quantityproduct ?>" />
                <input class="admin_input" type="text" name="imgproduct" placeholder="картинка" value="<?= $imgproduct ?>" />
                <input class="admin_input" type="text" name="saleproduct" placeholder="скидка" value="<?= $saleproduct ?>" />
                <input class="admin_input" type="text" name="Color" placeholder="цвет" value="<?= $color ?>" />
                <button class="admin_button btn btn-success" type="submit">Сохранить</button>
            </form>
        </div>
    </div>
</body>

</html>