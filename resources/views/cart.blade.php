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
    <div class="cart-title">Корзина</div>
  
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
    <div class="cart-items-wrapper">
      @foreach($products as $product)
        <div class="cart-item">
          <div class="cart-item__title">{{ $product->title }}</div>
          <div class="cart-item__image">
            <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
          </div>
          <div class="cart-item__price-wrapper">
            @if($product->promo_price)
              <div class="cart-item__old-price">
                <span class="cart-item__value">{{ $product->retail_price }}</span>
                <span class="cart-item__currency">&#8381;</span>
              </div>
              <div class="cart-item__price">
                <span class="cart-item__value">{{ $product->promo_price }}</span>
                <span class="cart-item__currency">&#8381;</span>
              </div>
            @else
            <div class="cart-item__price">
              <span class="cart-item__value">{{ $product->retail_price }}</span>
              <span class="cart-item__currency">&nbsp;&#8381;</span>
            </div>
            @endif
          </div>
          <div class="cart-item__stock">в наличии {{ $product->stock }} &nbsp;шт</div>
          
          <div class="cart-item__quantity">
            <button type="button" class="quantity-button quantity-minus" data-id="{{ $product->id }}">
              <div class="circle"></div>
            </button>
            <input class="quantity-number" type="number" name="quantity" max="{{ $product->stock }}" min="1" step="1" data-id="{{ $product->id }}" value="{{ $product->quantity }}" readonly>
            <button type="button" class="quantity-button quantity-plus" data-id="{{ $product->id }}">
              <div class="circle"></div>
            </button>
          </div>

          <form class="form cart-item__trash rm-from-cart-btn" action="/rmfromcart"  method="post">
            <input type="hidden" name="id" value="{{ $product->id }}">
            @csrf
            <button type="submit" class="rm-from-cart-submit-btn">Удалить</button>
          </form>
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