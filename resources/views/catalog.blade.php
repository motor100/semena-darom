@extends('layouts.main')

@section('title', 'Каталог')

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

  <form id="sort-form" action="/catalog" method="get">
    @if(request()->category)
      <input type="hidden" name="category" value="{{ request()->category }}">
    @endif
    <select name="price" id="sort-by">

        <option value="desc" {{ request()->price == "desc" ? "selected" : "" }}>Сначала дорогие</option>

        <option value="asc" {{ request()->price == "asc" ? "selected" : "" }}>Сначала дешевые</option>

    </select>
    <input type="submit" value="Отправить">
  </form>


  <script>

    
    let sortBy = document.querySelector('#sort-by');

    function addQueryParam1() {
      const url = new URL(window.location);  // == window.location.href
      url.searchParams.set('sort', sortBy.value); 
      history.pushState(null, null, url);    // == url.href
    }

    function addQueryParam() {
      let sortForm = document.querySelector('#sort-form');
      sortForm.submit();
    }

    sortBy.addEventListener('change', addQueryParam);
    
  </script>

  @foreach($products as $product)
    <p>{{ $product->title }}</p>
  @endforeach

  {{ $products->links() }}

  
</div> 

@endsection