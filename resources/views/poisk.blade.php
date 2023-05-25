@section('title', 'Поиск')

@extends('layouts.main')

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
  <div class="active">поиск</div>
</div>

<div class="poisk">
  <div class="content-wrapper">

    @if (count($products) > 0)

    @else
      <div class="poisk-title">По запросу «{{ $q }}» ничего не найдено</div>
      <div class="no-products-found">
        <div class="no-products-found-content">
          <div class="no-products-found-image">
            <img src="/img/no-products-found.svg" alt="">
          </div>
        </div>
        <div class="no-products-found-content">
          <div class="no-products-found-text">К сожалению такого товара нет. Возможно он появиться позже.</div>
        </div>
        <div class="no-products-found-content">
          <a href="{{ route('catalog') }}" class="no-products-found-btn">
            <span class="cart-is-empty-btn__text">Вернуться в каталог</span>
          </a>
        </div>
      </div>
    @endif
  </div>
</div>

@endsection