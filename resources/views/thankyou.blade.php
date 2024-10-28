@extends('layouts.main')

@section('title', 'Спасибо за заказ')

@section('content')

<div class="breadcrumbs">
  <div class="back">
    <span class="back-text">вернуться назад</span>
    <img src="/img/breadscrumbs-back.png" alt="">
  </div>
  <div class="parent">
    <a href="{{ route('home') }}">главная</a>
  </div>
  <div class="arrow"></div>
  <div class="active">спасибо за заказ</div>
</div>

<div class="thankyou">
  <div class="page-title">Спасибо за заказ</div>

    <div class="thankyou-subtitle">Ваш заказ успешно принят</div>

    @if (isset($order_id) && isset($summ))
      <div class="thankyou-text">Номер заказа {{ $order_id }}</div>
      <div class="thankyou-text">Сумма {{ $summ }} p.</div>
      @if (isset($payment) && $payment == 'yookassa')
        <button class="pay-btn">Оплатить</button>
      @endif
    @endif

</div>

@endsection