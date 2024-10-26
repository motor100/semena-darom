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

  @if($orders->count() > 0)
    <div class="orders-wrapper">
      <div class="orders">
        <div class="orders-title">Заказ</div>
        @foreach($orders as $order)
          <div class="order-item">
            <a href="{{ route('lk.order', $order->id) }}">{{ $order->id }}</a>
          </div>
        @endforeach
      </div>
      <div class="order-info">
        <div class="order-info-item">
          <div class="order-info__title">Выберите заказ</div>
        </div>
      </div>
    </div>

    {{ $orders->links('pagination.custom') }}
    
  @else
    <div class="no-orders">Заказов нет</div>
  @endif

</div>

@endsection 