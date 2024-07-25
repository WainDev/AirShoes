<?php
session_start();
include_once "Config/Database.php";
$db = new Database();
$conn = $db->getConnection();
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $product_id = $_GET['id'];
} else {
  echo "Product ID is missing";
  exit;
}
$query = "SELECT * FROM Products WHERE Id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(":id", $product_id);
$stmt->execute();
$product = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
  <link rel="stylesheet" href="./Assets/styles/style.css" />
  <title><?php echo htmlspecialchars($product['NameProducts']); ?></title>
</head>

<body>

  <div class="container">

    <?php require_once "header.php"; ?>

    <div class="header_block mt-4 p-4 d-flex align-items-center justify-content-between">
      <h1>Продукт</h1>
      <a class="pay_button" href="/card.php">Назад</a>
    </div>
    <?php
    include_once "Config/Database.php";
    $db = new Database();
    $conn = $db->getConnection();
    if (isset($_GET['id']) && !empty($_GET['id'])) {
      $product_id = $_GET['id'];
    } else {
      echo "Product ID is missing";
      exit;
    }
    $query = "SELECT * FROM Products WHERE Id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":id", $product_id);
    $stmt->execute();
    $product = $stmt->fetch();
    if ($product && is_array($product)) {
    ?>
      <div class="product p-5 d-flex flex-wrap justify-content-between">
        <div class="product_left">
          <img class="w-100" src="<?php echo $product['ImageUrl']; ?>" alt="" />
          <ul class="nav nav-tabs w-100 mt-4" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
                Детали
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                Способы оплаты
              </button>
            </li>
          </ul>
          <div class="tab-content  tab__content" id="myTabContent">
            <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">
              <span><?php echo $product['DescriptionProducts']; ?></span>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
              ...
            </div>
          </div>
        </div>
        <div class="product_right text-center">
          <?php
          session_start();

          // Подключение к базе данных
          include_once "Config/Database.php";

          $db = new Database();
          $conn = $db->getConnection();

          // Получение id продукта из GET параметра
          $product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

          if ($product_id == 0) {
            echo "Invalid product ID";
            exit;
          }

          // Запрос данных о продукте
          $query = "SELECT * FROM Products WHERE Id = :product_id";
          $stmt = $conn->prepare($query);
          $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
          $stmt->execute();

          if ($stmt->rowCount() > 0) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
          } else {
            echo "Product not found";
            exit;
          }


          // Получение доступных размеров, учитывая цвет и название продукта
          $sizes_query = "SELECT Size FROM Products WHERE NameProducts = :name_products AND Color = :color";
          $stmt = $conn->prepare($sizes_query);
          $stmt->bindParam(':name_products', $product['NameProducts'], PDO::PARAM_STR);
          $stmt->bindParam(':color', $product['Color'], PDO::PARAM_STR);
          $stmt->execute();
          $available_sizes = [];

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $available_sizes[] = $row['Size'];
          }

          // Список всех возможных размеров
          $all_sizes = [36, 37, 38, 39, 40, 41, 42, 43];
          ?>
          <h1><?php echo htmlspecialchars($product['NameProducts']); ?></h1>
          <h5 class="mt-5 mb-4">Размеры</h5>
          <div class="checkbox_rows mb-5 d-grid">
            <?php foreach ($all_sizes as $size) : ?>
              <div class="checkbox_block">
                <input type="radio" name="model" class="js-offer" id="size_EU_<?php echo $size; ?>" value="<?php echo $size; ?>" <?php echo in_array($size, $available_sizes) ? '' : 'disabled'; ?> onclick="setSize(<?php echo $size; ?>)" />
                <label for="size_EU_<?php echo $size; ?>" style="<?php echo in_array($size, $available_sizes) ? '' : 'color: grey;'; ?>"> EU <?php echo $size; ?> </label>
              </div>
            <?php endforeach; ?>
          </div>
          <p><?php echo htmlspecialchars($product['Price']); ?>р</p>
          <form action="pay.php" method="post" onsubmit="return validateSizeSelection(event);">
            <input type="hidden" name="product_id" value="<?php echo $product['Id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['NameProducts']); ?>">
            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product['Price']); ?>">
            <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['ImageUrl']); ?>">
            <input type="hidden" name="size" value="" id="size_input">
            <button class="product_button w-100" type="submit">В корзину</button>
          </form>
        </div>
      </div>
  </div>
<?php
    } else {
      echo "Product not found";
    }
?>
<div class="modal fade" id="sizeModal" tabindex="-1" aria-labelledby="sizeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sizeModalLabel">Выберите размер</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Пожалуйста, выберите размер перед добавлением товара в корзину.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<div class="container container__podbor d-flex flex-wrap justify-content-between">
  <?php
  // Проверка, что переменные $product и $conn определены
  if (!isset($product) || !isset($conn)) {
    echo "Product or database connection not found.";
    return;
  }

  $brandId = $product['Brands_Id'] ?? null;
  $productId = $product['Id'] ?? null;

  // Проверка, что необходимые данные установлены
  if ($brandId === null || $productId === null) {
    echo "Product data is incomplete.";
    return;
  }

  $stmt = $conn->prepare("SELECT * FROM Products WHERE Brands_Id = :brandId AND Id != :productId");
  $stmt->bindParam(":brandId", $brandId, PDO::PARAM_INT);
  $stmt->bindParam(":productId", $productId, PDO::PARAM_INT);

  if ($stmt->execute()) {
    $similarProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Убедимся, что результат запроса является массивом
    if ($similarProducts === false) {
      $similarProducts = [];
    }

    $similarProductCount = count($similarProducts);

    if ($similarProductCount > 1) {
      $randomKeys = array_rand($similarProducts, 2);
    } elseif ($similarProductCount == 1) {
      $randomKeys = [0];
    } else {
      $randomKeys = [];
    }

    // Проверка на наличие случайных ключей
    if (!empty($randomKeys)) {
      foreach ($randomKeys as $key) {
        $similarProduct = $similarProducts[$key];
  ?>
        <div class="podbor mt-2 d-flex justify-content-around" data-id="<?php echo $similarProduct['Id']; ?>">
          <img class="w-50" src="<?php echo $similarProduct['ImageUrl']; ?>" alt="">
          <div class="p-2">
            <a href="Product.php?id=<?php echo $similarProduct['Id']; ?>">
              <button class="button__title" data-id="<?php echo $similarProduct['Id']; ?>"><?php echo $similarProduct['NameProducts']; ?></button>
            </a>
            <div class="d-flex justify-content-between pt-3">
              <p>Цена:</p>
              <p><?php echo $similarProduct['Price']; ?>р</p>
            </div>
            <div class="d-flex justify-content-between pt-3">
              <form action="add_to_favorites_product.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $similarProduct['Id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $similarProduct['NameProducts']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $similarProduct['Price']; ?> руб.">
                <input type="hidden" name="product_image" value="<?php echo $similarProduct['ImageUrl']; ?>">
                <button class="card_btn  p-2 mb-3">
                  <svg width="30" height="29" viewBox="0 0 30 29" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.0667 1C17.3332 1 15 5.90907 15 5.90907C15 5.90907 12.6668 1 7.9333 1C4.08642 1 1.04012 4.38573 1.00075 8.42574C0.920541 16.8118 7.32447 22.7756 14.3438 27.7874C14.5373 27.9259 14.766 28 15 28C15.2341 28 15.4627 27.9259 15.6562 27.7874C22.6748 22.7756 29.0787 16.8118 28.9993 8.42574C28.9599 4.38573 25.9136 1 22.0667 1Z" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>
              </form>

            </div>
          </div>
        </div>


  <?php
      }
    } else {
      echo "";
    }
  } else {
    echo "Error executing query.";
  }
  ?>
</div>

</div>

<script src="./Scripts/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./Scripts/index.js"></script>
</body>

</html>