@extends('layouts.main')

@section('title', $product->title)

@section('style')
  <!-- <link rel="stylesheet" href="{{ asset('/css/swiper-bundle.min.css') }}"> -->
@endsection

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
  @if($product->category->title)
    <div class="arrow"></div>
    <div class="parent">
      <a href="{{ route('catalog', ['category' => $product->category->slug]) }}">{{ $product->category->title }}</a>
    </div>
  @endif
  <div class="arrow"></div>
  <div class="active">{{ $product->title }}</div>
</div>

<div class="single-product">

  <div class="single-product-title">{!! $product->color_title !!}</div>
  
  <div class="add-to-favourites-wrapper">
    <div class="add-to-favourites" data-id="{{ $product->id }}">
      <svg width="23" height="21" viewBox="0 0 23 21" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.9177 19.7475L2.65498 11.0978C0.327621 8.66145 0.474179 4.66658 2.97318 2.42425C5.45236 0.199689 9.21145 0.631665 11.1706 3.36625L11.5 3.82598L11.8294 3.36625C13.7886 0.631665 17.5476 0.199689 20.0268 2.42425C22.5258 4.66658 22.6724 8.66145 20.345 11.0978L12.0823 19.7475C11.7607 20.0842 11.2393 20.0842 10.9177 19.7475Z" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
      <span class="add-to-favourites__text">В избранное</span>
    </div>
  </div>

  <div class="single-product-content">
    <div class="row">
      <div class="col-md-3">
        <div class="single-image">
          <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
        </div>
        <div class="single-product-gallery">
          <div class="single-product-gallery-item">
            <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
          </div>
          <div class="single-product-gallery-item">
            <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
          </div>
          <div class="single-product-gallery-item">
            <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="single-product-price">
          @if($product->promo_price > 0)
            <div class="products-item__price products-item__new-price">
              <span class="products-item__value">{{ $product->promo_price }}</span>
              <span class="products-item__currency">&#8381;</span>
            </div>
            <div class="products-item__price products-item__old-price item__old-price">
              <span class="products-item__value">{{ $product->retail_price }}</span>
              <span class="products-item__currency">&#8381;</span>
              <span class="line-through"></span>
            </div>
          @else
            <div class="products-item__price">
              <span class="products-item__value">{{ $product->retail_price }}</span>
              <span class="products-item__currency">&#8381;</span>
            </div>
          @endif
          <div class="single-product-price__text">за 1 упаковку</div>
        </div>
        <div class="add-to-cart-wrapper">
          <button class="add-to-cart-btn add-to-cart" data-id="{{ $product->id }}">Добавить в корзину</button>
          <div class="single-product-quantity">
            <button type="button" class="quantity-button quantity-minus" data-id="{{ $product->id }}">
              <div class="circle"></div>
            </button>
            <input class="quantity-number" type="number" name="quantity" max="{{ $product->stock }}" min="1" step="1" data-id="{{ $product->id }}" value="{{ $product->quantity }}" readonly>
            <button type="button" class="quantity-button quantity-plus" data-id="{{ $product->id }}">
              <div class="circle"></div>
            </button>
          </div>
        </div>

        <div class="single-product-options single-product-category">
          <div class="single-product-options__frame">
            <div class="single-product-options__image">
              <img src="{{ asset('storage/uploads/categories/' . $product->category->image) }}" alt="">
            </div>
          </div>
          <div class="single-product-options__title">{{ $product->category->title }}</div>
        </div>

        @if($product->promo_price)
          <div class="single-product-options single-product-promo">
            <div class="single-product-options__frame">
              <div class="single-product-options__image">
                <img src="/img/single-product-percent.png" alt="">
              </div>
            </div>
            <div class="single-product-options__title">Акции</div>
          </div>
        @endif

        @if($product->property)
          <div class="single-product-options single-product-property">
            <div class="single-product-options__frame">
              <div class="single-product-options__image">
                <img src="/img/single-product-pepper.png" alt="">
              </div>
            </div>
            <div class="single-product-options__title">{{ $product->property }}</div>
          </div>
        @endif
        
        @if($product->brand)
          <div class="single-product-brand single-product-about">
            <div class="single-product-about-text">Бренд:</div>
            <div class="single-product-about-value">{{ $product->brand }}</div>
          </div>
        @endif

        @if($product->sku)
          <div class="single-product-sku single-product-about">
            <div class="single-product-about-text">Артикул:</div>
            <div class="single-product-about-value">{{ $product->sku }}</div>
          </div>
        @endif

        @if($product->weight)
          <div class="single-product-weight single-product-about">
            <div class="single-product-about-text">Вес:</div>
            <div class="single-product-about-value">{{ $product->weight }}&nbsp;гр.</div>
          </div>
        @endif

      </div>
    </div>
  </div>

  <div class="single-product-description">
    <div class="single-product-description__title single-product-about-text">Описание:</div>
    <div class="single-product-description__text">{!! $product->text !!}</div>
  </div>

  <div class="recommend-product">
    <div class="recommend-product-title">Рекомендуем также</div>
    <div class="row">
      @foreach($product->recommend_products as $product)
        <div class="col-md-4">
          <div class="regular-products-item">
            <div class="products-item__image">
              <a href="/catalog/{{ $product->slug }}" class="products-item__link">
                <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
              </a>
            </div>
            <a href="/catalog/{{ $product->slug }}" class="products-item__title">{{ $product->short_title }}</a>
            <div class="products-item__text">{!! $product->short_text !!}</div>
            <div class="products-item-price-wrapper">
              <div class="products-item__price">
                <span class="products-item__value">{{ $product->retail_price }}</span>
                <span class="products-item__currency">&#8381;</span>
              </div>
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

</div>

@endsection

@section('script')
  <!-- <script src="{{ asset('/js/swiper-bundle.min.js') }}"></script> -->
@endsection