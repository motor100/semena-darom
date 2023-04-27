document.addEventListener("DOMContentLoaded", () => {

  // Общие переменные
  let body = document.querySelector('body'),
      newsSection = document.querySelector('.news-section'), 
      cartPage = document.querySelector('.cart .cart-items-wrapper'), // страница корзина
      catalogPage = document.querySelector('.catalog'), // страница каталог
      singleProduct = document.querySelector('.single-product'), // страница товара
      dostavkaIOplataPage = document.querySelector('.dostavka-i-oplata'), // страница доставка и оплата
      otzyvyPage = document.querySelector('.otzyvy'), // страница отзывы
      token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // csrf token


  // addToCart();


  // Скрывание кнопки Мы используем куки we use cookie
  let messagesCookies = document.querySelector('.messages-cookies'),
      messagesCookiesClose = document.querySelector('.messages-cookies-close');

  if (messagesCookiesClose) {
    messagesCookiesClose.onclick = function() {
      messagesCookies.classList.add('hidden');
      document.cookie = "we-use-cookie=yes; path=/; max-age=2629743; samesite=lax";
    }
  }

  // Окна
  let modalWindow = document.querySelectorAll('.modal-window'),
      mobileMenuCityBtn = document.querySelector('.js-mobile-menu-city-btn'),
      selectCityModal = document.querySelector('#select-city-modal'),
      callbackBtn = document.querySelector('.js-callback-btn'),
      callbackModal = document.querySelector('#callback-modal'),
      testimonialsBtn = document.querySelector('.testimonials-btn'),
      testimonialsModal = document.querySelector('#testimonials-modal'),
      payInfoBtn = document.querySelector('.dostavka-i-oplata .pay-info-btn'),
      modalCloseBtn = document.querySelectorAll('.modal-window .modal-close');

  // mobileMenuCityBtn.onclick = function () {
  //   closeMenu();
  //   modalOpen(selectCityModal);
  // }

  callbackBtn.onclick = function () {
    modalOpen(callbackModal);
  }

  if(testimonialsBtn) {
    testimonialsBtn.onclick = function () {
      modalOpen(testimonialsModal);
    }
  }

  if(payInfoBtn) {
    payInfoBtn.onclick = function () {
      modalOpen(callbackModal);
    }
  }

  function modalOpen(win) {
    body.classList.add('overflow-hidden');
    win.classList.add('active');
    setTimeout(function(){
      win.childNodes[1].classList.add('active');
    }, 200);
  }

  for (let i=0; i < modalCloseBtn.length; i++) {
    modalCloseBtn[i].onclick = function() {
      modalClose(modalWindow[i]);
    }
  }

  for (let i = 0; i < modalWindow.length; i++) {
    modalWindow[i].onclick = function(event) {
      let classList = event.target.classList;
      for (let j = 0; j < classList.length; j++) {
        if (classList[j] == "modal" || classList[j] == "modal-wrapper" || classList[j] == "modal-window") {
          modalClose(modalWindow[i])
        }
      }
    }
  }

  function modalClose(win) {
    body.classList.remove('overflow-hidden');
    win.childNodes[1].classList.remove('active');
    setTimeout(function(){
      win.classList.remove('active');
    }, 300);
  }

  

  // Phone mask
  /*
  let elementPhone = document.querySelectorAll('.js-input-phone-mask');

  let maskOptionsPhone = {
    mask: '+{7} (000) 000 00 00'
  };

  elementPhone.forEach((item) => {
    let mask = IMask(item, maskOptionsPhone);
  });
  */

  // Sticky desktop menu
  /*
  window.onscroll = function() {
    let scrStickyDesktopMenu = window.pageYOffset || document.documentElement.scrollTop,
        stickyDesktopMenu = document.querySelector('.sticky-desktop-menu');
    if (scrStickyDesktopMenu > 400) {
      stickyDesktopMenu.classList.add('sticky-desktop-menu-active');
    }
    if (scrStickyDesktopMenu < 400) {
      stickyDesktopMenu.classList.remove('sticky-desktop-menu-active');
    }
  }
  */

  // mobile menu
  let burgerMenuWrapper = document.querySelector('.burger-menu-wrapper'),
      mobileMenu = document.querySelector('.mobile-menu'),
      burgerMenu = document.querySelector('.burger-menu');

  burgerMenuWrapper.onclick = function () {
    body.classList.toggle('overflow-hidden');
    mobileMenu.classList.toggle('mobile-menu-open');
    burgerMenu.classList.toggle('close');
    burgerMenuWrapper.classList.toggle('active');
  }

  let listParentClick = document.querySelectorAll('.mobile-menu li.menu-item a');
  for (let i=0; i < listParentClick.length; i++) {
    listParentClick[i].onclick = function (event) {
      event.preventDefault();
      closeMenu();
      let hrefClick = this.href;
      setTimeout(function() {
        location.href = hrefClick
      }, 500);
    }
  }

  function closeMenu() {
    burgerMenuWrapper.classList.remove('active');
    burgerMenu.classList.remove('close');
    mobileMenu.classList.remove('mobile-menu-open');
    body.classList.remove('overflow-hidden');
  }

  /*
  * Функция проверки обязательных полей
  * Принимает параметр form, DOM элемент тег form
  * Проверяет наличие аттрибута required у input
  * Если все поля заполнены, возвращает true
  * Иначе false
  */
  function checkRequiredFields(form) {

    let input = form.querySelectorAll('.input-field');
    let arr = [];
    let valid;
    for (let i = 0; i < input.length; i++) {
      let attr = input[i].hasAttribute('required');
      if (attr && input[i].value == "" ) {
        input[i].classList.add('required');
        arr.push(false);
      }
    }

    if (arr.length == 0) {
      for (let i = 0; i < input.length; i++) {
        input[i].classList.remove('required');
      }
      return true;
    } else {
      return false;
    }
  }

  // Отправка формы ajax в модальном окне
  let callbackModalForm = document.querySelector("#callback-modal-form"),
      callbackModalBtn = document.querySelector('.js-callback-modal-btn');

  callbackModalBtn.onclick = function() {
    ajaxCallback(callbackModalForm);
  }

  function ajaxCallback(form) {

    let inputs = form.querySelectorAll('.input-field');
    let arr = [];

    let inputName = form.querySelector('#name-callback-modal');
    if (inputName.value.length < 3 || inputName.value.length > 20 ) {
      inputName.classList.add('required');
      arr.push(false);
    }

    let inputPhone = form.querySelector('#phone-callback-modal');
    if (inputPhone.value.length != 18) {
      inputPhone.classList.add('required');
      arr.push(false);
    }

    let inputCheckbox = form.querySelector('#checkbox-callback-modal');
    if (!inputCheckbox.checked) {
      arr.push(false);
    }

    if (arr.length == 0) {
      for (let i = 0; i < inputs.length; i++) {
        inputs[i].classList.remove('required');
      }
 
      fetch('/ajax/callback', {
        method: 'POST',
        cache: 'no-cache',
        body: new FormData(form)
      })
      .catch((error) => {
        console.log(error);
      })

      alert("Спасибо. Мы свяжемся с вами.");

      form.reset();

    }

    return false;
  }

  // Функция добавление товаров в корзину
  function addToCart() {

    let addToCartBtns = document.querySelectorAll('.add-to-cart');

    for (let i = 0; i < addToCartBtns.length; i++) {
      addToCartBtns[i].onclick = function() {

        if (this.classList[0] == 'add-to-cart-btn') {
          this.children[0].classList.add('circle-active');
        } else {
          this.innerText = 'В корзине';
        }
            
        let formData = {
          id: this.getAttribute('data-id'),
        };
        
        let xhr = new XMLHttpRequest();
        xhr.open('post', '/ajax/addtocart');
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded; charset=UTF-8');
        xhr.send('id=' + encodeURIComponent(formData.id) + '&_token=' + encodeURIComponent(token));
        xhr.onload = function() {
          if (xhr.response) {
            document.getElementById('header-cart-counter').innerText = xhr.response;
            document.getElementById('header-cart-counter').classList.remove('hidden');
            document.getElementById('sticky-menu-cart-counter').innerText = xhr.response;
            document.getElementById('sticky-menu-cart-counter').classList.remove('hidden');
            document.getElementById('mobile-cart-counter').innerText = xhr.response;
            document.getElementById('mobile-cart-counter').classList.remove('hidden');
          }
        }
      }
    }
  }



  if(otzyvyPage) {

    // Выбор файла Изображение
    let inputMainFile = document.querySelector('#input-main-file'),
    mainFileText = document.querySelector('.main-file-text');

    if (inputMainFile) {
      inputMainFile.onchange = function() {
        mainFileText.innerHTML = this.files[0].name;
      }
    }
    
  }

  if (cartPage) {

    

  }

  if (catalogPage) {

    
  }
    
  if (singleProduct) {
    
  
  }

  if (otzyvyPage) {

    

  }

});