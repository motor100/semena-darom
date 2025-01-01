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
  @vite(['resources/sass/main.scss'])
  <title>@yield('title', config('app.name') )</title>
</head>

<body>
  <header class="header">
    <div class="header-top">
      <div class="container-fluid">
        <div class="flex-container">
          <div class="left-nav">
            <div class="logo">
              <a href="{{ route('home') }}">
                <img src="/img/logo.svg" alt="">
              </a>
            </div>
            <!-- <div class="header-catalog-btn hidden-mobile">
              <div class="catalog-btn__burger">
                <span></span>
              </div>
              <div class="catalog-btn__text">Каталог</div>
            </div> -->
            <a href="/catalog" class="header-catalog-btn hidden-mobile">
              <span class="catalog-btn__burger">
                <span></span>
              </span>
              <span class="catalog-btn__text">Каталог</span>
            </a>
            <form class="search-form" action="/poisk" method="get">
              <input type="text" name="search_query" class="search-input" minlength="3" maxlength="50" autocomplete="off" required placeholder="Искать товары">
              <button type="submit" class="submit-btn">
                <img src="/img/header-search-btn.svg" alt="">
              </button>
              <div class="search-close"></div>
              <div class="search-dropdown">
                <ul class="search-list js-search-rezult"></ul>
                <a href="#" class="search-see-all">Показать все результаты</a>
              </div>
            </form>
          </div>

          <div class="city-select city-select-btn header-btn {{ $city_name ? 'active' : '' }} hidden-mobile">
            <div class="city-select__image header-btn__image">
              <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.50039 10.1538C8.93633 10.1538 10.1004 8.98289 10.1004 7.53845C10.1004 6.09401 8.93633 4.92307 7.50039 4.92307C6.06445 4.92307 4.90039 6.09401 4.90039 7.53845C4.90039 8.98289 6.06445 10.1538 7.50039 10.1538Z" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M14 7.53846C14 13.4231 7.5 18 7.5 18C7.5 18 1 13.4231 1 7.53846C1 5.80435 1.68482 4.14127 2.90381 2.91507C4.12279 1.68887 5.77609 1 7.5 1C9.22391 1 10.8772 1.68887 12.0962 2.91507C13.3152 4.14127 14 5.80435 14 7.53846Z" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <div class="city-select__text header-btn__text">
              <span class="widescreen">{{ $city_name ? $city_name : 'Выбрать город' }}</span>
              <span class="standartscreen">{{ $city_name ? $city_name : 'Город' }}</span>
            </div>
          </div>

          <!-- 
          <div class="lk-login header-btn {{ auth()->check() ? 'active' : '' }} hidden-mobile">
            <div class="lk-login-select__image header-btn__image">
              <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.49988 8.5C9.57095 8.5 11.2499 6.82107 11.2499 4.75C11.2499 2.67893 9.57095 1 7.49988 1C5.42881 1 3.74988 2.67893 3.74988 4.75C3.74988 6.82107 5.42881 8.5 7.49988 8.5Z"/>
                <path d="M11.25 9.99991H11.5138C12.6484 9.99991 13.6056 10.8449 13.7464 11.9708L14.0392 14.3138C14.1511 15.2091 13.453 15.9999 12.5508 15.9999H2.44916C1.54692 15.9999 0.84884 15.2091 0.960748 14.3138L1.25362 11.9708C1.39437 10.8449 2.35153 9.99991 3.48625 9.99991H3.74999" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <div class="lk-login-select__text header-btn__text">
              <span class="widescreen">Личный кабинет</span>
              <span class="standartscreen">Войти</span>
            </div>
            <a href="/lk" class="full-link header-btn__link"></a>
          </div>
           -->

          <div class="right-nav hidden-mobile">
            <div class="favourites right-nav-item">
              <div class="right-nav-item__image">
                <img src="/img/header-heart.svg" alt="">
              </div>
              <div id="header-favourites-counter" class="counter {{ isset($favourites_count) ? 'active' : '' }}">{{ isset($favourites_count) ? $favourites_count : '' }}</div>
              <div class="right-nav-item__text">Избранное</div>
              <a href="/favourites" class="full-link"></a>
            </div>
            <div class="cart right-nav-item">
              <div class="right-nav-item__image">
                <img src="/img/header-cart.svg" alt="">
              </div>
              <div id="header-cart-counter" class="counter {{ isset($cart_count) ? 'active' : '' }}">{{ isset($cart_count) ? $cart_count : '' }}</div>
              <div class="right-nav-item__text">Корзина</div>
              <a href="/cart" class="full-link"></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="top-menu hidden-mobile">
      <div class="container-fluid">
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
        </ul>
      </div>
    </div>
    
    <div class="advantages">
      <div class="advantages-desktop hidden-mobile">
        <div class="advantages-item">
          <div class="advantages-item__image">
            <img src="/img/header-russian-post.png" alt="">
          </div>
          <div class="advantages-item__text">Почта РФ</div>
        </div>
        <div class="advantages-item">
          <div class="advantages-item__image">
            <img src="/img/header-cdek.png" alt="">
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
            <img src="/img/header-cart-min-order.png" alt="">
          </div>
          <div class="advantages-item__text">Минимальная сумма заказа 1 500 ₽</div>
        </div>
      </div>
      <div class="advantages-slider swiper hidden-desktop">
        <div class="swiper-wrapper">
          <div class="swiper-slide advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-russian-post.png" alt="">
            </div>
            <div class="advantages-item__text">Почта РФ</div>
          </div>
          <div class="swiper-slide advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-cdek.png" alt="">
            </div>
            <div class="advantages-item__text">CDEK курьер</div>
          </div>
          <div class="swiper-slide advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-fire.png" alt="">
            </div>
            <div class="advantages-item__text">Онлайн-оплата</div>
          </div>
          <div class="swiper-slide advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-percent.png" alt="">
            </div>
            <div class="advantages-item__text">Наложенный платеж</div>
          </div>
          <div class="swiper-slide advantages-item">
            <div class="advantages-item__image">
              <img src="/img/header-cart-min-order.png" alt="">
            </div>
            <div class="advantages-item__text">Минимальная сумма заказа 1 500 ₽</div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-2 d-none d-lg-block">
          <div class="aside-nav">
            <div class="aside-nav-title">Каталог товаров</div>
            <div class="aside-nav-item">
              <div class="aside-nav-item__image">
                <img src="{{ asset('img/percent-icon.svg') }}" alt="">
              </div>
              <div class="aside-nav-item__title">Акции</div>
              <a href="/akcii" class="full-link"></a>
            </div>
            <div class="aside-nav-item">
              <div class="aside-nav-item__image">
                <img src="{{ asset('img/package-icon.svg') }}" alt="">
              </div>
              <div class="aside-nav-item__title">Новинки</div>
              <a href="/novinki" class="full-link"></a>
            </div>
            @foreach($parent_categories as $cat)
                <div class="catalog-nav-item {{ (isset($category) && $category->parent == $cat->id) ? 'active' : '' }}">
                @if($cat->child_category)
                  <div class="aside-nav-item aside-nav-item-has-children">
                    <div class="aside-nav-item__image">
                      <img src="{{ Storage::url($cat->image) }}" alt="">
                    </div>
                    <div class="aside-nav-item__title">{{ $cat->title }}</div>
                  </div>
                  <div class="aside-nav-arrow"></div>
                  <div class="aside-nav-submenu">
                    @foreach($cat->child_category as $cct)
                      <div class="aside-nav-submenu-item {{ (isset($category) && $category->id == $cct->id) ? 'active' : ''}}">
                      <a href="{{ route('category', ['category' => $cct->slug]) }}">{{ $cct->title }}</a>
                      </div>
                    @endforeach
                  </div>
                @else
                  <div class="aside-nav-item">
                    <div class="aside-nav-item__image">
                      <img src="{{ Storage::url($cat->image) }}" alt="">
                    </div>
                    <div class="aside-nav-item__title">{{ $cat->title }}</div>
                    <a href="{{ route('category', ['category' => $cat->slug]) }}" class="full-link"></a>
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
        <div class="col-xxl-7 col-lg-10 col-md-12">
          @yield('content')
        </div>
        <div class="col-xxl-3 d-none d-xxl-block">
          @if(isset($is_cart))
            <div class="cart-aside cart-total-aside">
              <div class="cart-total-aside__title">Итого</div>
              <div class="grey-line"></div>
              <div class="cart-total-aside-item">
                <div class="cart-total-aside__text">Товаров</div>
                <div class="cart-total-aside-value">
                  <span class="cart-total-aside__counter js-summary-quantity">0</span>
                </div>
              </div>
              <div class="cart-total-aside-item">
                <div class="cart-total-aside-text">Сумма</div>
                <div class="cart-total-aside-value">
                  <span class="cart-total-aside__counter js-summary-summ-before-discount">0</span>
                  <span class="cart-total-aside__currency">&#8381;</span>
                </div>
              </div>
              <div class="cart-total-aside-item">
                <div class="cart-total-aside-text">Скидка</div>
                <div class="cart-total-aside-value">
                  <span class="cart-total-aside__counter orange-text js-summary-discount">0</span>
                  <span class="cart-total-aside__currency orange-text">&#8381;</span>
                </div>                
              </div>
              <div class="grey-line"></div>
              <div class="cart-summ-aside">
                <div class="cart-summ-aside-text">К оплате</div>
                <div class="cart-summ-aside-value">
                  <span class="cart-summ-aside__counter js-summary-summ">0</span>
                  <span class="cart-summ-aside__currency">&#8381;</span>
                </div>
              </div>
              <div class="place-order-btn js-place-order-btn">
                <div class="place-order-btn__text">{{ isset($is_create_order) ? 'Оформить заказ' : 'Перейти к оформлению заказа' }}</div>
                <a href="#" class="full-link place-order-btn__link"></a>
              </div>
            </div>
          @elseif(isset($is_create_order))
          @else
            <div class="cart-aside">
              <div class="cart-aside-title-wrapper">
                <div class="cart-aside-title">Корзина</div>
                <div class="cart-aside-clear-cart">
                  <a href="/clear-cart" class="cart-aside-clear-cart__link">очистить</a>
                </div>
              </div>

              <div class="cart-aside-products">
                @if(isset($cart_count))
                  @foreach($products_in_cart as $product)
                    <div class="products-item">
                      <div class="products-item__image">
                        <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
                      </div>
                      <div class="products-item__content">
                        <div class="products-item__title">{{ $product->title }}</div>
                        <div class="products-item-price-wrapper">
                          @if($product->promo_price)
                            <div class="products-item__price products-item__promo-price orange-text">
                              <span class="products-item__value">{{ $product->promo_price }}</span>
                              <span class="products-item__currency">&#8381;</span>
                            </div>
                            <div class="products-item__old-price item__old-price">
                              <span class="products-item__value">{{ $product->retail_price }}</span>
                              <span class="products-item__currency">&#8381;</span>
                              <span class="line-through"></span>
                            </div>
                          @else
                            <div class="products-item__price products-item__retail-price">
                              <span class="products-item__value">{{ $product->retail_price }}</span>
                              <span class="products-item__currency">&#8381;</span>
                              <span class="line-through"></span>
                            </div>
                          @endif
                        </div>
                        
                      </div>
                      <div class="products-item__quantity">{{ $product->quantity }}</div>
                    </div>
                  @endforeach
                @else
                  <div class="cart-aside-is-empty-image">
                    <img src="/img/cart-aside-is-empty.svg" alt="">
                  </div>
                  <div class="cart-aside-is-empty-text">В корзине товаров нет</div>
                @endif
              </div>

              <div class="grey-line"></div>

              <div id="cart-aside-place-order-btn" class="place-order-btn {{ isset($cart_count) ? 'active' : '' }}">
                <div class="place-order-btn__text">Оформить заказ</div>
                <div class="place-order-btn__total">
                  <span id="cart-aside-place-order-btn-summ" class="place-order-btn__summ">0</span>
                  <span class="place-order-btn__currency">&#8381;</span>
                </div>
                @if(isset($cart_count))
                  <a href="/cart" class="full-link"></a>
                @endif
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  <footer class="footer">
    <div class="logo-wrapper">
      <div class="container-fluid">
        <div class="logo">
          <img src="{{ asset('img/logo.svg') }}" alt="">
        </div>
      </div>
    </div>
    <div class="bottom-menu">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xxl-2 col-md-3">
            <div class="menu-title">Покупателям</div>
            <ul class="menu">
              <li class="menu-item">
                <a href="/dostavka-i-oplata" class="menu-item__link">Оплата и доставка</a>
              </li>
              <li class="menu-item">
                <a href="/otzyvy" class="menu-item__link">Отзывы</a>
              </li>
              <li class="menu-item">
                <a href="/kak-oformit-zakaz" class="menu-item__link">Как оформить заказ</a>
              </li>
              <li class="menu-item">
                <a href="/lk" class="menu-item__link">Личный кабинет</a>
              </li>
            </ul>
          </div>
          <div class="col-md-3">
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
          <div class="col-xxl-2 col-md-3">
            <div class="menu-title">О интернет-магазине</div>
            <ul class="menu">
              <li class="menu-item">
                <a href="/o-kompanii" class="menu-item__link">О компании</a>
              </li>
              <li class="menu-item">
                <a href="/kontakty" class="menu-item__link">Контакты</a>
              </li>
            </ul>
            
          </div>
          <div class="col-xxl-3 d-none d-xxl-block"></div>
          <div class="col-xxl-2 col-md-3">
            <div class="menu-title">Есть вопросы?</div>
            <div class="last-menu">
              <div class="menu-item phone">+7 (902) 614 09 67</div>
              <div class="menu-item callback-btn js-callback-btn">заказать обратный звонок</div>
              <div class="social">
                <a href="https://vk.com/semena7" target="_blank">
                  <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="30" height="30" rx="5"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M25.1257 9.13542C25.2833 8.63604 25.1257 8.27302 24.4284 8.27302H22.11C21.5252 8.27302 21.2551 8.59089 21.0975 8.93089C21.0975 8.93089 19.9049 11.8351 18.2394 13.7179C17.6993 14.2624 17.4518 14.4439 17.1592 14.4439C17.0016 14.4439 16.7988 14.2624 16.7988 13.7635V9.11195C16.7988 8.52227 16.6191 8.25 16.1237 8.25H12.4775C12.1172 8.25 11.8923 8.52227 11.8923 8.79453C11.8923 9.36164 12.725 9.49799 12.8149 11.086V14.5365C12.8149 15.2851 12.6821 15.4219 12.3872 15.4219C11.5996 15.4219 9.68671 12.4951 8.53921 9.16021C8.31608 8.49969 8.08941 8.25 7.50415 8.25H5.16355C4.48842 8.25 4.37598 8.56742 4.37598 8.90786C4.37598 9.52057 5.16355 12.6058 8.04426 16.6893C9.9572 19.4784 12.6803 20.9774 15.1333 20.9774C16.6191 20.9774 16.7988 20.637 16.7988 20.0699V17.9599C16.7988 17.2795 16.9338 17.1661 17.4067 17.1661C17.744 17.1661 18.3518 17.3472 19.7247 18.686C21.2998 20.274 21.5699 21 22.4478 21H24.7658C25.4409 21 25.7561 20.6596 25.576 20.0017C25.3736 19.3438 24.6082 18.3911 23.6179 17.2569C23.0777 16.6221 22.2676 15.9186 22.0201 15.5782C21.6828 15.1244 21.7726 14.9429 22.0201 14.5347C21.9975 14.5347 24.8335 10.4963 25.1257 9.13365"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="bottom-row">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xxl-2 col-md-4">
            <div class="copyright">OOO Челябинская СС, {{ date("Y") }}</div>
            <div class="inn">ИНН 7415086375</div>
            <div class="ogrn">ОГРН 1147415003592</div>
          </div>
          <div class="col-xxl-8 col-md-5"></div>
          <div class="col-xxl-2 col-md-3">
            <div class="author">
              <a href="https://mybutton.ru/" class="author-name" target="_blank">Поддержка Button</a>
            </div>
            <div class="author">
              <a href="https://nhfuture.ru/" class="author-name" target="_blank">Дизайн Andrewwebnh</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <div class="burger-menu-wrapper hidden-desktop">
    <div class="burger-menu">
      <span></span>
    </div>
  </div>
  <div class="mobile-menu hidden-desktop">

    <div class="city-select city-select-btn header-btn {{ $city_name ? 'active' : '' }}">
      <div class="city-select__image header-btn__image">
        <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7.50039 10.1538C8.93633 10.1538 10.1004 8.98289 10.1004 7.53845C10.1004 6.09401 8.93633 4.92307 7.50039 4.92307C6.06445 4.92307 4.90039 6.09401 4.90039 7.53845C4.90039 8.98289 6.06445 10.1538 7.50039 10.1538Z" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M14 7.53846C14 13.4231 7.5 18 7.5 18C7.5 18 1 13.4231 1 7.53846C1 5.80435 1.68482 4.14127 2.90381 2.91507C4.12279 1.68887 5.77609 1 7.5 1C9.22391 1 10.8772 1.68887 12.0962 2.91507C13.3152 4.14127 14 5.80435 14 7.53846Z" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="city-select__text header-btn__text">{{ $city_name ? $city_name : 'Выбрать город' }}</div>
    </div>

    <!-- 
    <div class="lk-login header-btn {{ auth()->check() ? 'active' : '' }}">
      <div class="lk-login-select__image header-btn__image">
        <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7.49988 8.5C9.57095 8.5 11.2499 6.82107 11.2499 4.75C11.2499 2.67893 9.57095 1 7.49988 1C5.42881 1 3.74988 2.67893 3.74988 4.75C3.74988 6.82107 5.42881 8.5 7.49988 8.5Z"/>
          <path d="M11.25 9.99991H11.5138C12.6484 9.99991 13.6056 10.8449 13.7464 11.9708L14.0392 14.3138C14.1511 15.2091 13.453 15.9999 12.5508 15.9999H2.44916C1.54692 15.9999 0.84884 15.2091 0.960748 14.3138L1.25362 11.9708C1.39437 10.8449 2.35153 9.99991 3.48625 9.99991H3.74999" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class="lk-login-select__text header-btn__text">Личный кабинет</div>
      <a href="/lk" class="full-link header-btn__link"></a>
    </div>
     -->

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
    </ul>

    <div class="question">
      <div class="question-title">Есть вопросы?</div>
      <div class="question-phone">+7 (902) 614 09 67</div>
      <div class="callback-btn js-callback-btn">заказать обратный звонок</div>
    </div>          

  </div>

  <div id="callback-modal" class="modal-window callback-modal">
    <div class="modal-wrapper">
      <div class="modal-area">
        <div class="modal-close">
          <div class="close"></div>
        </div>
        <div class="modal-title">Введите свое имя <br>и номер телефона</div>
        <form id="callback-modal-form" class="form" method="post">
          <label class="label">
            <input type="text" id="name-callback-modal" class="input-field js-name-callback-modal" name="name" autocomplete="on" required minlength="3" maxlength="20" placeholder="Ваше имя">
          </label>
          <label class="label">
            <input type="text" id="phone-callback-modal" class="input-field js-phone-callback-modal js-input-phone-mask" autocomplete="on" name="phone" required maxlength="18" placeholder="+7 (999) 999 99 99">
          </label>
          <input type="hidden" id="email-callback-modal" class="js-email-callback-modal" name="email" value="no email">
          <div class="checkbox-wrapper">
            <input type="checkbox" name="checkbox" class="custom-checkbox js-checkbox-callback-modal" id="checkbox-callback-modal" checked required onchange="document.querySelector('.js-callback-modal-btn').disabled = !this.checked;">
            <label for="checkbox-callback-modal" class="custom-checkbox-label"></label>
            <span class="checkbox-text">Согласен с <a href="/politika-konfidencialnosti" class="privacy-policy-btn" target="_blank">политикой обработки персональных данных</a></span>
          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
        <div class="city-search">
          <form id="city-select-form" class="form city-select-form" method="post">

            <input type="text" name="city" id="city-select-input" class="input-field city-select-input" autocomplete="off" placeholder="Введите город">
          </form>
          <div id="city-select-rezult" class="city-select-rezult"></div>
        </div>
      </div>
    </div>
  </div>

  @if(!request()->cookie('we-use-cookie'))
    <div class="messages-cookies">
      <div class="messages-cookies-wrapper">
        <div class="messages-cookies-text">Этот сайт использует файлы cookies и сервисы сбора технических данных посетителей. Продолжая использовать наш сайт, вы автоматически соглашаетесь с использованием cookies. Нажмите "ОК" чтобы закрыть это сообщение.</div>
        <button class="messages-cookies-close">ОК</button>
      </div>
    </div>
  @endif

  <div class="sticky-desktop-menu header-top hidden-mobile">
    <div class="container-fluid">
      <div class="flex-container">
        <div class="left-nav">
          <div class="logo">
            <a href="{{ route('home') }}">
              <img src="/img/logo.svg" alt="">
            </a>
          </div>
          <a href="/catalog" class="header-catalog-btn hidden-mobile">
            <span class="catalog-btn__burger">
              <span></span>
            </span>
            <span class="catalog-btn__text">Каталог</span>
          </a>
          <form class="search-form" action="/poisk" method="get">
            <input type="text" name="search_query" class="search-input" minlength="3" maxlength="20" autocomplete="off" required placeholder="Искать товары">
            <button type="submit" class="submit-btn">
              <img src="/img/header-search-btn.svg" alt="">
            </button>
            <div class="search-close"></div>
            <div class="search-dropdown">
              <ul class="search-list js-search-rezult"></ul>
              <a href="#" class="search-see-all">Показать все результаты</a>
            </div>
          </form>
        </div>

        <div class="city-select city-select-btn header-btn {{ $city_name ? 'active' : '' }}">
          <div class="city-select__image header-btn__image">
            <svg width="15" height="19" viewBox="0 0 15 19" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7.50039 10.1538C8.93633 10.1538 10.1004 8.98289 10.1004 7.53845C10.1004 6.09401 8.93633 4.92307 7.50039 4.92307C6.06445 4.92307 4.90039 6.09401 4.90039 7.53845C4.90039 8.98289 6.06445 10.1538 7.50039 10.1538Z" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M14 7.53846C14 13.4231 7.5 18 7.5 18C7.5 18 1 13.4231 1 7.53846C1 5.80435 1.68482 4.14127 2.90381 2.91507C4.12279 1.68887 5.77609 1 7.5 1C9.22391 1 10.8772 1.68887 12.0962 2.91507C13.3152 4.14127 14 5.80435 14 7.53846Z" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div class="city-select__text header-btn__text">
            <span class="widescreen">{{ $city_name ? $city_name : 'Выбрать город' }}</span>
            <span class="standartscreen">{{ $city_name ? $city_name : 'Город' }}</span>
          </div>
        </div>

        <!-- 
        <div class="lk-login header-btn {{ auth()->check() ? 'active' : '' }}">
          <div class="lk-login-select__image header-btn__image">
            <svg width="15" height="17" viewBox="0 0 15 17" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M7.49988 8.5C9.57095 8.5 11.2499 6.82107 11.2499 4.75C11.2499 2.67893 9.57095 1 7.49988 1C5.42881 1 3.74988 2.67893 3.74988 4.75C3.74988 6.82107 5.42881 8.5 7.49988 8.5Z"/>
              <path d="M11.25 9.99991H11.5138C12.6484 9.99991 13.6056 10.8449 13.7464 11.9708L14.0392 14.3138C14.1511 15.2091 13.453 15.9999 12.5508 15.9999H2.44916C1.54692 15.9999 0.84884 15.2091 0.960748 14.3138L1.25362 11.9708C1.39437 10.8449 2.35153 9.99991 3.48625 9.99991H3.74999" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <div class="lk-login-select__text header-btn__text">
            <span class="widescreen">Личный кабинет</span>
            <span class="standartscreen">Войти</span>
            </div>
          <a href="/lk" class="full-link header-btn__link"></a>
        </div>
         -->

        <div class="right-nav hidden-mobile">
          <div class="favourites right-nav-item">
            <div class="right-nav-item__image">
              <img src="/img/header-heart.svg" alt="">
            </div>
            <div id="sticky-desktop-menu-favourites-counter" class="counter {{ isset($favourites_count) ? 'active' : '' }}">{{ isset($favourites_count) ? $favourites_count : '' }}</div>
            <div class="right-nav-item__text">Избранное</div>
            <a href="/favourites" class="full-link"></a>
          </div>
          <div class="cart right-nav-item">
            <div class="right-nav-item__image">
              <img src="/img/header-cart.svg" alt="">
            </div>
            <div id="sticky-desktop-menu-cart-counter" class="counter {{ isset($cart_count) ? 'active' : '' }}">{{ isset($cart_count) ? $cart_count : '' }}</div>
            <div class="right-nav-item__text">Корзина</div>
            <a href="/cart" class="full-link"></a>
          </div>
        </div>
        
      </div>
    </div>
  </div>

  <div class="fixed-bottom-menu hidden-desktop">
    <div class="menu-wrapper">
      <div class="menu-item">
        <div class="menu-item__image">
          <img src="/img/fixed-bottom-menu-house.svg" alt="">
        </div>
        <div class="menu-item__title">Главная</div>
        <a href="/" class="full-link"></a>
      </div>
      <a href="/catalog" id="fixed-bottom-menu-catalog-btn" class="menu-item fixed-bottom-menu-catalog-btn">
        <div class="menu-item__image">
          <img src="/img/fixed-bottom-menu-lens.svg" alt="">
        </div>
        <div class="menu-item__title">Каталог</div>
      </a>
      <div class="menu-item cart-menu-item">
        <div class="menu-item__image">
          <img src="/img/fixed-bottom-menu-cart.svg" alt="">
        </div>
        <div class="menu-item__title">Корзина</div>
        <div id="mobile-cart-counter" class="cart-counter {{ isset($cart_count) ? 'active' : '' }}">{{ isset($cart_count) ? $cart_count : '' }}</div>
        <a href="/cart" class="full-link"></a>
      </div>
      <div class="menu-item cart-menu-item">
        <div class="menu-item__image">
          <img src="/img/fixed-bottom-menu-heart.svg" alt="">
        </div>
        <div class="menu-item__title">Избранное</div>
        <div id="mobile-favourites-counter" class="cart-counter {{ isset($favourites_count) ? 'active' : '' }}">{{ isset($favourites_count) ? $favourites_count : '' }}</div>
        <a href="/favourites" class="full-link"></a>
      </div>
    </div>
  </div>

  @if(Auth::guard('admin')->user())
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
  @vite(['resources/js/main.js'])

  <script>
    (function() {
      'use strict';

      var loadedMetrica = false;
      var metricaId = 98881075;
      var timerId;

      if ( navigator.userAgent.indexOf( 'YandexMetrika' ) > -1 ) {
        loadMetrica();
      } else {
        window.addEventListener( 'scroll', loadMetrica, {passive: true} );

        window.addEventListener( 'touchstart', loadMetrica );

        document.addEventListener( 'mouseenter', loadMetrica );

        document.addEventListener( 'click', loadMetrica );

        document.addEventListener( 'DOMContentLoaded', loadFallback );
      }

      function loadFallback() {
        timerId = setTimeout( loadMetrica, 3000 );
      }

      function loadMetrica( e ) {

        if ( loadedMetrica ) {
          return;
        }

        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(98881075, "init", {
          clickmap:true,
          trackLinks:true,
          accurateTrackBounce:true
        });

        loadedMetrica = true;

        clearTimeout( timerId );

        window.removeEventListener( 'scroll', loadMetrica );
        window.removeEventListener( 'touchstart', loadMetrica );
        document.removeEventListener( 'mouseenter', loadMetrica );
        document.removeEventListener( 'click', loadMetrica );
        document.removeEventListener( 'DOMContentLoaded', loadFallback );
      }
    })()
  </script>
  
</body>
</html>
