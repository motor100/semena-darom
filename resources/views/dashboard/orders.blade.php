@extends('dashboard.layout')

@section('title', 'Заказы')

@section('dashboardcontent')

<div class="dashboard-content">

  <table class="table">
    <tr>
      <th>№</th>
      <th>Дата</th>
      <th>Статус</th>
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
          <td>
            @if ($order->payment)
              <div class="payment payment-green"></div>
            @else
              <div class="payment payment-red"></div>
            @endif
          </td>
          <td>{!! $order->comment !!}</td>
          
        </tr>
      @endforeach
    @endif
  </table>

  {{ $orders->links() }}

</div>

<script>
  const menuItem = 3;
</script>

@endsection 