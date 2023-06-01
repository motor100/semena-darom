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
  <div class="content-wrapper">
    <div class="cart-title page-title">Корзина</div>
  
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
    <div class="min-order-text">Еще <span class="min-order-counter">1 500</span> ₽ до минимального заказа</div>
    <div class="min-order-grey-line"></div>
    <div class="cart-price">
      <img src="/img/cart-price.png" class="cart-price-image" alt="">
      <span class="cart-price-text">1500 ₽</span>
    </div>
  </div>

  @if(count($products) > 0)
    <div class="clear-cart">
      <a href="/clear-cart">
        <span class="clear-cart__text">Очистить корзину</span>
      </a>
    </div>
  @endif

  @if(count($products) > 0)
    <div class="cart-items-wrapper">
      @foreach($products as $product)
        <div class="cart-item">
          <div class="cart-item__image">
            <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
          </div>
          <div class="cart-item__content">
            <div class="cart-item__top">
              <div class="cart-item__title-wrapper">
                <div class="cart-item__title">{{ $product->title }}</div>
                @if($product->promo_price)
                  <div class="cart-item__price red-text">
                    <span class="cart-item__value">{{ $product->promo_price }}</span>
                    <span class="cart-item__currency">&#8381;</span>
                  </div>
                @else
                  <div class="cart-item__price">
                    <span class="cart-item__value">{{ $product->retail_price }}</span>
                    <span class="cart-item__currency">&#8381;</span>
                  </div>
                @endif             
              </div>
              @if($product->promo_price)
                <div class="cart-item__promo">
                  <div class="cart-item__promo-text red-text">Акция</div>
                  <div class="cart-item__old-price item__old-price">
                    <span class="cart-item__value">{{ $product->retail_price }}</span>
                    <span class="cart-item__currency">&#8381;</span>
                    <span class="line-through"></span>
                  </div>
                </div>
              @endif
            </div>
            <div class="cart-item__bottom">
              <div class="add-to-favourites" data-id="{{ $product->id }}">
                <svg width="23" height="21" viewBox="0 0 23 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10.9177 19.7475L2.65498 11.0978C0.327621 8.66145 0.474179 4.66658 2.97318 2.42425C5.45236 0.199689 9.21145 0.631665 11.1706 3.36625L11.5 3.82598L11.8294 3.36625C13.7886 0.631665 17.5476 0.199689 20.0268 2.42425C22.5258 4.66658 22.6724 8.66145 20.345 11.0978L12.0823 19.7475C11.7607 20.0842 11.2393 20.0842 10.9177 19.7475Z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="add-to-favourites__text">В избранное</span>
              </div>
              <form class="form rm-from-cart-form" action="/rmfromcart"  method="post">
                <input type="hidden" name="id" value="{{ $product->id }}">
                @csrf
                <button type="submit" class="rm-from-cart-btn">
                  <img src="/img/cart-item-close.png" alt="">
                  <span class="rm-from-cart-btn__text">Удалить</span>
                </button>
              </form>
              <div class="cart-item__quantity">
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
      <div class="container">
        <div class="cart-is-empty-content">
          <div class="row">
            <div class="col-md-8 mx-auto">
              <div class="cart-is-empty-image">
                <img src="/img/cart-is-empty.svg" alt="">
              </div>
            </div>
          </div>
        </div>
        <div class="cart-is-empty-content">
          <div class="row">
            <div class="cart-is-empty-text">УПС.... В вашей корзине ничего нет(</div>
          </div>
        </div>
        <div class="cart-is-empty-content">
          <div class="row">
            <div class="col-md-4 ms-auto">
              <div class="cart-is-empty-btn cart-is-empty-back-btn" onclick="history.back();">
                <span class="cart-is-empty-btn__text">Вернуться назад</span>
              </div>
            </div>
            <div class="col-md-4 me-auto">
              <a href="{{ route('home') }}" class="cart-is-empty-btn cart-is-empty-home-btn">
                <span class="cart-is-empty-btn__text">Главная</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

</div>

@endsection