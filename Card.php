<?
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
  <link rel="stylesheet" href="./Assets/styles/style.css" />

</head>


<body>
  <div class="container">

    <?php
    require_once "header.php";
    require_once "./brends.php";
    ?>
    <div class="header_block mt-4 p-4 d-flex fl align-items-center justify-content-between">
      <h1>Каталог</h1>
      <a class="pay_button" href="/index.php">Назад</a>
    </div>

    <div class="card_blocks d-flex flex-wrap align-items-center justify-content-between">
      <?php
      include_once "Config/Database.php";
      $db = new Database();
      $conn = $db->getConnection();
      if ($conn) {
        $query = "
SELECT p.*
FROM Products p
INNER JOIN (
    SELECT MIN(Id) as Id
    FROM Products
    GROUP BY NameProducts, Color
) grouped_p
ON p.Id = grouped_p.Id
";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conn = null;
        foreach ($products as $product) {
          $productKey = $product['Id']; // Используем уникальный идентификатор продукта
      ?>
          <div class="d-flex fl align-items-center justify-content-between">
            <div class="card_product card shadow mt-5 p-3 mb-5 bg-body-tertiary rounded" data-product-key="<?php echo $productKey; ?>" style="width: 18rem">
              <a href="Product.php?id=<?php echo $product['Id']; ?>">
                <button class="eshe">Подробнее</button>
              </a>
              <form action="add_favorites.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['Id']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $product['NameProducts']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $product['Price']; ?> руб.">
                <input type="hidden" name="product_image" value="<?php echo $product['ImageUrl']; ?>">
                <button class="card_btn  p-2 mb-3">
                  <svg width="30" height="29" viewBox="0 0 30 29" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.0667 1C17.3332 1 15 5.90907 15 5.90907C15 5.90907 12.6668 1 7.9333 1C4.08642 1 1.04012 4.38573 1.00075 8.42574C0.920541 16.8118 7.32447 22.7756 14.3438 27.7874C14.5373 27.9259 14.766 28 15 28C15.2341 28 15.4627 27.9259 15.6562 27.7874C22.6748 22.7756 29.0787 16.8118 28.9993 8.42574C28.9599 4.38573 25.9136 1 22.0667 1Z" stroke="black" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                </button>
              </form>
              <img src="<?php echo $product['ImageUrl']; ?>" class="card-img-top mb-3" alt="..." />
              <div class="card_body">
                <h5 class="card-title text-center"><?php echo $product['NameProducts']; ?></h5>
                <div class="block_info d-flex justify-content-between">
                  <p class="card_text">Цена</p>
                  <p class="card_text"><?php echo $product['Price']; ?> руб.</p>
                </div>
              </div>
            </div>
          </div>
      <?php
        }
      } else {
        echo "Ошибка соединения с базой данных";
      }
      ?>




    </div>


    <script src="./Scripts/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./Scripts/index.js"></script>
</body>

</html>