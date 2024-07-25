var favoritOpen = document.querySelector(".favorit_open");
var favoritClose = document.querySelector(".favorit_close");
var wrapper = document.querySelector(".wrapper");
var menuopen = false;

favoritOpen.addEventListener("click", () => {
  if (!menuopen) {
    wrapper.classList.add("active");
    document.body.classList.add("modal_open");
    menuopen = false;
  } else {
    wrapper.classList.remove("active");
    document.body.classList.remove("modal_open");
    menuopen = false;
  }
});

favoritClose.addEventListener("click", () => {
  if (!menuopen) {
    wrapper.classList.remove("active");
    document.body.classList.remove("modal_open");
    menuopen = false;
  } else {
    wrapper.classList.add("active");
    document.body.classList.remove("modal_open");
    menuopen = false;
  }
});

// поиск
document.addEventListener("DOMContentLoaded", function () {
  var searchInput = document.getElementById("searchInput");
  var searchResults = document.getElementById("searchResults");

  searchInput.addEventListener("input", performSearch);

  function performSearch() {
    var searchTerm = searchInput.value.trim().toLowerCase();
    searchResults.innerHTML = "";

    if (searchTerm === "") {
      return; // если поиск пуст, не показывать результаты
    }

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var tempDiv = document.createElement("div");
          tempDiv.innerHTML = xhr.responseText;

          var productCards = tempDiv.querySelectorAll(".card_product");

          var resultsFound = false;
          var productKeysSet = new Set(); // Для отслеживания уникальных ключей продуктов

          productCards.forEach(function (card) {
            var productName = card
              .querySelector(".card-title")
              .textContent.toLowerCase();
            var productKey = card.getAttribute("data-product-key");

            if (
              productName.includes(searchTerm) &&
              !productKeysSet.has(productKey)
            ) {
              searchResults.appendChild(card.cloneNode(true));
              productKeysSet.add(productKey);
              resultsFound = true;
            }
          });

          if (!resultsFound) {
            searchResults.innerHTML = "Ничего не найдено";
          }
        } else {
          console.error("Произошла ошибка при выполнении запроса.");
        }
      }
    };

    xhr.open("GET", "Card.php", true);
    xhr.send();
  }
});

// ajax запрос на добавление в избранноеы

$(document).ready(function () {
  updateFavorites();
  updateButtonStates();

  // Добавление в избранное для карточек товара
  $(".favorite-form").on("submit", function (e) {
    e.preventDefault();

    var form = $(this);
    var productId = form.find('input[name="product_id"]').val();
    var productName = form.find('input[name="product_name"]').val();
    var productPrice = form.find('input[name="product_price"]').val();
    var productImage = form.find('input[name="product_image"]').val();
    var button = form.find(".card_btn");

    $.ajax({
      url: "add_favorites.php",
      type: "POST",
      data: {
        product_id: productId,
        product_name: productName,
        product_price: productPrice,
        product_image: productImage,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status === "success") {
          updateFavorites();
          updateButtonStates();
        } else {
          console.error("Error adding to favorites:", data.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  });

  // Удаление из избранного
  $(document).on("click", ".heart", function () {
    var productId = $(this).data("id");

    $.ajax({
      url: "remove_favorites.php",
      type: "POST",
      data: { product_id: productId },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status === "success") {
          updateFavorites();
          updateButtonStates();
        } else {
          console.error("Error removing from favorites:", data.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  });

  // Перенос товара в Product.php
  $(document).on("click", ".favorrit_buttons", function () {
    var productId = $(this).siblings(".heart").data("id");
    window.location.href = "Product.php?id=" + productId;
  });

  // Функция добавления в избранное для подборок
  window.addToFavorites = function (productId) {
    // Получение данных о продукте из DOM или другим способом
    var productCard = $('[data-id="' + productId + '"]');
    var productName = productCard.find(".button__title").text();
    var productPrice = productCard
      .find(".d-flex")
      .last()
      .text()
      .replace("Цена:", "")
      .replace("р", "")
      .trim();
    var productImage = productCard.find("img").attr("src");

    $.ajax({
      url: "add_to_favorites_product.php",
      type: "POST",
      data: {
        product_id: productId,
        product_name: productName,
        product_price: productPrice,
        product_image: productImage,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status === "success") {
          updateFavorites();
          updateButtonStates();
        } else {
          console.error("Error adding to favorites:", data.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  };

  function updateFavorites() {
    $.ajax({
      url: "get_favorites.php",
      type: "GET",
      success: function (response) {
        $(".favorit_main").html(response);
        updateButtonStates();
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  }

  function updateButtonStates() {
    $.ajax({
      url: "get_favorites.php",
      type: "GET",
      success: function (response) {
        var favorites = JSON.parse(response);
        $(".favorite-form").each(function () {
          var form = $(this);
          var productId = form.find('input[name="product_id"]').val();
          var button = form.find(".card_btn");

          if (favorites.some((favorite) => favorite.id == productId)) {
            button.addClass("active");
          } else {
            button.removeClass("active");
          }
        });
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  }

  $("#favorit_close").on("click", function () {
    $(".favorit").hide();
  });
});

// размеры
function setSize(size) {
  document.getElementById("size_input").value = size;
}

function validateSizeSelection(event) {
  var size = document.getElementById("size_input").value;
  if (size === "") {
    event.preventDefault(); // Останавливаем отправку формы
    var myModal = new bootstrap.Modal(document.getElementById("sizeModal"), {});
    myModal.show();
    return false;
  }
  return true;
}

// function addToFavorites(productId) {
//   $.post("add_favorites.php", { product_id: productId })
//     .done(function (data) {
//       alert("Product added to favorites!");
//     })
//     .fail(function () {
//       alert("Failed to add product to favorites.");
//     });
// }
