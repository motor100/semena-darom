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

<div class="cart">
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

  @if($products->count() > 0)
    

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