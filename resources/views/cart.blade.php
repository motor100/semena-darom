@extends('layouts.main')

@section('title', 'Корзина')

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
  <div class="active">корзина</div>
</div>

<div class="cart js-cart-page">

  <div class="cart-title page-title">Корзина</div>

  @if(count($products) > 0)
    <div class="cf-clear">
      <div class="cf-clear__image">
        <img src="/img/cf-trash.svg" alt="">
      </div>
      <a href="/clear-cart" class="cf-clear__link">Очистить корзину</a>
    </div>
  @endif
  
  <!-- 
  @if($errors->any())
    <div class="errors-wrapper">
      <div class="container">
        <div class="alert alert-danger cart-errors">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif
   -->  

  <div class="min-order">
    <div class="min-order-text">Еще <span class="min-order-counter"></span> ₽ до минимального заказа</div>
    <div class="min-order-line">
      <div class="min-order-grey-line"></div>
      <div class="min-order-green-line"></div>
    </div>
    <div class="cart-price">
      <img src="/img/cart-price.png" class="cart-price-image" alt="">
      <span class="cart-price-text">1500 ₽</span>
    </div>
  </div>

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
              <div class="add-to add-to-favourites" data-id="{{ $product->id }}">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M23.4637 33.6581L14.7201 24.5531C12.2572 21.9885 12.4123 17.7834 15.0568 15.423C17.6803 13.0814 21.6581 13.5361 23.7313 16.4146L24.0799 16.8985L24.4284 16.4146C26.5017 13.5361 30.4794 13.0814 33.103 15.423C35.7474 17.7834 35.9026 21.9885 33.4397 24.5531L24.6961 33.6581C24.3558 34.0124 23.804 34.0124 23.4637 33.6581Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="add-to-favourites__text">В избранное</span>
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
              <div class="cf-item__quantity">
                <button type="button" class="quantity-button quantity-minus" data-id="{{ $product->id }}">
                  <div class="circle"></div>
                </button>
                <input class="quantity-number" type="number" name="quantity" max="{{ $product->stock }}" min="1" step="1" data-id="{{ $product->id }}" value="{{ $product->quantity }}" readonly>
                <button type="button" class="quantity-button quantity-plus" data-id="{{ $product->id }}">
                  <div class="circle"></div>
                </button>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="cart-is-empty">
      <div class="cart-is-empty-content cf-is-empty-content">
        <div class="cart-is-empty-image">
          <img src="/img/cart-is-empty.svg" alt="">
        </div>
      </div>
      <div class="cart-is-empty-content cf-is-empty-content">
        <div class="cf-is-empty-text">УПС.... В вашей корзине ничего нет(</div>
      </div>
      <div class="cart-is-empty-content cf-is-empty-content cf-is-empty-btns">
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