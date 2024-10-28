@extends('layouts.main')

@section('title', 'Каталог')

@section('style')
  <link rel="stylesheet" href="{{ asset('css/slimselect.min.css') }}">
@endsection

@section('content')

<div class="breadcrumbs">
  <div class="back" onclick="history.back();">
    <span class="back-text">вернуться назад</span>
    <img src="/img/breadscrumbs-back.png" alt="">
  </div>
  <div class="parent">
    <a href="{{ route('home') }}">главная</a>
  </div>
  <div class="arrow"></div>
  <div class="parent">
    <a href="{{ route('catalog') }}">каталог</a>
  </div>
  @if($category_title)
    <div class="arrow"></div>
    <div class="active">{{ $category_title }}</div>
  @endif
</div>

<div class="catalog">
  <div class="page-title">{{ $category_title ? $category_title : "Каталог" }}</div>

  <div class="catalog-sort">
    <div class="catalog-sort-text">Сортировка:</div>
    <form id="catalog-sort-form" class="catalog-sort-form" action="/catalog" method="get">
      @if(request()->category)
        <input type="hidden" name="category" value="{{ request()->category }}">
      @endif
      <select name="price" id="catalog-sort-select" class="catalog-sort-select">
        <option value="desc" {{ request()->price == "desc" ? "selected" : "" }}>Сначала дорогие</option>
        <option value="asc" {{ request()->price == "asc" ? "selected" : "" }}>Сначала дешевые</option>
      </select>
    </form>
  </div>

  <div class="products">
    <div class="row">
      @foreach($products as $product)
        <div class="col-md-3 col-6">
          @include('regular-products-item')
        </div>
      @endforeach
    </div>
  </div>

  {{ $products->links('pagination.custom') }}

</div> 

@endsection

@section('script')
  <script src="{{ asset('js/slimselect.min.js') }}"></script>
@endsection