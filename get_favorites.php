<?php
session_start();

if (isset($_SESSION['favorites']) && is_array($_SESSION['favorites'])) {
  $favorites = $_SESSION['favorites'];

  foreach ($favorites as $product) {
    echo '
    <div class="favorit_card p-3 mt-4 d-flex align-items-center justify-content-between">
      <img class="w-25" src="' . $product['image'] . '" alt="" />
      <div class="favorit_card_text">
        <h5>' . $product['name'] . '</h5>
        <div class="block_print">
          <span>Цена </span>
          <span>' . $product['price'] . '</span>
        </div>
      </div>
      <div class="favorit_button_card">
        <button class="heart" data-id="' . $product['id'] . '">
          <img src="./Assets/image/heart.svg" alt="" />
        </button>
        <button class="favorrit_buttons">
          <img src="./Assets/image/corzina.svg" alt="" />
        </button>
      </div>
    </div>';
  }
} else {
  echo '<p>Нет избранных товаров.</p>';
}
