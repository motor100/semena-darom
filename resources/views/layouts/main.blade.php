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
  <!-- <link rel="shortcut icon" href="{{ asset('/img/favicon.svg') }}" type="image/x-icon"> -->
  <link rel="stylesheet" href="{{ asset('/css/bootstrap-grid.min.css') }}">
  @yield('style')
  <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
  <title>@yield('title', config('app.name') )</title>
</head>

<body>
  <header class="header">
    <div class="container">
      <p>Header</p>
      <div class="logo">
        <a href="{{ route('home') }}">
          <img src="" alt="">
        </a>
      </div>
    </div>
  </header>

  <div class="content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-md-2">
          <div class="catalog-nav">Каталог</div>
        </div>
        <div class="col-md-10">
          @yield('content')
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="container">
      <p>Footer</p>
      <div class="item"><?= date("Y"); ?></div>
      <div class="author">
        <span class="author-text">Дизайн&nbsp;</span>
        <a href="https://nhfuture.ru/" class="author-name" target="_blank">Andrewwebnh</a>
      </div>
      <div class="author">
        <span class="author-text">Поддержка&nbsp;</span>
        <a href="https://mybutton.ru/" class="author-name" target="_blank">Button</a>
      </div>

      <div class="temp">
        <p>Окно работает. Без imask</p>
        <div class="js-callback-btn">Открыть окно</div>
      </div>

    </div>
  </footer>

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

  <?php // if (empty($_COOKIE['we-use-cookie'])): ?>
  @if(empty($_COOKIE['we-use-cookie']))
    <div class="messages-cookies">
      <div class="container">
        <div class="messages-cookies-wrapper">
          <div class="messages-cookies-text">Этот сайт использует файлы cookies и сервисы сбора технических данных посетителей. Продолжая использовать наш сайт, вы автоматически соглашаетесь с использованием cookies. Нажмите "ОК" чтобы закрыть это сообщение.</div>
          <button class="messages-cookies-close">ОК</button>
        </div>
      </div>
    </div>
  @endif
  <?php //endif; ?>

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
            <form class="form" action="{{ route('admin.logout') }}" method="POST">
              @csrf
              <button class="logout-btn" type="submit">Выйти</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endif

  @yield('script')
  <script src="{{ asset('/js/main.js') }}"></script>
  <!-- <script src="{{ asset('/js/main.js') }}"></script> -->
  
</body>
</html>
