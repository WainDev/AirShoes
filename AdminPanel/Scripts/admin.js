// Admin
// Добавление окно
let wrapperModal = document.querySelector(".wraper_table");
let wrapperModalredactor = document.querySelector(".redactor");
// Редактировние окно
let pencil = document.querySelector(".pencil");
let modlPencilClose = document.querySelector(".redactor_close");
// открытие закрытие
let modalAdminOpen = document.querySelector(".mybtn");
let modlAdminClose = document.querySelector(".modal_close");

// Product
// Добавление окно
let wrapperModalProduct = document.querySelector(".wraper_tableProduct"); //добавление
let wrapperModalredactorProduct = document.querySelector(".redactorProduct"); // редактирование
// Редактировние окно
let pencilProduct = document.querySelector(".pencilProduct"); //кнопка редактирования в основной карточки
let modlPencilCloseProduct = document.querySelector(".redactor_closeProduct"); // кнопка закрытия в редактировании
// открытие закрытие
let modalAdminOpenProduct = document.querySelector(".mybtnProduct"); //admin__button__table оснавная карточка
let modlAdminCloseProduct = document.querySelector(".modal_closeProduct"); //кнопка закрытия в добавлении

// Brend
// Добавление окно
let wrapperModalBrend = document.querySelector(".wraper_tableBrend"); //добавление
let wrapperModalredactorBrend = document.querySelector(".redactorBrend"); // редактирование
// Редактировние окно
let pencilBrend = document.querySelector(".pencilBrend"); //кнопка редактирования в основной карточки
let modlPencilCloseBrend = document.querySelector(".redactor_closeBrend"); // кнопка закрытия в редактировании
// открытие закрытие
let modalAdminOpenBrend = document.querySelector(".mybtnBrend"); //admin__button__table оснавная карточка
let modlAdminCloseBrend = document.querySelector(".modal_closeBrend"); //кнопка закрытия в добавлении

//Category
// Добавление окно
let wrapperModalCategory = document.querySelector(".wraper_tableCategory"); //добавление
let wrapperModalredactorCategory = document.querySelector(".redactorCategory"); // редактирование
// Редактировние окно
let pencilCategory = document.querySelector(".pencilCategory"); //кнопка редактирования в основной карточки
let modlPencilCloseCategory = document.querySelector(".redactor_closeCategory"); // кнопка закрытия в редактировании
// открытие закрытие
let modalAdminOpenCategory = document.querySelector(".mybtnCategory"); //admin__button__table оснавная карточка
let modlAdminCloseCategory = document.querySelector(".modal_closeCategory"); //кнопка закрытия в добавлении

let modalMenu = false;
// Добавление админа
pencil.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalredactor.classList.add("wraper_show");
    // document.body.classList.add("modal_open");
    modalMenu = true;
  } else {
    wrapperModalredactor.classList.remove("wraper_show");
    // document.body.classList.remove("modal_open");
  }
});
modlPencilClose.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalredactor.classList.remove("wraper_show");
    // document.body.classList.remove("modal_open");
    modalMenu = false;
  } else {
    wrapperModalredactor.classList.remove("wraper_show");
    // document.body.classList.remove("modal_open");
    modalMenu = false;
  }
});
modalAdminOpen.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModal.classList.add("wraper_show");
    document.body.classList.add("modal_open");
    modalMenu = true;
  } else {
    wrapperModal.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
  }
});
modlAdminClose.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModal.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  } else {
    wrapperModal.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  }
});

// Product
pencilProduct.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalredactorProduct.classList.add("wraper_show");
    document.body.classList.add("modal_open");
    modalMenu = true;
  } else {
    wrapperModalredactorProduct.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
  }
});
modlPencilCloseProduct.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalredactorProduct.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  } else {
    wrapperModalredactorProduct.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  }
});
modalAdminOpenProduct.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalProduct.classList.add("wraper_show");
    document.body.classList.add("modal_open");
    modalMenu = true;
  } else {
    wrapperModalProduct.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
  }
});
modlAdminCloseProduct.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalProduct.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  } else {
    wrapperModalProduct.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  }
});

// Brend
pencilBrend.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalredactorBrend.classList.add("wraper_show");
    document.body.classList.add("modal_open");
    modalMenu = true;
  } else {
    wrapperModalredactorBrend.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
  }
});
modlPencilCloseBrend.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalredactorBrend.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  } else {
    wrapperModalredactorBrend.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  }
});
modalAdminOpenBrend.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalBrend.classList.add("wraper_show");
    document.body.classList.add("modal_open");
    modalMenu = true;
  } else {
    wrapperModalBrend.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
  }
});
modlAdminCloseBrend.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalBrend.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  } else {
    wrapperModalBrend.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  }
});

// Category
pencilCategory.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalredactorCategory.classList.add("wraper_show");
    document.body.classList.add("modal_open");
    modalMenu = true;
  } else {
    wrapperModalredactorCategory.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
  }
});
modlPencilCloseCategory.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalredactorCategory.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  } else {
    wrapperModalredactorCategory.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  }
});
modalAdminOpenCategory.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalCategory.classList.add("wraper_show");
    document.body.classList.add("modal_open");
    modalMenu = true;
  } else {
    wrapperModalCategory.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
  }
});
modlAdminCloseCategory.addEventListener("click", () => {
  if (!modalMenu) {
    wrapperModalCategory.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  } else {
    wrapperModalCategory.classList.remove("wraper_show");
    document.body.classList.remove("modal_open");
    modalMenu = false;
  }
});
