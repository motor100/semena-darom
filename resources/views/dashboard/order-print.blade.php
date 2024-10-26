<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Заказ {{ $order->id }}</title>
  <link rel="stylesheet" href="{{ asset('/adminpanel/css/print.css') }}">
</head>
<body>
  <h3>Заказ {{ $order->id }}</h3>
  <div class="barcode mb-30">
    <div class="barcode-image">{!! DNS1D::getBarcodeHTML(strval($order->id), 'EAN13') !!}</div>
    <div class="barcode-number">{{ $order->barcode }}</div>
  </div>
  <table class="table">
    <tr>
      <th>№</th>
      <th>Название</th>
      <th>Количество</th>
    </tr>
    @foreach($products as $key => $value)
      <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $value->title }}</td>
        <td>{{ $value->quantity }}</td>
      </tr>
    @endforeach
  </table>
</body>
</html>