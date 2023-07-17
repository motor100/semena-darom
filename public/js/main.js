document.addEventListener("DOMContentLoaded", () => {

  // Общие переменные
  let body = document.querySelector('body'),
      mainSection = document.querySelector('.main-section'),
      cartPage = document.querySelector('.js-cart-page'), // страница корзина
      createOrderPage = document.querySelector('.js-create-order'), // страница оформления заказа
      catalogPage = document.querySelector('.catalog'), // страница каталог
      akciiPage = document.querySelector('.akcii'), // страница акции
      novinkiPage = document.querySelector('.novinki'), // страница новинки
      otzyvyPage = document.querySelector('.otzyvy'), // страница отзывы
      okompaniiPage = document.querySelector('.o-kompanii'), // страница о компании
      token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // csrf token

  // Скрывание кнопки Мы используем куки we use cookie
  let messagesCookies = document.querySelector('.messages-cookies'),
      messagesCookiesClose = document.querySelector('.messages-cookies-close');

  if (messagesCookiesClose) {
    messagesCookiesClose.onclick = function() {
      messagesCookies.classList.add('hidden');
      // document.cookie = "we-use-cookie=yes; path=/; max-age=2629743; samesite=lax";
      fetch('/ajax/we-use-cookie', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        cache: 'no-cache',
        body: '_token=' + encodeURIComponent(token)
      })
      .catch((error) => {
        console.log(error);
      })
    }
    
  }

  // Кнопка Каталог в static и fixed шапке
  const headerCatalogBtns = document.querySelectorAll('.header-catalog-btn');

  headerCatalogBtns.forEach((item) => {
    const headerCatalogDropdown = document.querySelector('.header-catalog-dropdown');

    item.onclick = function() {
      item.classList.toggle('active');
      headerCatalogDropdown.classList.toggle('active');
    }

    const overlay = headerCatalogDropdown.querySelector('.overlay');

    overlay.onclick = function() {
      item.classList.remove('active');
      headerCatalogDropdown.classList.remove('active');
    }
  });


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

      fetch('/ajax/product-search', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        cache: 'no-cache',
        body: 'search_query=' + encodeURIComponent(searchInput.value) + '&_token=' + encodeURIComponent(token)
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
          searchSeeAll.href = '/poisk?search_query=' + searchInput.value;
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
        // citySelectForm = document.querySelector('#city-select-form'),
        citySelectInput = document.querySelector('#city-select-input'),
        citySelectRezult = document.querySelector('#city-select-rezult'),
        citySelectModalCloseBtn = document.querySelector('#select-city-modal .modal-close');

  citySelectInput.oninput = citySelectOnInput;

  function citySelectOnInput() {

    if (citySelectInput.value.length >= 3 && citySelectInput.value.length < 40) {

      function citySelect(arr) {
        // Очистка результатов поиска
        citySelectRezult.innerHTML = '';

        // Если в объекте есть ключ message, то не найдено
        if (typeof arr.message !== "undefined") {
          let tmpEl = document.createElement('div');
          tmpEl.className = "no-city";
          tmpEl.innerHTML = 'Город с таким названием не найден';
          citySelectRezult.append(tmpEl);

        } else { // вывожу результаты поиска

          // Ограничение количества выводимых результатов
          if (arr.length == 0) {
            let tmpEl = document.createElement('div');
            tmpEl.className = "no-city";
            tmpEl.innerHTML = 'Город с таким названием не найден';
            citySelectRezult.append(tmpEl);
          }

          // Ограничение количества выводимых результатов
          if (arr.length > 6) {
            arr.length = 6;
          }

          arr.forEach((item) => {
            let tmpEl = document.createElement('div');
            tmpEl.className = "city-item";
            let str = '<form class="form" action="/set-city" method="post">';
            str += '<input type="hidden" name="city_id" value="' + item.id + '">';
            str += '<input type="hidden" name="_token" value="' + token + '">';
            str += '<button type="submit" class="city-item-submit-btn">';
            str += '<span class="city-item__city">' + item.city + '</span>';
            str += '<span class="city-item__region">' + ' ' + item.region + '</span>';
            str += '</button>';
            tmpEl.innerHTML = str;
            citySelectRezult.append(tmpEl);
          });
        }
      }

      fetch('/ajax/city-select', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        cache: 'no-cache',
        body: 'city=' + encodeURIComponent(citySelectInput.value) + '&_token=' + encodeURIComponent(token),
      })
      .then((response) => response.json())
      .then((json) => {
        citySelect(json)
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
    // citySelectForm.reset();
    citySelectInput.value = '';
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

    /**
     * Функция обновления счетчиков товара в избранном
     * В хедере, в закрепленном меню, в мобильном меню
     * str строка
     * return false
     * @param {*} str 
     * @returns boolean
     */
    function favouritesCounterUpdate(str) {

      // Header favourites counter
      const headerFavouritesCounter = document.querySelector('#header-favourites-counter');
      headerFavouritesCounter.innerText = str;
      headerFavouritesCounter.classList.add('active');

      // Sticky desktop menu favourites counter
      const stickyDesktopMenuFavouritesCounter = document.querySelector('#sticky-desktop-menu-favourites-counter');
      stickyDesktopMenuFavouritesCounter.innerText = str;
      stickyDesktopMenuFavouritesCounter.classList.add('active');

      // Mobile favourites counter
      const mobileFavouritesCounter = document.querySelector('#mobile-favourites-counter');
      mobileFavouritesCounter.innerText = str;
      mobileFavouritesCounter.classList.add('active');

      return false;      
    }

    fetch('/ajax/addtofavourites', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      cache: 'no-cache',
      body: 'id=' + encodeURIComponent(elem.dataset.id) + '&_token=' + encodeURIComponent(token),
    })
    .then((response) => response.text())
    .then((text) => {
      favouritesCounterUpdate(text);
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
      selectCityBtns = document.querySelectorAll('.city-select-btn'),
      selectCityModal = document.querySelector('#select-city-modal'),
      callbackBtns = document.querySelectorAll('.js-callback-btn'),
      callbackModal = document.querySelector('#callback-modal'),
      testimonialsBtn = document.querySelector('.testimonials-btn'),
      testimonialsModal = document.querySelector('#testimonials-modal'),
      // payInfoBtn = document.querySelector('.dostavka-i-oplata .pay-info-btn'),
      modalCloseBtn = document.querySelectorAll('.modal-window .modal-close');

  selectCityBtns.forEach((item) => {
    item.onclick = function () {
      modalOpen(selectCityModal);
    }
  });
  
  callbackBtns.forEach((item) => {
    item.onclick = function () {
      modalOpen(callbackModal);
    }
  });

  if (testimonialsBtn) {
    testimonialsBtn.onclick = function () {
      modalOpen(testimonialsModal);
    }
  }

  // if (payInfoBtn) {
  //   payInfoBtn.onclick = function () {
  //     modalOpen(callbackModal);
  //   }
  // }

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

  /**
   * Function sort by price Catalog Akcii Novinki
   * Функция сортировки по цене в Каталог Акции Новинки
   */
  function sortByPrice() {
    const catalogSortForm = document.querySelector('#catalog-sort-form'),
          catalogSortSelect = document.querySelector('#catalog-sort-select')

    catalogSortSelect.addEventListener('change', () => { catalogSortForm.submit() }, false);

    return false;
  }


  /**
   * Функция инициализации slim select на элементе #catalog-sort-select
   * @returns boolean false
   */
  function slimSelectSort() {
    new SlimSelect({
      select: '#catalog-sort-select',
      showSearch: false,
      searchFocus: false,
    });
    return false;
  }

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

  // Отправка формы ajax в модальном окне
  const callbackModalForm = document.querySelector("#callback-modal-form"),
        callbackModalBtn = document.querySelector('.js-callback-modal-btn');

  function ajaxCallback(form) {

    let inputs = form.querySelectorAll('.input-field');
    let arr = [];

    let inputName = form.querySelector('.js-name-callback-modal');
    if (inputName.value.length < 3 || inputName.value.length > 20) {
      inputName.classList.add('required');
      arr.push(false);
    }

    let inputPhone = form.querySelector('.js-phone-callback-modal');
    if (inputPhone.value.length != 18) {
      inputPhone.classList.add('required');
      arr.push(false);
    }

    let inputEmail = form.querySelector('.js-email-callback-modal');
    if (inputName.value.length < 3 || inputName.value.length > 20) {
      inputEmail.classList.add('required');
      arr.push(false);
    }

    let inputCheckbox = form.querySelector('.js-checkbox-callback-modal');

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

  // Функция расчета общей стоимости товаров в корзине справа
  function asideCartTotalCalc() {

    const cartAsidePlaceOrderBtn = document.querySelector('#cart-aside-place-order-btn'),
          cartAsideProductsItems = document.querySelectorAll('.cart-aside-products .products-item'),
          cartAsidePlaceOrderSumm = document.querySelector('#cart-aside-place-order-btn-summ');

    let cartAsideTotal = 0;

    cartAsideProductsItems.forEach((item) => {
      const retailPrice = item.querySelector('.products-item__retail-price .products-item__value'),
            promoPrice = item.querySelector('.products-item__promo-price .products-item__value'),
            quantity = item.querySelector('.products-item__quantity');

      if (promoPrice) {
        cartAsideTotal += Number(promoPrice.innerText) * Number(quantity.innerText);
      } else {
        cartAsideTotal += Number(retailPrice.innerText) * Number(quantity.innerText);
      }
    });

    if (cartAsideProductsItems.length > 0) {
      cartAsidePlaceOrderBtn.classList.add('active');
    } 
    
    if (cartAsidePlaceOrderSumm) {
      cartAsidePlaceOrderSumm.innerText = cartAsideTotal;
    }

    return false;
  }

  asideCartTotalCalc();
  

  // Add to cart
  const addToCartBtns = document.querySelectorAll('.add-to-cart');

  function addToCart(elem) {

    // Add text
    elem.innerText = 'В корзине';

    /**
     * Функция обновления счетчиков товара в корзине
     * В хедере, в закрепленном меню, в мобильном меню
     * str строка
     * return false
     * @param {*} str 
     * @returns 
     */
    function cartCounterUpdate(arr) {

      // Header cart counter
      const headerCartCounter = document.querySelector('#header-cart-counter');
      headerCartCounter.innerText = arr.length > 9 ? 9 : arr.length;
      headerCartCounter.classList.add('active');
      
      // Sticky desktop menu cart counter
      const stickyDesktopMenuCartCounter = document.querySelector('#sticky-desktop-menu-cart-counter');
      stickyDesktopMenuCartCounter.innerText = arr.length > 9 ? 9 : arr.length;
      stickyDesktopMenuCartCounter.classList.add('active');

      // Mobile cart counter
      const mobileCartCounter = document.querySelector('#mobile-cart-counter');
      mobileCartCounter.innerText = arr.length > 9 ? 9 : arr.length;
      mobileCartCounter.classList.add('active');

      return false;
    }

    function asideCartItemsUpdate(arr) {
      // Обновляю товары в корзине справа
      let cartAsideProducts = document.querySelector('.cart-aside-products');

      // Очищаю все товары
      cartAsideProducts.innerHTML = '';

      // Формирую html из массива данных
      arr.forEach((item) => {
        let tmpEl = document.createElement('div');
        tmpEl.className = "products-item";
        let str = '<div class="products-item__image">';
        str += '<img src="/storage/uploads/products/' + item.image + '" alt="">';
        str += '</div>';
        str += '<div class="products-item__content">';
        str += '<div class="products-item__title">' + item.title + '</div>';
        str += '<div class="products-item-price-wrapper">';
        if (item.promo_price) {
          str += '<div class="products-item__price products-item__promo-price red-text">';
          str += '<span class="products-item__value">' + item.promo_price + '</span>';
          str += '<span class="products-item__currency">&#8381;</span>';
          str += '</div>';
          str += '<div class="products-item__old-price item__old-price">';
          str += '<span class="products-item__value">' + item.retail_price + '</span>';
          str += '<span class="products-item__currency">&#8381;</span>';
          str += '<span class="line-through"></span>';
          str += '</div>';
        } else {
          str += '<div class="products-item__price products-item__retail-price">';
          str += '<span class="products-item__value">' + item.retail_price + '</span>';
          str += '<span class="products-item__currency">&#8381;</span>';
          str += '<span class="line-through"></span>';
          str += '</div>';
        }
        str += '</div>';
        str += '</div>';
        str += '<div class="products-item__quantity">' + item.quantity + '</div>';
        str += '</div>';
        tmpEl.innerHTML = str;
        cartAsideProducts.append(tmpEl);
      });

      return false;
    }

    fetch('/ajax/addtocart', {
      method: 'POST',
      headers: {'Content-Type':'application/x-www-form-urlencoded'},
      cache: 'no-cache',
      body: 'id=' + encodeURIComponent(elem.dataset.id) + '&_token=' + encodeURIComponent(token),
    })
    .then((response) => response.json())
    .then((json) => {
      cartCounterUpdate(json);
      asideCartItemsUpdate(json);
      asideCartTotalCalc();
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


  /**
   * Расчет количества всех товаров в корзине
   * @param NodeList
   * @returns Boolean
   */
  function quantityCalc(cartItems) {

    const summaryQuantity = document.querySelectorAll('.js-summary-quantity');

    let quantitySumm = 0;

    cartItems.forEach((item) => {
      const itemQuantity = item.querySelector('.js-item-quantity');

      let itemQuantityValue = typeof itemQuantity.value !== 'undefined' ? itemQuantity.value : itemQuantity.innerText;

      itemQuantityValue = Number(itemQuantityValue);
      quantitySumm += itemQuantityValue;

    });
    
    summaryQuantity.forEach((item) => {
      item.innerText = quantitySumm;
    });

    return false;
  }

  /**
   * Расчет веса всех товаров
   * @param NodeList
   * @returns Number
   */
  function weightCalc(cartItems) {

    let totalWeight = 0;

    cartItems.forEach((item) => {
      const quantityNumber = item.querySelector('.js-item-quantity');
      let itemWeight = item.querySelector('.js-item-weight').innerText,
          summItemWeight = 0;

      let quantityNumberValue = typeof quantityNumber.value !== 'undefined' ? quantityNumber.value : quantityNumber.innerText;

      quantityNumberValue = Number(quantityNumberValue);
      summItemWeight = quantityNumberValue * Number(itemWeight);
      totalWeight += summItemWeight;
    });

    return totalWeight;
  }

  /**
   * Расчет скидки всех товаров
   * @param NodeList
   * @returns Boolean
   */
  function discountCalc(cartItems) {

    const summaryDiscount = document.querySelectorAll('.js-summary-discount');

    let totalDiscount = 0;

    cartItems.forEach((item) => {
      let oldPrice = item.querySelector('.js-item-old-price');
      if (oldPrice) {
        const quantityNumber = item.querySelector('.js-item-quantity');

        let price = item.querySelector('.js-item-price'),
            summItemDiscount = 0;

        let quantityNumberValue = typeof quantityNumber.value !== 'undefined' ? quantityNumber.value : quantityNumber.innerText;

        if (Number(oldPrice.innerText) > Number(price.innerText)) {
          summItemDiscount = Number(quantityNumberValue) * (Number(oldPrice.innerText) - Number(price.innerText));
          totalDiscount += summItemDiscount;
        }
      }
      
    });
    
    summaryDiscount.forEach((item) => {
      item.innerText = totalDiscount;
    });

    return false;
  }

  /**
   * Расчет суммы всех товаров
   * @param NodeList
   * @returns Number
   */
  function summCalc(cartItems) {

    const summarySumm = document.querySelectorAll('.js-summary-summ');

    let totalSumm = 0;

    cartItems.forEach((item) => {
      const quantityNumber = item.querySelector('.js-item-quantity');

      let itemPrice = item.querySelector('.js-item-price').innerText,
          summItemSumm = 0;

      let quantityNumberValue = typeof quantityNumber.value !== 'undefined' ? quantityNumber.value : quantityNumber.innerText;
        
      summItemSumm = Number(quantityNumberValue) * Number(itemPrice);
      totalSumm += summItemSumm;
    });

    summarySumm.forEach((item) => {
      item.innerText = totalSumm;
    });
    
    return totalSumm;
  }

  /**
   * Расчет суммы всех товаров со скидкой
   * @param NodeList
   * @returns Number
   */
  function summBeforeDiscountCalc(cartItems) {

    const summarySummBeforeDiscount = document.querySelectorAll('.js-summary-summ-before-discount');

    let totalSumm = 0;

    cartItems.forEach((item) => {
      const quantityNumber = item.querySelector('.js-item-quantity');

      let itemPrice = item.querySelector('.js-item-price').innerText,
          itemOldPrice = item.querySelector('.js-item-old-price'),
          summItemSumm = 0;

      let quantityNumberValue = typeof quantityNumber.value !== 'undefined' ? quantityNumber.value : quantityNumber.innerText;

      if (itemOldPrice) {
        itemOldPrice = itemOldPrice.innerText;
        summItemSumm = Number(quantityNumberValue) * Number(itemOldPrice);
      } else {
        summItemSumm = Number(quantityNumberValue) * Number(itemPrice);
      }
      
      totalSumm += summItemSumm;
    });

    summarySummBeforeDiscount.forEach((item) => {
      item.innerText = totalSumm;
    });

    return totalSumm;
  }


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

    // Добавление отзывов
    let testimonialForm = document.querySelector("#testimonial-form"),
        testimonialsBtn = document.querySelector('.js-testimonial-btn');

    testimonialsBtn.onclick = function() {
      ajaxTestimonials(testimonialForm);
    }

    function ajaxTestimonials(form) {

      let inputs = form.querySelectorAll('.input-field');
      let arr = [];

      let inputName = form.querySelector('#testimonial-name');
      if (inputName.value.length < 3 || inputName.value.length > 50 ) {
        inputName.classList.add('required');
        arr.push(false);
      }

      let inputText = form.querySelector('#testimonial-text');
      if (inputText.value.length < 3 || inputText.value.length > 1000 ) {
        inputText.classList.add('required');
        arr.push(false);
      }

      let inputCheckbox = form.querySelector('#checkbox-testimonial');
      if (!inputCheckbox.checked) {
        arr.push(false);
      }

      if (arr.length == 0) {
        for (let i = 0; i < inputs.length; i++) {
          inputs[i].classList.remove('required');
        }
        
        fetch('/ajax/testimonial', {
          method: 'POST',
          cache: 'no-cache',
          body: new FormData(form)
        })
        .then((response) => response.json())
        .then((json) => {
          // Если в объекте есть ключ message, то не найдено
          if (typeof json.message !== "undefined") {
            alert("Ошибка");
          } else {
            alert("Спасибо за отзыв.");
          }
        })
        .catch((error) => {
          console.log(error);
        })

        form.reset();
      }
    }
    
  }

  if (cartPage) {

    /**
     * Минимальный заказ зеленая полоса
     * @param NodeList
     * @returns boolean
     */
    function minOrderCalc(totalSumm) {

      // Сумма минимального заказа
      const minOrderLimit = 1500;

      // Текст суммы минимального заказа
      document.querySelector('#min-order-value').innerText = minOrderLimit;

      // Остаток до минимальной суммы
      const minOrderCounter = document.querySelector('.min-order-counter');

      // Кнопка Перейти к оформлению
      const placeOrderBtns = document.querySelectorAll('.js-place-order-btn');
      
      if (totalSumm <= minOrderLimit) {
        minOrderCounter.innerText = (minOrderLimit - totalSumm).toLocaleString('ru');
      } else {
        minOrderCounter.innerText = 0;
      }

      // Зеленая полоса
      const minOrderGreenLine = document.querySelector('.min-order-green-line');
      
      if (totalSumm <= minOrderLimit) {
        minOrderGreenLine.style.width = totalSumm * 100 / minOrderLimit + '%';
      } else {
        minOrderGreenLine.style.width = '100%';
      }

      // Переход к оформлению если сумма более minOrderLimit
      if (totalSumm >= minOrderLimit) {
        placeOrderBtns.forEach((item) => {
          item.classList.add('active');
          item.querySelector('.place-order-btn__link').href = '/create-order';
        });
      } else {
        placeOrderBtns.forEach((item) => {
          item.classList.remove('active');
          item.querySelector('.place-order-btn__link').href = '#';
        });
      }

      return false;
    }

    const cartItems = document.querySelectorAll('.cf-item');

    quantityCalc(cartItems);
    weightCalc(cartItems);
    discountCalc(cartItems);
    summCalc(cartItems);
    summBeforeDiscountCalc(cartItems);
    minOrderCalc(summCalc(cartItems));

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
          quantityNumber = item.querySelector('.js-item-quantity');

      // Расчет товар +1
      quantityPlus.onclick = function() {

        // Ограничение на увеличение количества если больше max
        if (Number(quantityNumber.value) >= Number(quantityNumber.max)) {
          return false;
        }

        quantityNumber.stepUp();
        ajax_plus_cart(this);

        quantityCalc(cartItems);
        weightCalc(cartItems);
        discountCalc(cartItems);
        summCalc(cartItems);
        minOrderCalc(summBeforeDiscountCalc(cartItems));

      }

      // Расчет товар -1
      quantityMinus.onclick = function() {

        // Ограничение на уменьшение количества если меньше 1
        if (Number(quantityNumber.value) == 1) {
          return false;
        }

        quantityNumber.stepDown();
        ajax_minus_cart(this);

        quantityCalc(cartItems);
        weightCalc(cartItems);
        discountCalc(cartItems);
        summCalc(cartItems);
        minOrderCalc(summBeforeDiscountCalc(cartItems));

      }

    });

  }

  if(createOrderPage) {

    const productItems = document.querySelectorAll('.product-item');

    quantityCalc(productItems);
    let weight = weightCalc(productItems);
    discountCalc(productItems);
    let summ = summCalc(productItems);
    summBeforeDiscountCalc(productItems);

    sdekDelivery();
    russianPostDelivery();

    // Стоимость доставки СДЕК
    function sdekDelivery() {

      function setSdekDeliverySumm(str) {
        let sdekDeliverySumm = document.querySelector('#sdek-delivery-summ');
        sdekDeliverySumm.innerText = str;
        return false;
      }

      fetch('/ajax/sdek', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        cache: 'no-cache',
        body: '&_token=' + encodeURIComponent(token)
      })
      .then((response) => response.text())
      .then((text) => {
        setSdekDeliverySumm(text);
      })
      .catch((error) => {
        console.log(error);
      })

      return false;
    }

    // Стоимость доставки Почта Росии
    function russianPostDelivery() {

      function setRussianPostDeliverySumm(str) {
        let russianPostDeliverySumm = document.querySelector('#russian-post-delivery-summ');
        russianPostDeliverySumm.innerText = str;
        return false;
      }

      fetch('/ajax/russian-post', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        cache: 'no-cache',
        body: '&_token=' + encodeURIComponent(token)
      })
      .then((response) => response.text())
      .then((text) => {
        setRussianPostDeliverySumm(text);
      })
      .catch((error) => {
        console.log(error);
      })

      return false;
    }

    // Скрытое поле Сумма
    document.querySelector('#hidden-input-summ').value = summ;

    // Проверка обязательных полей
    const placeOrderForm = document.querySelector('#place-order-form'),
          placeOrderBtn = document.querySelector('#place-order-btn');

    function checkRequiredFields(form) {

      let inputFirstName = form.querySelector('#first-name');
      if (inputFirstName.value.length < 3 || inputFirstName.value.length > 20) {
        inputFirstName.classList.add('required');
      } else {
        inputFirstName.classList.remove('required');
      }

      let inputLastName = form.querySelector('#last-name');
      if (inputLastName.value.length < 3 || inputLastName.value.length > 30) {
        inputLastName.classList.add('required');
      } else {
        inputLastName.classList.remove('required');
      }

      let inputPhone = form.querySelector('#phone');
      if (inputPhone.value.length != 18) {
        inputPhone.classList.add('required');
      } else {
        inputPhone.classList.remove('required');
      }

      let inputEmail = form.querySelector('#email');
      if (inputEmail.value.length < 5 || inputEmail.value.length > 50) {
        inputEmail.classList.add('required');
      } else {
        inputEmail.classList.remove('required');
      }

      return false;
    }

    placeOrderBtn.onclick = function() {
      checkRequiredFields(placeOrderForm);
    }

  }


  if (catalogPage) {
    slimSelectSort();
    sortByPrice();
  }

  if (akciiPage) {
    slimSelectSort();
    sortByPrice();
  }

  if (novinkiPage) {
    slimSelectSort();
    sortByPrice();
  }

  if (okompaniiPage) {

    // Отправка формы ajax
    const feedbackForm = document.querySelector("#feedback-form"),
          feedbackBtn = document.querySelector('.js-feedback-btn');

    feedbackBtn.onclick = function() {
      ajaxCallback(feedbackForm);
    }    

  }

});