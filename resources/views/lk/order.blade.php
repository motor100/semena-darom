@extends('layouts.main')

@section('title', 'Личный кабинет')

@section('content')

<div class="breadcrumbs">
  <div class="back" onclick="history.back();">
    <span class="back-text">вернуться назад</span>
    <img src="/img/breadscrumbs-back.png" alt="">
  </div>
  <div class="parent">
    <a href="{{ route('home') }}">главная</a>
  </div>
  <div class="arrow"></div>
  <div class="active">личный кабинет</div>
</div>

<div class="lk">
  <div class="page-title">Личный кабинет</div>

  @include('lk.lk-navigation')

  <div class="orders-wrapper">
    <div class="orders">
      <div class="orders-title">Заказ</div>
      @foreach($orders as $rd)
        <div class="order-item">
          <a href="{{ route('lk.order', $rd->id) }}">{{ $rd->id }}</a>
        </div>
      @endforeach
    </div>
    <div class="order-info">
      <div class="order-info-item">
        <div class="order-info__title">Заказ:</div>
        <div class="order-info__text">{{ $order->id }}</div>
      </div>
      <div class="order-info-item">
        <div class="order-info__title">Дата:</div>
        <div class="order-info__text">{{ $order->created_at->format("d.m.Y") }}</div>
      </div>
      <div class="order-info-item">
        <div class="order-info__title">Товары:</div>
        @foreach($order->products as $product)
          <div class="order-info__text">{{ $product->title . " " . $product->pivot->quantity }}шт</div>
        @endforeach
      </div>
      <div class="order-info-item">
        <div class="order-info__title">Сумма:</div>
        <div class="order-info__text">
          <span class="order-info__value">{{ $order->price }}</span>
          <span class="order-info__currency">&#8381;</span>
        </div>
      </div>
    </div>
  </div>

  {{ $orders->links('pagination.custom') }}

  <script>
    const lkNavItem = document.querySelectorAll('.lk-nav-item');
    lkNavItem[0].classList.add('active');
  </script>

</div>

@endsection
