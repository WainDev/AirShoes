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

            // Проверяем, что соединение установлено
            if ($conn) {
                // Запросы для получения брендов и категорий из базы данных
                $brandsQuery = $conn->query("SELECT `NameBrands` FROM `Brands`");
                $brands = $brandsQuery->fetchAll(PDO::FETCH_COLUMN);

                $categoriesQuery = $conn->query("SELECT `NameCategories` FROM `Categories`");
                $categories = $categoriesQuery->fetchAll(PDO::FETCH_COLUMN);

                // Подготавливаем запрос SQL для получения идентификатора бренда по его имени
                $brandName = $_POST['brands'];
                $getBrandIdStmt = $conn->prepare("SELECT `Id` FROM `Brands` WHERE `NameBrands` = :brandName");
                $getBrandIdStmt->bindParam(':brandName', $brandName);
                $getBrandIdStmt->execute();
                $brandId = $getBrandIdStmt->fetchColumn();

                $categoryName = $_POST['categories'];
                $getCategoryIdStmt = $conn->prepare("SELECT `Id` FROM `Categories` WHERE `NameCategories` = :categoryName");
                $getCategoryIdStmt->bindParam(':categoryName', $categoryName);
                $getCategoryIdStmt->execute();
                $categoryId = $getCategoryIdStmt->fetchColumn();

                // Продолжаем обработку формы после получения данных о брендах и категориях
                if (
                    !empty($_POST['productname']) &&
                    !empty($_POST['descritpionproduct']) &&
                    !empty($_POST['sizeproduct']) &&
                    !empty($_POST['priceproduct']) &&
                    !empty($_POST['quantityproduct']) &&
                    !empty($_POST['imgproduct']) &&
                    !empty($_POST['saleproduct']) &&
                    !empty($_POST['Color']) &&
                    !empty($brandId) && !empty($_POST['categories'])
                ) {

                    // Подготавливаем запрос SQL для добавления данных
                    $stmt = $conn->prepare("INSERT INTO `Products` (`Id`, `NameProducts`, `DescriptionProducts`,
                                            `Size`, `Price`, `Quantity`, `ImageUrl`, `Sale`, Color, `Brands_Id`, `Categories_Id`) 
                                            VALUES (NULL, :productname, :descritpionproduct, 
                                            :sizeproduct, :priceproduct, :quantityproduct, 
                                            :imgproduct, :saleproduct, :color, :brands_id, :categories_id)");

                    // Привязываем параметры запроса к значениям из формы и найденному идентификатору бренда
                    $stmt->bindParam(':productname', $_POST['productname']);
                    $stmt->bindParam(':descritpionproduct', $_POST['descritpionproduct']);
                    $stmt->bindParam(':sizeproduct', $_POST['sizeproduct']);
                    $stmt->bindParam(':priceproduct', $_POST['priceproduct']);
                    $stmt->bindParam(':quantityproduct', $_POST['quantityproduct']);
                    $stmt->bindParam(':imgproduct', $_POST['imgproduct']);
                    $stmt->bindParam(':saleproduct', $_POST['saleproduct']);
                    $stmt->bindParam(':color', $_POST['Color']);
                    $stmt->bindParam(':brands_id', $brandId); // Передаем идентификатор бренда
                    $stmt->bindParam(':categories_id', $categoryId); // Передаем найденный идентификатор категории


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
            } else {
                $errorMessage = "Ошибка: Не удалось установить соединение с базой данных.";
            }
        }
    }
} else {
    // Запросы для получения брендов и категорий из базы данных
    $db = new Database();

    // Проверяем подключение к базе данных
    if ($db->getConnection()) {
        $conn = $db->getConnection();

        // Проверяем, что соединение установлено
        if ($conn) {
            // Запросы для получения брендов и категорий из базы данных
            $brandsQuery = $conn->query("SELECT `NameBrands` FROM `Brands`");
            if (!$brandsQuery) {
                $errorMessage = "Ошибка при выполнении запроса к таблице брендов: " . $conn->errorInfo()[2];
            } else {
                $brands = $brandsQuery->fetchAll(PDO::FETCH_COLUMN);
            }

            $categoriesQuery = $conn->query("SELECT `NameCategories` FROM `Categories`");
            if (!$categoriesQuery) {
                $errorMessage = "Ошибка при выполнении запроса к таблице категорий: " . $conn->errorInfo()[2];
            } else {
                $categories = $categoriesQuery->fetchAll(PDO::FETCH_COLUMN);
            }
        } else {
            $errorMessage = "Ошибка: Не удалось установить соединение с базой данных.";
        }
    } else {
        $errorMessage = "Ошибка подключения к базе данных.";
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
    <title>Добавление товара</title>
</head>

<body>
    <div class="container">
        <div class="admins_list mt-5 shadow-lg p-3 mb-5 bg-body rounded">
            <div class="header_form d-flex align-items-center justify-content-between p-2">
                <h1>Добавление товара</h1> <a href="/AdminPanel/index.php"><img src="../../../Assets/image/close.svg" alt=""></a>
            </div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="admins_form">
                <input class="admin_input" type="text" name="productname" placeholder="Имя товара" />
                <input class="admin_input" type="text" name="descritpionproduct" placeholder="Описание" />
                <input class="admin_input" type="text" name="sizeproduct" placeholder="Размер" />
                <input class="admin_input" type="text" name="priceproduct" placeholder="цена" />
                <input class="admin_input" type="text" name="quantityproduct" placeholder="колличество товара" />
                <input class="admin_input" type="text" name="imgproduct" placeholder="картинка" />
                <input class="admin_input" type="text" name="saleproduct" placeholder="скидка" />
                <input class="admin_input" type="text" name="Color" placeholder="цвет" />
                <select name="brands" class="mb-3 m-2" id="brands-select">
                    <option value="">Выберите бренд</option>
                    <?php foreach ($brands as $brand) : ?>
                        <option value="<?= $brand ?>"><?= $brand ?></option>
                    <?php endforeach; ?>
                </select>
                <select class="mb-3 m-2" name="categories" id="categories-select">
                    <option value="">Выберите категорию</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category ?>"><?= $category ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="admin_button btn btn-success" type="submit">Добавить</button>
            </form>
        </div>
    </div>
</body>

</html>