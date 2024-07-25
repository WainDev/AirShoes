<?php
session_start();

// Инициализация корзины, если она еще не существует
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Если данные отправлены, добавляем их в корзину
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $product_id = $_POST['product_id'];
  $size = $_POST['size'];
  $key = $product_id . '_' . $size; // Уникальный ключ товара

  // Проверяем, есть ли уже такой товар в корзине
  if (isset($_SESSION['cart'][$key])) {
    $_SESSION['cart'][$key]['quantity']++;
    $_SESSION['cart'][$key]['total_price'] = $_SESSION['cart'][$key]['quantity'] * $_SESSION['cart'][$key]['price'];
  } else {
    $product = [
      'id' => $product_id,
      'name' => $_POST['product_name'],
      'price' => $_POST['product_price'],
      'image' => $_POST['product_image'],
      'size' => $size,
      'quantity' => 1,
      'total_price' => $_POST['product_price']
    ];
    $_SESSION['cart'][$key] = $product;
  }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['key'])) {
  // Обработка удаления товара из корзины
  $key = $_GET['key'];
  if (isset($_SESSION['cart'][$key])) {
    unset($_SESSION['cart'][$key]);
  }
}

// Получение товаров из корзины
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Вычисляем общее количество товаров в корзине
$total_items = array_reduce($cart, function ($carry, $item) {
  return $carry + $item['quantity'];
}, 0);

// Вычисляем общую сумму заказа
$total_price = array_reduce($cart, function ($carry, $item) {
  return $carry + $item['total_price'];
}, 0);
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="./Assets/styles/bootstrap.min.css" />
  <link rel="stylesheet" href="./Assets/styles/style.css" />
  <title>Корзина</title>
</head>

<body>
  <?php require_once "header.php"; ?>
  <div class="container">
    <div class="header_block mt-4 p-4 d-flex align-items-center justify-content-between">
      <h1>Корзина</h1>
      <a class="pay_button" href="index.php">Назад</a>
    </div>
    <div class="pay d-flex flex-wrap justify-content-between">
      <main class="mt-4">
        <div class="container">
          <?php foreach ($cart as $key => $item) : ?>
            <div class="pay_card mb-4 d-flex align-items-center p-4 justify-content-between">
              <img class="w-25" src="<?php echo htmlspecialchars($item['image']); ?>" alt="" />
              <div class="pay_print_card">
                <h5 class="pay_title"><?php echo htmlspecialchars($item['name']); ?></h5>
                <span class="pay_print">Размер: <?php echo htmlspecialchars($item['size']); ?></span>
              </div>
              <p><?php echo htmlspecialchars($item['quantity']); ?> шт</p>
              <h5 class="pay_price"><?php echo htmlspecialchars($item['total_price']); ?> ₽</h5>
              <a href="pay.php?action=remove&key=<?php echo urlencode($key); ?>" class="pay_del_button">
                <img src="./Assets/image/close.svg" alt="" />
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </main>

      <aside class="p-2">
        <div class="pay_info text-center p-5">
          <p class="pay_info_text"><?php echo $total_items; ?> товаров на сумму <?php echo $total_price; ?>р</p>
        </div>
        <div class="payment_block mt-4 p-4">
          <ul class="payment_header p-2">
            <li>Стоимость доставки будет рассчитана следующим шагом</li>
          </ul>
          <h1 class="mt-4 payment_text">К оплате: <?php echo $total_price; ?>р</h1>
          <button class="pay_button_pay p-4 w-100 mt-4">
            <span class="button_text">Оплатить</span>
          </button>
          <div class="forms_payment mt-4">
            <h1 class="payment_text">Есть промокод?</h1>
            <div class="promo mt-4 d-flex align-items-center justify-content-between">
              <input type="text" class="promo_input" placeholder="Промокод" />
              <button class="pay_button_promo p-2">
                <span class="button_text_promo">Применить</span>
              </button>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </div>
  <script src="./Scripts/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./Scripts/index.js"></script>
</body>

</html>