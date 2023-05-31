document.addEventListener("DOMContentLoaded", () => {

  // Общие переменные
  let body = document.querySelector('body'),
      mainSection = document.querySelector('.main-section'),
      newsSection = document.querySelector('.news-section'),
      cartPage = document.querySelector('.js-cart-page'), // страница корзина
      catalogPage = document.querySelector('.catalog'), // страница каталог
      singleProduct = document.querySelector('.single-product'), // страница товара
      dostavkaIOplataPage = document.querySelector('.dostavka-i-oplata'), // страница доставка и оплата
      otzyvyPage = document.querySelector('.otzyvy'), // страница отзывы
      okompaniiPage = document.querySelector('.o-kompanii'), // страница о компании
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

  // Кнопка Каталог в шапке
  const catalogBtn = document.querySelector('.header .catalog-btn');
  if (catalogBtn) {
    const headerCatalogDropdown = document.querySelector('.header-catalog-dropdown');
    catalogBtn.onclick = function() {
      catalogBtn.classList.toggle('active');
      headerCatalogDropdown.classList.toggle('active');
    }
  }

  // Search
  let searchForm = document.querySelector('.search-form'),
      searchInput = document.querySelector('.search-input'),
      searchClose = document.querySelector('.search-close'),
      searchDropdown = document.querySelector('.search-dropdown'),
      searchRezult = document.querySelector('.js-search-rezult');

  function searchDropdownClose() {
    searchDropdown.classList.remove('search-dropdown-active');
    searchClose.classList.remove('search-close-active');
    searchInput.classList.remove('search-input-dp');
  }

  function searchResetForm() {
    searchForm.reset();
    searchDropdown.classList.remove('search-dropdown-active');
    searchClose.classList.remove('search-close-active');
    searchInput.classList.remove('search-input-active');
    searchInput.classList.remove('search-input-dp');
  }

  searchInput.onfocus = function() {
    searchInput.classList.add('search-input-active');
  }

  searchInput.onblur = function() {
    searchInput.classList.remove('search-input-active');
    searchDropdownClose();
  }

  searchClose.onclick = searchResetForm;

  searchInput.oninput = searchOnInput;

  function searchOnInput() {

    if (searchInput.value.length > 3 && searchInput.value.length < 40) {

      const searchSeeAll = document.querySelector('.search-see-all');

      fetch('/ajax/search', {
        method: 'POST',
        cache: 'no-cache',
        body: new FormData(searchForm)
      })
      .then((response) => response.json())
      .then((json) => {

        // Очистка результатов поиска
        searchRezult.innerHTML = '';
        searchSeeAll.classList.remove('search-see-all-active');

        // Если в объекте есть ключ message, то не найдено
        if (typeof json.message !== "undefined") {
          let tmpEl = document.createElement('li');
          tmpEl.className = "no-product";
          tmpEl.innerHTML = 'Товаров не найдено';
          searchRezult.append(tmpEl);

        } else { // вывожу результаты поиска

          // Ограничение количества выводимых результатов
          if (json.length > 4) {
            json.length = 4; 
          }

          // Формирую html из массива данных
          json.forEach((item) => {
            let tmpEl = document.createElement('li');
            tmpEl.className = "search-list-item";
            let str = '<div class="search-list-item__image"><img src="/img/search-lens.png" alt=""></div>';
            str += '<div class="search-list-item__title">' + item.title + '</div>';
            str += '<a href="/catalog/' + item.slug + '" class="full-link search-list-item__link"></a>';
            tmpEl.innerHTML = str;
            searchRezult.append(tmpEl);
          });

          searchSeeAll.classList.add('search-see-all-active');

          // Добавляю клик на найденные элементы
          let searchListItemLink = document.querySelectorAll('.search-list-item__link');

          searchListItemLink.forEach((item) => {
            item.onclick = searchResetForm;
          });

          // Добавляю клик на ссылку Показать все результаты
          searchSeeAll.classList.add('search-see-all-active');
          searchSeeAll.href = '/poisk?q=' + searchInput.value;
          searchSeeAll.onclick = searchResetForm;
        }
        
        searchClose.classList.add('search-close-active');
        searchInput.classList.add('search-input-dp');
        searchDropdown.classList.add('search-dropdown-active');
      })
      .catch((error) => {
        console.log(error);
      })

    } else {
      // Если менее 3 символов, то скрываю результаты поиска
      searchDropdownClose();
    }

  }

  // City select
  const citySelectModalWindow = document.querySelector('#select-city-modal'),
        citySelectForm = document.querySelector('#city-select-form'),
        citySelectInput = document.querySelector('#city-select-input'),
        citySelectRezult = document.querySelector('#city-select-rezult'),
        citySelectModalCloseBtn = document.querySelector('#select-city-modal .modal-close');

  function selectCityItemClick() {
    let cityItems = selectCityModal.querySelectorAll('#select-city-modal .city-item');

    for (let i = 0; i < cityItems.length; i++) {
      cityItems[i].onclick = function () {
        let ccity = cityItems[i].querySelector('.city-item__city').innerText;
        document.cookie = "city=" + ccity + "; path=/; max-age=2629743; samesite=lax";
        modalClose(selectCityModal);
        citySelectForm.reset();
        location.reload();
      }
    }
  }

  citySelectInput.oninput = citySelectOnInput;

  function citySelectOnInput() {

    if (citySelectInput.value.length >= 3 && citySelectInput.value.length < 40) {

      fetch('/ajax/city-select', {
        method: 'POST',
        cache: 'no-cache',
        body: new FormData(citySelectForm)
      })
      .then((response) => response.json())
      .then((json) => {

        // Очистка результатов поиска
        citySelectRezult.innerHTML = '';

        // Если в объекте есть ключ message, то не найдено
        if (typeof json.message !== "undefined") {
          let tmpEl = document.createElement('div');
          tmpEl.className = "no-city";
          tmpEl.innerHTML = 'Город с таким названием не найден';
          citySelectRezult.append(tmpEl);

        } else { // вывожу результаты поиска

          // Ограничение количества выводимых результатов
          if (json.length > 6) {
            json.length = 6; 
          }

          json.forEach((item) => {
            let tmpEl = document.createElement('div');
            tmpEl.className = "city-item";
            tmpEl.innerHTML = '<span class="city-item__city">' + item.city + '</span>';
            tmpEl.innerHTML += '<span class="city-item__region">' + ' ' + item.region + '</span>';
            citySelectRezult.append(tmpEl);
          });

          // Добавляю клик на найденные элементы
          selectCityItemClick();

        }
      })
      .catch((error) => {
        console.log(error);
      })


    } else {
      // Если менее 3 символов, то скрываю результаты поиска
      citySelectRezult.innerHTML = '';
    }

  };

  function citySelectModalClose() {
    citySelectForm.reset();
    citySelectRezult.innerHTML = '';
  }

  citySelectModalCloseBtn.addEventListener('click', citySelectModalClose);

  citySelectModalWindow.addEventListener('click', function(event) {
    let classList = event.target.classList;
    for (let j = 0; j < classList.length; j++) {
      if (classList[j] == "modal" || classList[j] == "modal-wrapper" || classList[j] == "modal-window") {
        modalClose(citySelectModalWindow);
        citySelectModalClose();
      }
    }
  });


  // Add to favourites
  const addToFavouritesBtns = document.querySelectorAll('.add-to-favourites');

  function addToFavourites(elem) {
    // Add class to elem
    elem.classList.add('active');

    fetch('/ajax/addtofavourites', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      cache: 'no-cache',
      body: 'id=' + encodeURIComponent(elem.dataset.id) + '&_token=' + encodeURIComponent(token),
    })
    .then((response) => response.text())
    .then((text) => {
      const headerFavouritesCounter = document.querySelector('#header-favourites-counter');
      headerFavouritesCounter.innerText = text;
      headerFavouritesCounter.classList.remove('hidden');
    })
    .catch((error) => {
      console.log(error);
    })
  }

  addToFavouritesBtns.forEach((item) => {
    item.onclick = function() {
      addToFavourites(item);
    }
  });
  

  // Окна
  let modalWindow = document.querySelectorAll('.modal-window'),
      mobileMenuCityBtn = document.querySelector('.js-mobile-menu-city-btn'),
      selectCityBtn = document.querySelector('#city-select-btn'),
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

  selectCityBtn.onclick = function () {
    modalOpen(selectCityModal);
  }

  callbackBtn.onclick = function () {
    modalOpen(callbackModal);
  }

  if (testimonialsBtn) {
    testimonialsBtn.onclick = function () {
      modalOpen(testimonialsModal);
    }
  }

  if (payInfoBtn) {
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
  let elementPhone = document.querySelectorAll('.js-input-phone-mask');

  let maskOptionsPhone = {
    mask: '+{7} (000) 000 00 00'
  };

  elementPhone.forEach((item) => {
    let mask = IMask(item, maskOptionsPhone);
  });

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

  /*
  function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
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
  const callbackModalForm = document.querySelector("#callback-modal-form"),
        callbackModalBtn = document.querySelector('.js-callback-modal-btn');

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

  callbackModalBtn.onclick = function() {
    ajaxCallback(callbackModalForm);
  }

  

  // Add to cart
  const addToCartBtns = document.querySelectorAll('.add-to-cart');

  function addToCart(elem) {

    // Add text
    elem.innerText = 'В корзине';

    fetch('/ajax/addtocart', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      cache: 'no-cache',
      body: 'id=' + encodeURIComponent(elem.dataset.id) + '&_token=' + encodeURIComponent(token),
    })
    .then((response) => response.text())
    .then((text) => {
      const headerCartCounter = document.querySelector('#header-cart-counter');
      headerCartCounter.innerText = text;
      headerCartCounter.classList.remove('hidden');
    })
    .catch((error) => {
      console.log(error);
    })

  }

  addToCartBtns.forEach((item) => {
    item.onclick = function() {
      addToCart(item);
    }
  });

  if (mainSection) {
    // Main swiper slider
    const mainSlider = new Swiper('.main-section .main-slider', {
      loop: true,
      navigation: {
        nextEl: '.main-button-next',
      },
    });

    // Category swiper slider
    const categorySlider = new Swiper('.main-section .category-slider', {
      slidesPerView: 6,
      spaceBetween: 10,
      loop: true,
      navigation: {
        nextEl: '.category-button-next',
      },
    });
  }

  if (otzyvyPage) {

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

    const cartItems = document.querySelectorAll('.cart-item');

    // Увеличение количество одного товара в корзине
    function ajax_plus_cart(elem) {

      fetch('/ajax/pluscart', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        cache: 'no-cache',
        body: 'id=' + encodeURIComponent(elem.dataset.id) + '&_token=' + encodeURIComponent(token),
      })
      .catch((error) => {
        console.log(error);
      })

    }

    // Уменьшение количество одного товара в корзине
    function ajax_minus_cart(elem) {

      fetch('/ajax/minuscart', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        cache: 'no-cache',
        body: 'id=' + encodeURIComponent(elem.dataset.id) + '&_token=' + encodeURIComponent(token),
      })
      .catch((error) => {
        console.log(error);
      })

    }

    cartItems.forEach((item) => {

      // quantity step
      const quantityMinus = item.querySelector('.quantity-minus'),
          quantityPlus = item.querySelector('.quantity-plus'),
          quantityNumber = item.querySelector('.quantity-number');

      // Расчет товар -1
      quantityMinus.onclick = function() {
        quantityNumber.stepDown();
        // quantityCalc();
        // weightCalc();
        // discountCalc();
        // summCalc();
        // Ограничение на уменьшение количества если меньше 1
        if (Number(quantityNumber.value) > 1) {
          ajax_minus_cart(this);
        }
      }

      // Расчет товар +1
      quantityPlus.onclick = function(){
        quantityNumber.stepUp();
        // quantityCalc();
        // weightCalc();
        // discountCalc();
        // summCalc();
        
        // Ограничение на увеличение количества если больше max
        if (Number(quantityNumber.value) <= Number(quantityNumber.max)) {
          ajax_plus_cart(this);
        }
      }

    });

    
    

  }

  if (catalogPage) {

    
  }
    
  if (singleProduct) {
    
  
  }

  if (okompaniiPage) {

    

  }

});