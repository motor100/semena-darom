@extends('layouts.main')

@section('title', $category->title)

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
  <div class="arrow"></div>
  <div class="active">{{ $category->title }}</div>
</div>

<div class="category-page catalog-page">
  <div class="page-title">{{ $category->title }}</div>

  @if(count($child_categories) > 0)
    <div class="catalog-nav-wrapper">
      <div class="catalog-nav">
        <div class="catalog-nav-top-row">
          <div class="aside-nav-item">
            <div class="aside-nav-item__image">
              <img src="{{ asset('img/percent-icon.svg') }}" alt="">
            </div>
            <div class="aside-nav-item__title">Акции</div>
            <a href="/akcii" class="full-link"></a>
          </div>
          <div class="aside-nav-item">
            <div class="aside-nav-item__image">
              <img src="{{ asset('img/package-icon.svg') }}" alt="">
            </div>
            <div class="aside-nav-item__title">Новинки</div>
            <a href="/novinki" class="full-link"></a>
          </div>
        </div>
        <div class="catalog-nav-categories">
          <div class="catalog-nav-category">
              <div class="aside-nav-item">
                <div class="aside-nav-item__image">
                  <img src="{{ Storage::url($category->image) }}" alt="">
                </div>
                <div class="aside-nav-item__title">{{ $category->title }}</div>
                <a href="{{ route('category', ['category' => $category->slug]) }}" class="full-link"></a>
              </div>
              <div class="catalog-nav-subcategories">
                @foreach($child_categories as $child_cat)
                  <a href="{{ route('category', ['category' => $child_cat->slug]) }}" class="catalog-nav-subcategory-title">{{ $child_cat->title }}</a>
                @endforeach
              </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="catalog-sort">
    <div class="catalog-sort-text">Сортировка:</div>
    <form id="catalog-sort-form" class="catalog-sort-form" action="/catalog/{{ $category->slug }}" method="get">
      
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