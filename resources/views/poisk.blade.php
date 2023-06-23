@section('title', 'Поиск')

@extends('layouts.main')

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
  <div class="active">поиск</div>
</div>

<div class="poisk">

  @if (count($products) > 0)
    <div class="poisk-title page-title">Результаты поиска «{{ $search_query }}»</div>
    <div class="products">
      <div class="row">
        @foreach($products as $product)
          <div class="col-md-4">
            <div class="regular-products-item">
              <div class="products-item__image">
                <a href="/catalog/{{ $product->slug }}" class="products-item__link">
                  <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
                </a>
              </div>
              <a href="/catalog/{{ $product->slug }}" class="products-item__title">{{ $product->title }}</a>
              <div class="products-item__text">{{ $product->short_text }}</div>
              <div class="products-item-price-wrapper">
                @if($product->promo_price)
                  <div class="products-item__price products-item__promo-price">
                    <span class="products-item__value">{{ $product->promo_price }}</span>
                    <span class="products-item__currency">&#8381;</span>
                    <div class="products-item__percent">
                      <img src="/img/product-percent-icon.png" alt="">
                    </div>
                  </div>
                  <div class="products-item__old-price item__old-price">
                    <span class="products-item__value">{{ $product->retail_price }}</span>
                    <span class="products-item__currency">&#8381;</span>
                    <span class="line-through"></span>
                  </div>
                @else
                  <div class="products-item__price">
                    <span class="products-item__value">{{ $product->retail_price }}</span>
                    <span class="products-item__currency">&#8381;</span>
                    <div class="products-item__percent">
                      <img src="/img/product-new-icon.png" alt="">
                    </div>
                  </div>
                @endif
              </div>
              <div class="add-to-cart-btn add-to-cart" data-id="{{ $product->id }}">Добавить в корзину</div>
              <div class="add-to-favourites" data-id="{{ $product->id }}">
                <svg width="23" height="21" viewBox="0 0 23 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10.9177 19.7475L2.65498 11.0978C0.327621 8.66145 0.474179 4.66658 2.97318 2.42425C5.45236 0.199689 9.21145 0.631665 11.1706 3.36625L11.5 3.82598L11.8294 3.36625C13.7886 0.631665 17.5476 0.199689 20.0268 2.42425C22.5258 4.66658 22.6724 8.66145 20.345 11.0978L12.0823 19.7475C11.7607 20.0842 11.2393 20.0842 10.9177 19.7475Z" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @else
    <div class="poisk-title page-title">По запросу «{{ $search_query }}» ничего не найдено</div>
    <div class="no-products-found">
      <div class="no-products-found-content">
        <div class="no-products-found-image">
          <img src="/img/no-products-found.svg" alt="">
        </div>
      </div>
      <div class="no-products-found-content">
        <div class="no-products-found-text">К сожалению такого товара нет. Возможно он появиться позже.</div>
      </div>
      <div class="no-products-found-content">
        <a href="{{ route('catalog') }}" class="no-products-found-btn">
          <span class="cart-is-empty-btn__text">Вернуться в каталог</span>
        </a>
      </div>
    </div>
  @endif

</div>

@endsection