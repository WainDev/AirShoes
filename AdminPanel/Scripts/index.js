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

document.addEventListener("DOMContentLoaded", function () {
  var searchInput = document.getElementById("searchInput");
  var searchResults = document.getElementById("searchResults");

  searchInput.addEventListener("input", performSearch);

  function performSearch() {
    var searchTerm = searchInput.value.trim().toLowerCase(); // Убираем лишние пробелы и приводим к нижнему регистру

    searchResults.innerHTML = ""; // Очистим предыдущие результаты поиска

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          var tempDiv = document.createElement("div");
          tempDiv.innerHTML = xhr.responseText;

          var productCards = tempDiv.querySelectorAll(".card_product");

          if (productCards.length > 0) {
            productCards.forEach(function (card) {
              var productName = card
                .querySelector(".card-title")
                .textContent.toLowerCase();
              if (productName.includes(searchTerm)) {
                searchResults.appendChild(card.cloneNode(true));
              }
            });

            if (searchResults.innerHTML === "") {
              searchResults.innerHTML = "Ничего не найдено";
            }
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
