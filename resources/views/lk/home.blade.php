@extends('layouts.main')

@section('title', 'Личный кабинет')

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
  <div class="active">личный кабинет</div>
</div>

<div class="lk">
  <div class="page-title">Личный кабинет</div>

  @include('lk.lk-navigation')

  <!-- Если количество заказов > 0 -->
  <div class="orders-wrapper">
    <div class="orders">
      <div class="orders-title">Заказ</div>
      <div class="order-item">178G541R</div>
      <div class="order-item">178G541R</div>
    </div>
    <div class="order-info">
      <div class="order-info-item">
        <div class="order-info__title">Заказ:</div>
        <div class="order-info__text">178G541R</div>
      </div>
      <div class="order-info-item">
        <div class="order-info__title">Дата:</div>
        <div class="order-info__text">23.08.2023</div>
      </div>
      <div class="order-info-item">
        <div class="order-info__title">Товары:</div>
        <div class="order-info__text">Огурцы заморские 10 шт</div>
        <div class="order-info__text">Огурцы заморские 10 шт</div>
        <div class="order-info__text">Огурцы заморские 10 шт</div>
      </div>
      <div class="order-info-item">
        <div class="order-info__title">Сумма:</div>
        <div class="order-info__text">
          <span class="order-info__value">1 585</span>
          <span class="order-info__currency">&#8381;</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Иначе -->
  <div class="no-orders">Заказов нет</div>

@endsection 