@extends('layouts.main')

@section('title', 'Купить семена с доставкой по всей России')

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

    <div class="categories">
      <div class="categories-desktop hidden-mobile">
        <div class="category-item orange-bg">
          <div class="categories-item-title">Огурцы</div>
          <div class="categories-item-image">
            <img src="/img/category-cucumber.png" alt="">
          </div>
          <a href="/catalog/ogurec" class="full-link"></a>
        </div>
        <div class="category-item green-bg">
          <div class="categories-item-title">Перцы</div>
          <div class="categories-item-image">
            <img src="/img/category-pepper.png" alt="">
          </div>
          <a href="/catalog/perec-sladkii" class="full-link"></a>
        </div>
        <div class="category-item purple-bg">
          <div class="categories-item-title">Томаты</div>
          <div class="categories-item-image">
            <img src="/img/category-tomatoes.png" alt="">
          </div>
          <a href="/catalog/tomat" class="full-link"></a>
        </div>
        <div class="category-item red-bg">
          <div class="categories-item-title">Овощи</div>
          <div class="categories-item-image">
            <img src="/img/category-vegetables.png" alt="">
          </div>
          <a href="/catalog/ovoshhi" class="full-link"></a>
        </div>
        <div class="category-item orange-bg">
          <div class="categories-item-title">Цветы</div>
          <div class="categories-item-image">
            <img src="/img/category-flovers.png" alt="">
          </div>
          <a href="/catalog/cvety" class="full-link"></a>
        </div>
        <div class="category-item green-bg">
          <div class="categories-item-title">Ягоды</div>
          <div class="categories-item-image">
            <img src="/img/category-berries.png" alt="">
          </div>
          <a href="/catalog/yagody" class="full-link"></a>
        </div>
      </div>

      <div class="categories-slider swiper hidden-desktop">
        <div class="swiper-wrapper">
          <div class="swiper-slide category-item orange-bg">
            <div class="categories-item-title">Огурцы</div>
            <div class="categories-item-image">
              <img src="/img/category-cucumber.png" alt="">
            </div>
            <a href="/catalog/ogurec" class="full-link"></a>
          </div>
          <div class="swiper-slide category-item green-bg">
            <div class="categories-item-title">Перцы</div>
            <div class="categories-item-image">
              <img src="/img/category-pepper.png" alt="">
            </div>
            <a href="/catalog/perec-sladkii" class="full-link"></a>
          </div>
          <div class="swiper-slide category-item purple-bg">
            <div class="categories-item-title">Томаты</div>
            <div class="categories-item-image">
              <img src="/img/category-tomatoes.png" alt="">
            </div>
            <a href="/catalog/tomat" class="full-link"></a>
          </div>
          <div class="swiper-slide category-item red-bg">
            <div class="categories-item-title">Овощи</div>
            <div class="categories-item-image">
              <img src="/img/category-vegetables.png" alt="">
            </div>
            <a href="/catalog/ovoshhi" class="full-link"></a>
          </div>
          <div class="swiper-slide category-item orange-bg">
            <div class="categories-item-title">Цветы</div>
            <div class="categories-item-image">
              <img src="/img/category-flovers.png" alt="">
            </div>
            <a href="/catalog/cvety" class="full-link"></a>
          </div>
          <div class="swiper-slide category-item green-bg">
            <div class="categories-item-title">Ягоды</div>
            <div class="categories-item-image">
              <img src="/img/category-berries.png" alt="">
            </div>
            <a href="/catalog/yagody" class="full-link"></a>
          </div>
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

  @if($hit_products->count() > 0)
    <div class="popular-categories-section section">
      <div class="section-title">
        <div class="section-title__text">Хит недели</div>
      </div>
      <div class="popular-categories">
        <div class="row">
          @foreach($hit_products as $product)
            <!-- <div class="col-md-3 col-6 {{-- $loop->last ? 'd-md-none' : '' --}}"> -->
            <div class="col-md-3 col-6">
              @include('regular-products-item')
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  @if($promos->count() == 3)
    <div class="promo-section section">
      <div class="section-title">
        <div class="section-title__text">Акции</div>
      </div>
      <div class="promo-desktop hidden-mobile">
        <div class="row">
          @foreach($promos as $promo)
            <div class="col-sm-4">
              <div class="promo-item">
                <div class="bg-image">
                  <img src="{{ Storage::url($promo->image) }}" alt="">
                </div>
                <div class="green-figure">
                  <img src="/img/promo-item-figure.png" alt="">
                </div>
                <div class="promo-item__text">{{ Str::words($promo->title, 8, '...') }}</div>
                <div class="discount">
                  <span class="discount-text">- {{ $promo->discount }}</span>
                  <span class="discount-percent">%</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="promo-slider swiper hidden-desktop">
        <div class="swiper-wrapper">
          @foreach($promos as $promo)
            <div class="swiper-slide promo-item">
              <div class="bg-image">
                <img src="{{ Storage::url($promo->image) }}" alt="">
              </div>
              <div class="green-figure">
                <img src="/img/promo-item-figure.png" alt="">
              </div>
              <div class="promo-item__text">{{ Str::words($promo->title, 8, '...') }}</div>
              <div class="discount">
                <span class="discount-text">- {{ $promo->discount }}</span>
                <span class="discount-percent">%</span>
              </div>
            </div>
            @endforeach
        </div>
      </div>

    </div>
  @endif

  <div class="new-products-section">
    <div class="section-title">
      <div class="section-title__text">Новинки</div>
    </div>
    <div class="new-products">
      <div class="row">
        @foreach($new_products as $product)
          <!-- <div class="col-md-3 col-6 {{-- $loop->last ? 'd-md-none' : '' --}}"> -->
          <div class="col-md-3 col-6">
            @include('regular-products-item')
          </div>
        @endforeach
      </div>
    </div>
  </div>

</div>

@endsection