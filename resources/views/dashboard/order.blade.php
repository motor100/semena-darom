@extends('dashboard.layout')

@section('title', 'Заказы')

@section('dashboardcontent')

<div class="dashboard-content">

  <div class="order-content">
    <div class="form-group mb-3">
      <div class="label-text mb-1">
        <a href="#">Товары</a>
      </div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Сумма</div>
      <div class="order-info">{{ $order->price }}р</div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Оплата</div>
      @if($order->payment)
        <div class="order-info">Оплачен</div>
      @else
        <div class="order-info order-info-red">Оплаты нет</div>
      @endif
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">ПВЗ</div>
      <div class="order-info">{{ $order->office }}</div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Время</div>
      <div class="order-info">{{ $order->created_at->format("d.m.Y H:i") }}</div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Покупатель</div>
      <div class="order-info">{{ $order->first_name . ' ' . $order->last_name . ' ' . $order->phone . ' ' . $order->email }}</div>
    </div>
  </div>

  <div class="order-edit mb-5">
    <form class="form" action="{{ route('admin.order-update', $order->id) }}" method="post">
      <div class="form-group mb-3">
        <div class="label-text mb-1">Статус</div>
        @if($order->status == "Выдан")
          <div class="order-info">{{ $order->status }}</div>
        @else
          <select name="status" id="status" class="form-select">
            <option value="{{ $order->status }}" selected>{{ $order->status }}</option>
            <option value="В обработке">В обработке</option>
            <option value="Склад">Склад</option>
            <option value="Отправлен в ПВЗ">Отправлен в ПВЗ</option>
            <option value="Отменен">Отменен</option>
          </select>
        @endif
      </div>

      @if($order->status != "Выдан")
        <div class="form-group mb-3">
          <label for="comment" class="form-check-label d-block mb-1">Комментарий</label>
          <input type="text" name="comment" id="comment" class="form-control" maxlength="250" value="{{ $order->comment }}">
        </div>
        <input type="hidden" name="id" value="{{ $order->id }}">
        @csrf

        <input type="submit" class="btn btn-primary" value="Обновить">
      @endif
    </form>
  </div>

  <div class="print-section">
    <a href="#" class="btn btn-primary" target="_blank">Печать</a>
  </div>

</div>

<script>
  const menuItem = 3;
</script>

@endsection