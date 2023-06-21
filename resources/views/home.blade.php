@extends('layouts.main')

@section('title', 'Купить семена с доставкой по всей России')

@section('style')
  <link rel="stylesheet" href="{{ asset('/css/swiper-bundle.min.css') }}">
@endsection

@section('content')

<div class="home">

  <div class="main-section">

    <div class="main-slider-wrapper">
      <div class="main-slider swiper">
        <div class="swiper-wrapper">
          @foreach($sliders as $slide)
            <div class="main-slider-item swiper-slide">
              <div class="slider-item-image">
                <img src="{{ Storage::url($slide->image) }}" alt="">
              </div>
              <div class="swiper-slide-content">
                <div class="slider-item-title">{{ $slide->title }}</div>
                <div class="slider-item-subtitle">{{ $slide->text }}</div>
              </div>
              <div class="view-catalog-btn">
                <span class="view-catalog-btn__text">Смотреть каталог</span>
                <a href="{{ route('catalog') }}" class="full-link"></a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="button-next main-button-next">
        <div class="arrow-right"></div>
      </div>
    </div>

    <div class="categories-wrapper">
      <div class="categories">
        <div class="category-item orange-bg">
          <div class="categories-item-title">Огурцы</div>
          <div class="categories-item-image">
            <img src="/img/category-cucumber.png" alt="">
          </div>
          <a href="{{ route('catalog', ['category' => 'ogurcy']) }}" class="full-link"></a>
        </div>
        <div class="category-item green-bg">
          <div class="categories-item-title">Перцы</div>
          <div class="categories-item-image">
            <img src="/img/category-pepper.png" alt="">
          </div>
          <a href="{{ route('catalog', ['category' => 'percy']) }}" class="full-link"></a>
        </div>
        <div class="category-item purple-bg">
          <div class="categories-item-title">Томаты</div>
          <div class="categories-item-image">
            <img src="/img/category-tomatoes.png" alt="">
          </div>
          <a href="{{ route('catalog', ['category' => 'tomaty']) }}" class="full-link"></a>
        </div>
        <div class="category-item red-bg">
          <div class="categories-item-title">Овощи</div>
          <div class="categories-item-image">
            <img src="/img/category-vegetables.png" alt="">
          </div>
          <a href="{{ route('catalog', ['category' => 'ovoshchi']) }}" class="full-link"></a>
        </div>
        <div class="category-item orange-bg">
          <div class="categories-item-title">Цветы</div>
          <div class="categories-item-image">
            <img src="/img/category-flovers.png" alt="">
          </div>
          <a href="{{ route('catalog', ['category' => 'cvety']) }}" class="full-link"></a>
        </div>
        <div class="category-item green-bg">
          <div class="categories-item-title">Ягоды</div>
          <div class="categories-item-image">
            <img src="/img/category-berries.png" alt="">
          </div>
          <a href="{{ route('catalog', ['category' => 'yagody']) }}" class="full-link"></a>
        </div>
      </div>
    </div>

    <div class="grey-section">
      <div class="flex-container">
        <div class="grey-section__image">
          <img src="/img/first-order-percent.png" alt="">
        </div>
        <div class="grey-section__text">Скидка 25% на первый заказ</div>
      </div>
    </div>
  </div>

  <div class="popular-categories-section section">
    <div class="section-title">
      <div class="section-title__text">Хит недели</div>
      <div class="all-btn">
        <span class="all-btn__text">Все</span>
        <div class="corner-right"></div>
        <a href="#" class="full-link"></a>
      </div>
    </div>
    <div class="popular-categories">
      <div class="row">
        @foreach($products as $product)
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

  <div class="promo-section section">
    <div class="section-title">
      <div class="section-title__text">Акции</div>
    </div>
    <div class="promo">
      <div class="row">
        <div class="col-md-4">
          <div class="promo-item">
            <div class="bg-image">
              <img src="/img/promo-item-img1.jpg" alt="">
            </div>
            <div class="green-figure">
              <img src="/img/promo-item-figure.png" alt="">
            </div>
            <div class="promo-item__text">Семена Аргентинской и Бразильской картошки</div>
            <div class="discount">
              <span class="discount-text">- 45</span>
              <span class="discount-percent">%</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="promo-item">
            <div class="bg-image">
              <img src="/img/promo-item-img2.jpg" alt="">
            </div>
            <div class="green-figure">
              <img src="/img/promo-item-figure.png" alt="">
            </div>
            <div class="promo-item__text">Перец «Уралочка»</div>
            <div class="discount">
              <span class="discount-text">- 25</span>
              <span class="discount-percent">%</span>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="promo-item">
            <div class="bg-image">
              <img src="/img/promo-item-img3.jpg" alt="">
            </div>
            <div class="green-figure">
              <img src="/img/promo-item-figure.png" alt="">
            </div>
            <div class="promo-item__text">Капуста из Китая</div>
            <div class="discount">
              <span class="discount-text">- 15</span>
              <span class="discount-percent">%</span>
            </div>
          </div>
        </div>
      </div>
    
    
    </div>

  </div>

  <div class="new-products-section">
    <div class="section-title">
      <div class="section-title__text">Новинки</div>
    </div>
    <div class="new-products">
      <div class="row">
        @foreach($products as $product)
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
  </div>

</div>

@endsection

@section('script')
  <script src="{{ asset('/js/swiper-bundle.min.js') }}"></script>
@endsection