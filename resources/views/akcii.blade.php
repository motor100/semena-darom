@extends('layouts.main')

@section('title', 'Акции')

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
  <div class="active">акции</div>
</div>

<div class="catalog">
  <div class="page-title">Акции</div>

  <form id="sort-by-form" action="/akcii" method="get">
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

  {{ $products->links() }}

  
</div> 

@endsection