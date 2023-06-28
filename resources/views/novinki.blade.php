@extends('layouts.main')

@section('title', 'Новинки')

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
  <div class="active">новинки</div>
</div>

<div class="novinki">
  <div class="page-title">Новинки</div>

  <form id="sort-by-form" action="/novinki" method="get">
    <select name="price" id="sort-by-select">
      <option value="desc" {{ request()->price == "desc" ? "selected" : "" }}>Сначала дорогие</option>
      <option value="asc" {{ request()->price == "asc" ? "selected" : "" }}>Сначала дешевые</option>
    </select>
  </form>

  <div class="products">
    <div class="row">
      @foreach($products as $product)
        @include('regular-products-item')
      @endforeach
    </div>
  </div>

  {{ $products->onEachSide(1)->links() }}

  
</div> 

@endsection