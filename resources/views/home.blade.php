@extends('layouts.main')

@section('title', 'Купить семена с доставкой по всей России')

@section('content')

<div class="home">
  <div class="content-wrapper">

    <div class="popular-categories-section section">
      <div class="section-title">
        <div class="section-title__text">Хит недели</div>
      </div>
      <div class="popular-categories">
        <div class="row">
          @foreach($products as $pr)
            <div class="col-md-3">
              <div class="products-item">
                <div class="products-item__image">
                  <a href="/catalog/{{ $pr->slug }}" class="products-item__link">
                    <img src="{{ asset('storage/uploads/products/' . $pr->image) }}" alt="">
                  </a>
                </div>
                <a href="/catalog/{{ $pr->slug }}" class="products-item__title">{{ $pr->short_title }}</a>
                <div class="products-item__text">{!! $pr->short_text !!}</div>
                <div class="products-item-price-wrapper">
                  <div class="products-item__price">
                    <span class="products-item__value">{{ $pr->retail_price }}</span>
                    <span class="products-item__currency">&#8381;</span>
                  </div>
                </div>
                <div class="add-to-cart-btn add-to-cart" data-id="{{ $pr->id }}">Добавить в корзину</div>
                <div class="add-to-favorites">
                  <svg width="23" height="21" viewBox="0 0 23 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.9177 19.7475L2.65498 11.0978C0.327621 8.66145 0.474179 4.66658 2.97318 2.42425C5.45236 0.199689 9.21145 0.631665 11.1706 3.36625L11.5 3.82598L11.8294 3.36625C13.7886 0.631665 17.5476 0.199689 20.0268 2.42425C22.5258 4.66658 22.6724 8.66145 20.345 11.0978L12.0823 19.7475C11.7607 20.0842 11.2393 20.0842 10.9177 19.7475Z" stroke="#CFCFCF" stroke-linecap="round" stroke-linejoin="round"/>
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
          <div class="col-md-3">
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
          <div class="col-md-3">
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
          <div class="col-md-3">
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

  </div>
</div>

@endsection