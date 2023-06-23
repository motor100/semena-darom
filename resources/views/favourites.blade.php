@extends('layouts.main')

@section('title', 'Избранное')

@section('content')

<div class="breadcrumbs">
  <div class="back" onclick="history.back();">
    <span class="back-text">вернуться назад</span>
    <img src="/img/breadscrumbs-back.png" alt="">
  </div>
  <div class="parent">
    <a href="{{ route('home') }}">главная страница</a>
  </div>
  <div class="arrow"></div>
  <div class="active">избранное</div>
</div>

<div class="favourites">
  <div class="favourites-title page-title">Избранное</div>

  @if(count($products) > 0)
    <div class="cf-clear">
      <div class="cf-clear__image">
        <img src="/img/cf-trash.svg" alt="">
      </div>
      <a href="/clear-favourites" class="cf-clear__link">Очистить избранное</a>
    </div>
  @endif

  @if(count($products) > 0)
    <div class="cf-items-wrapper">
      @foreach($products as $product)
        <div class="cf-item">
          <div class="cf-item__image">
            <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
          </div>
          <div class="cf-item__content">
            <div class="cf-item__top">
              <div class="cf-item__title-wrapper">
                <div class="cf-item__title">{{ $product->title }}</div>
                @if($product->promo_price)
                  <div class="cf-item__price red-text">
                    <span class="cf-item__value">{{ $product->promo_price }}</span>
                    <span class="cf-item__currency">&#8381;</span>
                  </div>
                @else
                  <div class="cf-item__price">
                    <span class="cf-item__value">{{ $product->retail_price }}</span>
                    <span class="cf-item__currency">&#8381;</span>
                  </div>
                @endif             
              </div>
              @if($product->promo_price)
                <div class="cf-item__promo">
                  <div class="cf-item__promo-text red-text">Акция</div>
                  <div class="cf-item__old-price item__old-price">
                    <span class="cf-item__value">{{ $product->retail_price }}</span>
                    <span class="cf-item__currency">&#8381;</span>
                    <span class="line-through"></span>
                  </div>
                </div>
              @endif
            </div>
            <div class="cf-item__bottom">
              <div class="add-to add-to-cart" data-id="{{ $product->id }}">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M13 13H15.078C16.0056 13 16.4694 13 16.8186 13.2517C17.1678 13.5034 17.3145 13.9434 17.6078 14.8234L18.3333 17" stroke="#B3B3B3" stroke-linecap="round"/>
                  <path d="M31.6671 30.334H19.0683C18.8734 30.334 18.7759 30.334 18.702 30.3257C17.9185 30.238 17.3818 29.4933 17.5463 28.7224C17.5619 28.6496 17.5927 28.5572 17.6543 28.3723C17.7228 28.1669 17.757 28.0643 17.7948 27.9737C18.1818 27.0463 19.0574 26.4151 20.0597 26.3412C20.1576 26.334 20.2658 26.334 20.4822 26.334H27.6671" stroke="#B3B3B3" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M27.237 26.3334H23.1822C21.4766 26.3334 20.6238 26.3334 19.9558 25.893C19.2879 25.4526 18.952 24.6687 18.2801 23.101L18.055 22.5757C16.9757 20.0573 16.436 18.798 17.0288 17.899C17.6216 17 18.9916 17 21.7316 17H28.7728C31.8381 17 33.3708 17 33.9489 17.9961C34.5271 18.9923 33.7665 20.3231 32.2457 22.9846L31.8677 23.6462C31.1184 24.9572 30.7439 25.6128 30.1231 25.9731C29.5023 26.3334 28.7472 26.3334 27.237 26.3334Z" stroke="#B3B3B3" stroke-linecap="round"/>
                  <path d="M30.9984 35.0007C31.7348 35.0007 32.3317 34.4037 32.3317 33.6673C32.3317 32.9309 31.7348 32.334 30.9984 32.334C30.262 32.334 29.665 32.9309 29.665 33.6673C29.665 34.4037 30.262 35.0007 30.9984 35.0007Z" fill="#B3B3B3"/>
                  <path d="M20.3333 35.0007C21.0697 35.0007 21.6667 34.4037 21.6667 33.6673C21.6667 32.9309 21.0697 32.334 20.3333 32.334C19.597 32.334 19 32.9309 19 33.6673C19 34.4037 19.597 35.0007 20.3333 35.0007Z" fill="#B3B3B3"/>
                </svg>
                <span class="add-to-cart__text">В корзину</span>
              </div>
              <form class="form rm-from-form" action="/rmfromcart"  method="post">
                <input type="hidden" name="id" value="{{ $product->id }}">
                @csrf
                <button type="submit" class="rm-from-btn">
                  <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.75 15.75L32.25 32.25" stroke="#B3B3B3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M32.25 15.75L15.75 32.25" stroke="#B3B3B3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span class="rm-from-btn__text">Удалить</span>
                </button>
              </form>
              <!-- 
              <div class="cf-item__quantity">
                <button type="button" class="quantity-button quantity-minus" data-id="{{ $product->id }}">
                  <div class="circle"></div>
                </button>
                <input class="quantity-number" type="number" name="quantity" max="{{ $product->stock }}" min="1" step="1" data-id="{{ $product->id }}" value="{{ $product->quantity }}" readonly>
                <button type="button" class="quantity-button quantity-plus" data-id="{{ $product->id }}">
                  <div class="circle"></div>
                </button>
              </div>
               -->
            </div>
          </div>
        </div>
      @endforeach
    </div>      
  @else
    <div class="favourites-is-empty">
      <div class="favourites-is-empty-content cf-is-empty-content">
        <div class="favourites-is-empty-image">
          <img src="/img/favourites-is-empty.svg" alt="">
        </div>
      </div>
      <div class="favourites-is-empty-content cf-is-empty-content">
        <div class="cf-is-empty-text">У вас пока нет избранных товаров</div>
      </div>
      <div class="favourites-is-empty-content cf-is-empty-content cf-is-empty-btns">
        <div class="cf-is-empty-btn cf-is-empty-back-btn" onclick="history.back();">
          <span class="cf-is-empty-btn__text">Вернуться назад</span>
        </div>
        <a href="{{ route('home') }}" class="cf-is-empty-btn cf-is-empty-home-btn">
          <span class="cf-is-empty-btn__text">Главная</span>
        </a>
      </div>
    </div>
  @endif

</div>

@endsection