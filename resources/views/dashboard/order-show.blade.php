@extends('dashboard.layout')

@section('title', 'Заказы')

@section('dashboardcontent')

<div class="dashboard-content">

  @if(session()->get('status'))
    <div class="alert alert-success">
      {{ session()->get('status') }}
    </div>
  @endif

  <div class="order-content">
    <div class="form-group mb-3">
      <div class="label-text mb-1">
        <a href="{{ route('admin.order-check', $order->id) }}">Товары</a>
      </div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Сумма</div>
      <div class="order-info">{{ $order->price }}р</div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Штрихкод</div>
      <div class="barcode">
        <div class="barcode-image">{!! DNS1D::getBarcodeHTML(strval($order->id), 'EAN13') !!}</div>
        <div class="barcode-number">{{ $order->barcode }}</div>
      </div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Оплата</div>
      <div class="order-info">
        @if($order->payment == 'yookassa') Онлайн @endif
        @if($order->payment == 'sdek') СДЕК @endif
        @if($order->payment == 'sdek') Почта России @endif
      </div>
      <div class="order-info {{ !$order->payment_status ? 'text-danger' : '' }}">{{ $order->payment_status ? 'Оплачен' : 'Оплаты нет' }}</div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Доставка</div>
      <div class="order-info">{{ $order->delivery == 'sdek' ? 'СДЕК' : 'Почта России' }}</div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Время</div>
      <div class="order-info">{{ $order->created_at->format("d.m.Y H:i") }}</div>
    </div>
    <div class="form-group mb-3">
      <div class="label-text mb-1">Покупатель</div>
      <div class="order-info">{{ $order->first_name . ' ' . $order->last_name . ' ' . $order->phone . ' ' . $order->email . ' ' . $order->address }}</div>
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
            <option value="В обработке" {{ $order->status == 'В обработке' ? 'selected' : '' }}>В обработке</option>
            <option value="Склад" {{ $order->status == 'Склад' ? 'selected' : '' }}>Склад</option>
            <option value="Отправлен в ПВЗ" {{ $order->status == 'Отправлен в ПВЗ' ? 'selected' : '' }}>Отправлен в ПВЗ</option>
            <option value="Отменен" {{ $order->status == 'Отменен' ? 'selected' : '' }}>Отменен</option>
          </select>
        @endif
      </div>

      @if($order->status != "Выдан")
        <div class="form-group mb-5">
          <label for="comment" class="form-check-label d-block mb-1">Комментарий</label>
          <input type="text" name="comment" id="comment" class="form-control" maxlength="250" value="{{ $order->comment }}">
        </div>
        <input type="hidden" name="id" value="{{ $order->id }}">
        @csrf

        <input type="submit" class="btn btn-primary" value="Обновить">
      @endif
    </form>
  </div>

  <div class="print-section mb-5">
    <a href="{{ route('admin.order-print', $order->id) }}" class="btn btn-primary" target="_blank">Печать</a>
  </div>

  <div class="send-order-section mb-5">
    <p>Сформировать заказ, отправить в СДЕК и получить квитанцию.</p>
    <p>Кнопка для скачивания появится когда квитанция будет готова.</p>
    <form class="form mb-1" action="{{ route('admin.cdek-create-order', $order->id) }}">
      <button type="submit" class="btn btn-primary">Отправить в СДЕК</button>
    </form>
    @if ($is_waybill)
      <form class="form mb-1" action="{{ route('admin.cdek-download-waybill', $order->id) }}">
        <button type="submit" class="btn btn-success">Скачать квитанцию</button>
      </form>
    @endif
  </div>

</div>

<script>
  const menuItem = 6;
</script>

@endsection