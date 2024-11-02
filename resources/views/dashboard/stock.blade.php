@extends('dashboard.layout')

@section('title', 'Склад')

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

  <form class="form mb-5" action="{{ route('stock') }}" method="get">
    <div class="form-group mb-3">
      <label for="search_query">Поиск товара по штрихкоду</label>
      <input type="number" class="form-control input-number" name="search_query" id="search_query" required>
    </div>
    <button type="submit" class="btn btn-primary">Найти</button>
  </form>

  @if(isset($product))
    <div class="search-rezult">
      <div class="product-title">{{ $product->title }},&nbsp;количество&nbsp;{{ $product->stock }}</div>
    </div>

    <form class="form" action="{{ route('stock-update') }}" method="post">
      <div class="form-group mb-3">
        <label for="quantity">Количество</label>
        <input type="number" class="form-control input-number" name="quantity" id="quantity" min="0" step="1" required>
      </div>
      <input type="hidden" name="id" value="{{ $product->id }}">

      @csrf
      <button type="submit" class="btn btn-primary">Обновить</button>
    </form>
  @endif

</div>

<script>
  const menuItem = 2;
</script>
@endsection