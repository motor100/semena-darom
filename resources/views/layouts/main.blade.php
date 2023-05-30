<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="Семена, овощи, цветы, удобрения, агрохимия, садовый инвентарь">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('robots')
  <link rel="shortcut icon" href="{{ asset('/img/favicon.svg') }}" type="image/x-icon">
  <link rel="stylesheet" href="{{ asset('/css/bootstrap-grid.min.css') }}">
  @yield('style')
  <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
  <title>@yield('title', config('app.name') )</title>
</head>

<body>
  <header class="header">
    <div class="header-top">
      <div class="container-fluid">
        <div class="flex-container">
          <div class="side">
            <div class="logo">
              <a href="{{ route('home') }}">
                <img src="/img/logo.png" alt="">
              </a>
            </div>
            <div class="catalog-btn">
              <div class="catalog-btn__burger">
                <span></span>
              </div>
              <div class="catalog-btn__text">Каталог</div>
            </div>
            <form class="search-form" action="/poisk" method="get">
              <div class="form-container">
                <input type="text" name="q" class="search-input" minlength="3" maxlength="20" autocomplete="off" required placeholder="Искать товары">
                @csrf
                <button type="submit" class="submit-btn">
                  <img src="/img/header-search-btn.svg" alt="">
                </button>
                <div class="search-close"></div>
                <div class="search-dropdown">
                  <ul class="search-list js-search-rezult"></ul>
                  <a href="#" class="search-see-all">Показать все результаты</a>
                </div>
              </div>
            </form>
          </div>
          <div class="side">
            <div class="city-select">
              <div class="city-select__image">
                <img src="/img/header-geolocation.svg" alt="">
              </div>
              <div class="city-select__text">Выбрать город</div>
            </div>
            <div class="right-menu">
              <div class="favorites right-menu-item">
                <div class="right-menu-item__image">
                  <img src="/img/header-heart.svg" alt="">
                </div>
                @if(isset($favorites_count))
                  <div id="header-favorites-counter" class="counter">{{ $favorites_count }}</div>
                @else
                  <div id="header-favorites-counter" class="counter hidden"></div>
                @endif
                <div class="right-menu-item__text">Избранное</div>
                <a href="/favorites" class="full-link"></a>
              </div>
              <div class="cart right-menu-item">
                <div class="right-menu-item__image">
                  <img src="/img/header-cart.svg" alt="">
                </div>
                @if(isset($cart_count))
                  <div id="header-cart-counter" class="counter">{{ $cart_count }}</div>
                @else
                  <div id="header-cart-counter" class="counter hidden"></div>
                @endif
                <div class="right-menu-item__text">Корзина</div>
                <a href="/cart" class="full-link"></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="advantages">
      <div class="container-fluid">
        <div class="advantages-flex-container">
          <div class="advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-russian-post.png" alt="">
            </div>
            <div class="advantages-item__text">Почта РФ</div>
          </div>
          <div class="advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-sdek.png" alt="">
            </div>
            <div class="advantages-item__text">CDEK курьер</div>
          </div>
          <div class="advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-fire.png" alt="">
            </div>
            <div class="advantages-item__text">Онлайн-оплата</div>
          </div>
          <div class="advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-percent.png" alt="">
            </div>
            <div class="advantages-item__text">Наложенный платеж</div>
          </div>
          <div class="advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-percent.png" alt="">
            </div>
            <div class="advantages-item__text">Минимальная сумма заказа 1 500 ₽</div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="top-menu">
        <ul class="menu">
          <li class="menu-item">
            <a href="/o-kompanii">О компании</a>
          </li>
          <li class="menu-item">
            <a href="/dostavka-i-oplata">Доставка и оплата</a>
          </li>
          <li class="menu-item">
            <a href="/otzyvy">Отзывы</a>
          </li>
          <li class="menu-item">
            <a href="/kontakty">Контакты</a>
          </li>
          <li class="menu-item">
            <a href="/catalog">Каталог</a>
          </li>
        </ul>
      </div>
    </div>
  </header>

  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xxl-2 col-md-2">
          <div class="aside-nav">
            <div class="aside-nav-title">Каталог товаров</div>
            <div class="aside-nav-item">
              <div class="aside-nav-item__image">
                <img src="{{ asset('img/percent-icon.png') }}" alt="">
              </div>
              <div class="aside-nav-item__title">Акции</div>
            </div>
            <div class="aside-nav-item">
              <div class="aside-nav-item__image">
                <img src="{{ asset('img/package-icon.png') }}" alt="">
              </div>
              <div class="aside-nav-item__title">Новинки</div>
            </div>
            @foreach($parent_category as $cat)
              @if($cat->count_children > 0)
                @foreach($cat->child_category as $ct)
                  <div class="aside-nav-item">
                    <div class="aside-nav-item__image">
                      <img src="{{ asset('storage/uploads/categories/' . $ct->image) }}" alt="">
                    </div>
                    <div class="aside-nav-item__title">{{ $ct->title }}</div>
                  </div>
                @endforeach
              @else
                <div class="aside-nav-item">
                  <div class="aside-nav-item__image">
                    <img src="{{ asset('storage/uploads/categories/' . $cat->image) }}" alt="">
                  </div>
                  <div class="aside-nav-item__title">{{ $cat->title }}</div>
                </div>
              @endif
            @endforeach
          </div>
        </div>
        <div class="col-xxl-7 col-md-10">
          @yield('content')
        </div>
        <!-- <div class="col-xxl-3 d-none d-xxl-block">Корзина</div> -->
        
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="logo-wrapper">
      <div class="container-fluid">
        <div class="logo">
          <img src="{{ asset('img/logo.png') }}" alt="">
        </div>
      </div>
    </div>
    <div class="bottom-menu">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-2">
            <div class="menu-title">Покупателям</div>
            <ul class="menu">
              <li class="menu-item">
                <a href="/dostavka-i-oplata" class="menu-item__link">Оплата и доставка</a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-item__link">О сервисе</a>
              </li>
              <li class="menu-item">
                <a href="/otzyvy" class="menu-item__link">Отзывы</a>
              </li>
              <li class="menu-item">
                <a href="/kak-zakazat" class="menu-item__link">Как заказать</a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-item__link">Личный кабинет</a>
              </li>
            </ul>
          </div>
          <div class="col-md-2">
            <div class="menu-title">Продавцам</div>
            <ul class="menu">
              <li class="menu-item">
                <a href="#" class="menu-item__link">Личный кабинет продавца</a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-item__link">Документация для партнеров</a>
              </li>
            </ul>
          </div>
          <div class="col-md-2">
            <div class="menu-title">Сотрудничество</div>
            <ul class="menu">
              <li class="menu-item">
                <a href="#" class="menu-item__link">Новости компании</a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-item__link">Партнерская программа</a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-item__link">Производителям</a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-item__link">Пункт выдачи заказов</a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-item__link">Вакансии</a>
              </li>
            </ul>
          </div>
          <div class="col-md-2">
            <div class="menu-title">Правовая информация</div>
            <ul class="menu">
              <li class="menu-item">
                <a href="/garantiya-vozvrata-denezhnyh-sredstv" class="menu-item__link">Гарантия возврата денежных средств</a>
              </li>
              <li class="menu-item">
                <a href="/politika-konfidencialnosti" class="menu-item__link">Политика конфиденциальности</a>
              </li>
              <li class="menu-item">
                <a href="/polzovatelskoe-soglashenie-s-publichnoj-ofertoj" class="menu-item__link">Пользовательское соглашение с публичной офертой</a>
              </li>
            </ul>
          </div>
          <div class="col-md-2">
            <div class="menu-title">О интернет-магазине</div>
            <ul class="menu">
              <li class="menu-item">
                <a href="/o-kompanii" class="menu-item__link">О компании</a>
              </li>
              <li class="menu-item">
                <a href="/kontakty" class="menu-item__link">Контакты</a>
              </li>
            </ul>
            <div class="social">
              <a href="https://vk.com/semena7" target="_blank">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect width="30" height="30" rx="5"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M25.1257 9.13542C25.2833 8.63604 25.1257 8.27302 24.4284 8.27302H22.11C21.5252 8.27302 21.2551 8.59089 21.0975 8.93089C21.0975 8.93089 19.9049 11.8351 18.2394 13.7179C17.6993 14.2624 17.4518 14.4439 17.1592 14.4439C17.0016 14.4439 16.7988 14.2624 16.7988 13.7635V9.11195C16.7988 8.52227 16.6191 8.25 16.1237 8.25H12.4775C12.1172 8.25 11.8923 8.52227 11.8923 8.79453C11.8923 9.36164 12.725 9.49799 12.8149 11.086V14.5365C12.8149 15.2851 12.6821 15.4219 12.3872 15.4219C11.5996 15.4219 9.68671 12.4951 8.53921 9.16021C8.31608 8.49969 8.08941 8.25 7.50415 8.25H5.16355C4.48842 8.25 4.37598 8.56742 4.37598 8.90786C4.37598 9.52057 5.16355 12.6058 8.04426 16.6893C9.9572 19.4784 12.6803 20.9774 15.1333 20.9774C16.6191 20.9774 16.7988 20.637 16.7988 20.0699V17.9599C16.7988 17.2795 16.9338 17.1661 17.4067 17.1661C17.744 17.1661 18.3518 17.3472 19.7247 18.686C21.2998 20.274 21.5699 21 22.4478 21H24.7658C25.4409 21 25.7561 20.6596 25.576 20.0017C25.3736 19.3438 24.6082 18.3911 23.6179 17.2569C23.0777 16.6221 22.2676 15.9186 22.0201 15.5782C21.6828 15.1244 21.7726 14.9429 22.0201 14.5347C21.9975 14.5347 24.8335 10.4963 25.1257 9.13365"/>
                </svg>
              </a>
            </div>
          </div>
          <div class="col-md-2">
            <div class="menu-title">Есть вопросы?</div>
            <div class="last-menu">
              <div class="menu-item phone">тел.: +7 (902) 614 09 67</div>
              <div class="menu-item callback-btn js-callback-btn">заказать обратный звонок</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-row">
      <div class="container-fluid">
        <div class="flex-container">
          <div class="author">@ Семена Даром, @php echo date("Y") @endphp</div>
          <div class="author">
            <a href="https://mybutton.ru/" class="author-name" target="_blank">Поддержка Button</a>
          </div>
          <div class="author">
            <a href="https://nhfuture.ru/" class="author-name" target="_blank">Дизайн Andrewwebnh</a>
          </div>
        </div>
      </div>
    </div>
  </footer>


  <!-- temp -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">
        <div class="cart-aside">
          <div class="cart-aside-title-wrapper">
            <div class="cart-aside-title">Корзина</div>
            <div class="cart-aside-clear-cart">очистить</div>
          </div>
          <div class="cart-aside-products">
            <div class="products-item">
              <div class="products-item__image">
                <img src="/img/cart-aside-image.jpg" alt="">
              </div>
              <div class="products-item__content">
                <div class="products-item__title">Огурцы</div>
                <div class="products-item__price light-green-text">34 ₽</div>
              </div>
            </div>
            <div class="products-item">
              <div class="products-item__image">
                <img src="/img/cart-aside-image.jpg" alt="">
              </div>
              <div class="products-item__content">
                <div class="products-item__title">Капуста СОНЬКИНА ЛЮБОВЬ F1</div>
                <div class="products-item-price-wrapper">
                  <!-- @ if(->promo_price) -->
                    <div class="products-item__price products-item__promo-price red-text">
                      <span class="products-item__value">46</span>
                      <span class="products-item__currency">&#8381;</span>
                    </div>
                    <div class="products-item__old-price">
                      <span class="products-item__value">48</span>
                      <span class="products-item__currency">&#8381;</span>
                      <span class="line-through"></span>
                    </div>
                  <!-- @ else -->
                    <!-- <div class="products-item__price">34 ₽</div> -->
                  <!-- @ endif -->
                </div>
              </div>
            </div>
            <div class="products-item">
              <div class="products-item__image">
                <img src="/img/cart-aside-image.jpg" alt="">
              </div>
              <div class="products-item__content">
                <div class="products-item__title">Перец сладкий Геракл</div>
                <div class="products-item__price light-green-text">34 ₽</div>
              </div>
            </div>
          </div>
          <div class="grey-line"></div>
          <div class="place-order-btn">
            <div class="place-order-btn__text">Оформить заказ</div>
            <div class="place-order-btn__total">
              <span class="place-order-btn__summ">1 378</span>
              <span class="place-order-btn__currency">&#8381;</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- temp -->



  <div class="burger-menu-wrapper hidden-desktop">
    <div class="burger-menu"></div>
  </div>
  <div class="mobile-menu hidden-desktop">
    <div class="city-select js-mobile-menu-city-btn">
      <span class="city-text">Город:&nbsp;</span>
      <span class="city-name">
        
      </span>
    </div>
    <ul class="menu">
      <li class="menu-item">
        <a href="{{ route('home') }}">Главная</a>
      </li>
      <li class="menu-item">
        <a href="/catalog">Каталог</a>
      </li>
      <li class="menu-item">
        <a href="/o-kompanii">О компании</a>
      </li>
      <li class="menu-item">
        <a href="/dostavka-i-oplata">Доставка и оплата</a>
      </li>
      <li class="menu-item">
        <a href="/novosti">Новости</a>
      </li>
      <li class="menu-item">
        <a href="/otzyvy">Отзывы</a>
      </li>
      <li class="menu-item">
        <a href="/kontakty">Контакты</a>
      </li>
    </ul>
  </div>

  <div id="callback-modal" class="modal-window callback-modal">
    <div class="modal-wrapper">
      <div class="modal-area">
        <div class="modal-close">
          <div class="close"></div>
        </div>
        <div class="modal-title">Введите свое имя <br>и номер телефона</div>
        <form id="callback-modal-form" class="form" method="post">
          @csrf
          <label class="label">
            <input type="text" id="name-callback-modal" class="input-field" name="name" required minlength="3" maxlength="20" placeholder="Ваше имя">
          </label>
          <label class="label">
            <input type="text" id="phone-callback-modal" class="input-field js-input-phone-mask" name="phone" required maxlength="18" placeholder="+7 (999) 999 99 99">
          </label>
          <input type="checkbox" name="checkbox" class="custom-checkbox" id="checkbox-callback-modal" checked required onchange="document.querySelector('.js-callback-modal-btn').disabled = !this.checked;">
          <label for="checkbox-callback-modal" class="custom-checkbox-label"></label>
          <span class="checkbox-text">Согласен с <a href="/politika-konfidencialnosti" class="privacy-policy-btn" target="_blank">политикой обработки персональных данных</a></span>
          
          <input type="button" class="submit-btn js-callback-modal-btn" value="Заказать звонок">
        </form>
      </div>
    </div>
  </div>

  <div id="select-city-modal" class="modal-window select-city-modal">
    <div class="modal-wrapper">
      <div class="modal-area">
        <div class="modal-close">
          <div class="close"></div>
        </div>
        <div class="modal-title">Ваш город</div>
        <div class="city-select">

        </div>
      </div>
    </div>
  </div>

  <div class="header-catalog-dropdown">
    <div class="catalog-nav">
      <div class="aside-nav">
        <div class="aside-nav-item">
          <div class="aside-nav-item__image">
            <img src="{{ asset('img/percent-icon.png') }}" alt="">
          </div>
          <div class="aside-nav-item__title">Акции</div>
        </div>
        <div class="aside-nav-item">
          <div class="aside-nav-item__image">
            <img src="{{ asset('img/package-icon.png') }}" alt="">
          </div>
          <div class="aside-nav-item__title">Новинки</div>
        </div>
        @foreach($parent_category as $cat)
          @if($cat->count_children > 0)
            @foreach($cat->child_category as $ct)
              <div class="aside-nav-item">
                <div class="aside-nav-item__image">
                  <img src="{{ asset('storage/uploads/categories/' . $ct->image) }}" alt="">
                </div>
                <div class="aside-nav-item__title">{{ $ct->title }}</div>
              </div>
            @endforeach
          @else
            <div class="aside-nav-item">
              <div class="aside-nav-item__image">
                <img src="{{ asset('storage/uploads/categories/' . $cat->image) }}" alt="">
              </div>
              <div class="aside-nav-item__title">{{ $cat->title }}</div>
            </div>
          @endif
        @endforeach
      </div>
      <div class="promo">Новинки</div>
    </div>
    <div class="dark-background"></div>
  </div>

<!-- 
  <div id="testimonials-modal" class="modal-window testimonials-modal">
    <div class="modal-wrapper">
      <div class="modal-area">
        <div class="modal-close">
          <div class="close"></div>
        </div>
        <div class="modal-title">Оставьте свой отзыв</div>
        <form id="testimonials-modal-form" class="form" method="post">
          @csrf
          <label class="label">
            <input type="text" id="testimonials-name" class="input-field" name="name" required minlength="3" maxlength="20" placeholder="Ваше имя">
          </label>
          <label class="label">
            <input type="text" id="testimonials-city" class="input-field" name="city" required minlength="3" maxlength="30" placeholder="Ваш город">
          </label>
          <label class="label">
            <textarea id="testimonials-text" class="input-field" name="text" rows="5" required minlength="3" maxlength="300" placeholder="Напишите отзыв"></textarea>
          </label>
          <input type="checkbox" name="checkbox" class="custom-checkbox" id="checkbox-testimonials-modal" checked required onchange="document.querySelector('.js-testimonials-modal-btn').disabled = !this.checked;">
          <label for="checkbox-testimonials-modal" class="custom-checkbox-label"></label>
          <span class="checkbox-text">Согласен с <a href="/politika-konfidencialnosti" class="privacy-policy-btn" target="_blank">политикой обработки персональных данных</a></span>
          
          <input type="button" class="submit-btn js-testimonials-modal-btn" value="Отправить">
        </form>
      </div>
    </div>
  </div>
 -->

  @if(empty($_COOKIE['we-use-cookie']))
    <div class="messages-cookies">
      <div class="container-fluid">
        <div class="messages-cookies-wrapper">
          <div class="messages-cookies-text">Этот сайт использует файлы cookies и сервисы сбора технических данных посетителей. Продолжая использовать наш сайт, вы автоматически соглашаетесь с использованием cookies. Нажмите "ОК" чтобы закрыть это сообщение.</div>
          <button class="messages-cookies-close">ОК</button>
        </div>
      </div>
    </div>
  @endif

  <div class="fixed-bottom-menu hidden-desktop">
    <div class="menu-wrapper">
      <div class="menu-item">
        <div class="title">Каталог</div>
        <a href="/catalog" class="full-link"></a>
      </div>
      <div class="menu-item cart-menu-item">
        <div class="title">Корзина</div>
        @if(isset($cart_count))
          <div id="mobile-cart-counter" class="cart-counter">{{ $cart_count }}</div>
        @else
          <div id="mobile-cart-counter" class="cart-counter hidden"></div>
        @endif
        <a href="/cart" class="full-link"></a>
      </div>
      <div class="menu-item">
        <div class="title">Звонок</div>
        <a href="tel:+78587546585" class="full-link"></a>
      </div>
    </div>
  </div>

  @if(Auth::check())
    <div class="top-line-is-login">
      <div class="container-fluid">
        <div class="text-wrapper">
          <div class="top-line__text dashboard">
            <a href="/admin">Панель управления</a>
          </div>
          <div class="top-line__text logout">
            <form class="form" action="{{ route('logout') }}" method="POST">
              @csrf
              <button class="logout-btn" type="submit">Выйти</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif

  @yield('script')
  <!-- jivosite -->
  <!-- <script src="//code-ya.jivosite.com/widget/K7CaDjczmW" async></script> -->
  <script src="{{ asset('/js/imask.min.js') }}"></script>
  <script src="{{ asset('/js/main.js') }}"></script>
  
</body>
</html>
