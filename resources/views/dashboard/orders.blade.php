@extends('dashboard.layout')

@section('title', 'Заказы')

@section('dashboardcontent')

<div class="dashboard-content">

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form class="form mb-5" action="/admin/orders" method="get">
    <div class="form-group mb-3">
      <label for="search_query">Поиск</label>
      <input type="number" class="form-control input-number" name="search_query" id="search_query" minlength="8" maxlength="15" required>
    </div>
    <button type="submit" class="btn btn-primary">Найти</button>
  </form>

  <table class="table">
    <tr>
      <th>№</th>
      <th>Дата</th>
      <th>Статус</th>
      <th>Штрихкод</th>
      <th>Оплата</th>
      <th>Комментарий</th>
    </tr>
    @if(isset($orders))
      @foreach($orders as $order)
        <tr class="orders-table-row">
          <td>
            <a href="{{ route('admin.orders-show', $order->id) }}">{{ $order->id }}</a>
          </td>
          <td>{{ $order->created_at->format("d.m.Y") }}</td>
          <td>{{ $order->status }}</td>
          <td>{{ $order->barcode }}</td>
          <td>
            <div class="payment {{ $order->payment_status ? 'payment-green' : 'payment-red' }}"></
          </td>
          <td>{!! $order->comment !!}</td>
          
        </tr>
      @endforeach
    @endif
  </table>

  {{ $orders->links() }}

</div>

<script>
  const menuItem = 4;
</script>

@endsection 