@extends('layouts.main')

@section('title', 'Акции')

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
  <div class="active">акции</div>
</div>

<div class="akcii">
  <div class="page-title">Акции</div>

  <div class="catalog-sort">
    <div class="catalog-sort-text">Сортировка:</div>
    <form id="catalog-sort-form" class="catalog-sort-form" action="/catalog/{{ $category->slug }}" method="get">
      <select name="sort" id="catalog-sort-select" class="catalog-sort-select">
        <option value="alfabet">По алфавиту</option>
        <option value="asc" {{ request()->sort == "asc" ? "selected" : "" }}>Сначала дешевые</option>
        <option value="desc" {{ request()->sort == "desc" ? "selected" : "" }}>Сначала дорогие</option>
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