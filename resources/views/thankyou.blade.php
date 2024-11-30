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

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="page-title">Спасибо за заказ</div>

    <div class="thankyou-subtitle">Ваш заказ успешно принят</div>

    @if (isset($order_id) && isset($summ))
      <div class="thankyou-text">Номер заказа {{ $order_id }}</div>
      <div class="thankyou-text">Сумма {{ $summ }} p.</div>

      <h3>
        Включен тестовый режим Юкасса<br>
        Номер карты 5555 5555 5555 4477<br>
        Месяц 01, год 28, cvc 123<br>
      </h3>      

      @if (isset($payment) && $payment == 'yookassa')
        <form action="/yookassa-redirect" class="form" method="post">
          <input type="hidden" name="summ" value="{{ $summ }}">
          <input type="hidden" name="order_id" value="{{ $order_id }}">
          @csrf
          <button type="submit" class="pay-btn">Оплатить</button>
        </form>
      @endif
    @endif

</div>

@endsection