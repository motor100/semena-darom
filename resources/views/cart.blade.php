@extends('layouts.main')

@section('title', 'Корзина')

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
  <div class="active">корзина</div>
</div>

<div class="cart js-cart-page">

  <div class="cart-title page-title">Корзина</div>

  @if(count($products) > 0)
    <div class="cf-clear">
      <div class="cf-clear__image">
        <img src="/img/cf-trash.svg" alt="">
      </div>
      <a href="/clear-cart" class="cf-clear__link">Очистить корзину</a>
    </div>
  @endif

  <div class="min-order">
    <div class="min-order-text">Еще <span class="min-order-counter"></span> ₽ до минимального заказа</div>
    <div class="min-order-line">
      <div class="min-order-grey-line"></div>
      <div class="min-order-green-line"></div>
    </div>
    <div class="cart-price">
      <img src="/img/cart-price.png" class="cart-price-image" alt="">
      <span class="cart-price-text">
        <span id="min-order-value" class="cart-price-text__value"></span>
        <span class="cart-price-text__currency">&#8381;</span>
      </span>
    </div>
  </div>

  @if(count($products) > 0)
    <div class="cf-items-wrapper">
      @foreach($products as $product)
        <div class="cf-item">
          <div class="cf-item__image">
            <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
          </div>
          <div class="cf-item__content">
            <div class="cf-item__top">
              <div class="cf-item__title-wrapper">
                <div class="cf-item__title">{{ $product->title }}</div>
                @if($product->promo_price)
                  <div class="cf-item__price red-text">
                    <!-- <span class="cf-item__value js-item-price">{{ str_replace('.0', '', $product->promo_price) }}</span> -->
                    <span class="cf-item__value js-item-price">{{ $product->promo_price }}</span>
                    <span class="cf-item__currency">&#8381;</span>
                  </div>
                @else
                  <div class="cf-item__price">
                    <!-- <span class="cf-item__value js-item-price">{{ str_replace('.0', '', $product->retail_price) }}</span> -->
                    <span class="cf-item__value js-item-price">{{ $product->retail_price }}</span>
                    <span class="cf-item__currency">&#8381;</span>
                  </div>
                @endif             
              </div>
              @if($product->promo_price)
                <div class="cf-item__promo">
                  <div class="cf-item__promo-text red-text">Акция</div>
                  <div class="cf-item__old-price item__old-price">
                    <!-- <span class="cf-item__value js-item-price js-item-old-price">{{ str_replace('.0', '', $product->retail_price) }}</span> -->
                    <span class="cf-item__value js-item-price js-item-old-price">{{ $product->retail_price }}</span>
                    <span class="cf-item__currency">&#8381;</span>
                    <span class="line-through"></span>
                  </div>
                </div>
              @endif
            </div>
            <div class="cf-item__bottom">
              <div class="add-to add-to-favourites" data-id="{{ $product->id }}">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M23.4637 33.6581L14.7201 24.5531C12.2572 21.9885 12.4123 17.7834 15.0568 15.423C17.6803 13.0814 21.6581 13.5361 23.7313 16.4146L24.0799 16.8985L24.4284 16.4146C26.5017 13.5361 30.4794 13.0814 33.103 15.423C35.7474 17.7834 35.9026 21.9885 33.4397 24.5531L24.6961 33.6581C24.3558 34.0124 23.804 34.0124 23.4637 33.6581Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="add-to-favourites__text">В избранное</span>
              </div>
              <form class="form rm-from-form" action="/rmfromcart"  method="post">
                <input type="hidden" name="id" value="{{ $product->id }}">
                @csrf
                <button type="submit" class="rm-from-btn">
                  <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.75 15.75L32.25 32.25" stroke="#B3B3B3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M32.25 15.75L15.75 32.25" stroke="#B3B3B3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span class="rm-from-btn__text">Удалить</span>
                </button>
              </form>
              <div class="cf-item__quantity">
                <button type="button" class="quantity-button quantity-minus" data-id="{{ $product->id }}">
                  <div class="circle"></div>
                </button>
                <input class="quantity-number js-item-quantity" type="number" name="quantity" max="{{ $product->stock }}" min="1" step="1" data-id="{{ $product->id }}" value="{{ $product->quantity }}" readonly>
                <button type="button" class="quantity-button quantity-plus" data-id="{{ $product->id }}">
                  <div class="circle"></div>
                </button>
              </div>
              <div class="cart-item__weight js-item-weight hidden">{{ $product->weight }}</div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    @if(isset($is_cart))
      <div class="cco-cart-aside cart-aside cart-total-aside hidden">
        <div class="cart-total-aside__title">Итого</div>
        <div class="grey-line"></div>
        <div class="cart-total-aside-item">
          <div class="cart-total-aside__text">Товаров</div>
          <div class="cart-total-aside-value">
            <span class="cart-total-aside__counter js-summary-quantity">0</span>
          </div>
        </div>
        <div class="cart-total-aside-item">
          <div class="cart-total-aside-text">Сумма</div>
          <div class="cart-total-aside-value">
            <span class="cart-total-aside__counter js-summary-summ-before-discount">0</span>
            <span class="cart-total-aside__currency">&#8381;</span>
          </div>
        </div>
        <div class="cart-total-aside-item">
          <div class="cart-total-aside-text">Скидка</div>
          <div class="cart-total-aside-value">
            <span class="cart-total-aside__counter red-text js-summary-discount">0</span>
            <span class="cart-total-aside__currency red-text">&#8381;</span>
          </div>                
        </div>
        <div class="grey-line"></div>
        <div class="cart-summ-aside">
          <div class="cart-summ-aside-text">К оплате</div>
          <div class="cart-summ-aside-value">
            <span class="cart-summ-aside__counter js-summary-summ">0</span>
            <span class="cart-summ-aside__currency">&#8381;</span>
          </div>
        </div>
        <div class="place-order-btn js-place-order-btn">
          <div class="place-order-btn__text">Перейти к оформлению заказа</div>
          <a href="#" class="full-link place-order-btn__link"></a>
        </div>
      </div>
    @else
      <div class="cco-cart-aside cart-aside">
        <div class="cart-aside-title-wrapper">
          <div class="cart-aside-title">Корзина</div>
          <div class="cart-aside-clear-cart">
            <a href="/clear-cart" class="cart-aside-clear-cart__link">очистить</a>
          </div>
        </div>

        <div class="cart-aside-products">
          @if(isset($cart_count))
            @foreach($products_in_cart as $product)
              <div class="products-item">
                <div class="products-item__image">
                  <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="">
                </div>
                <div class="products-item__content">
                  <div class="products-item__title">{{ $product->short_title }}</div>
                  <div class="products-item-price-wrapper">
                    @if($product->promo_price)
                      <div class="products-item__price products-item__promo-price red-text">
                        <span class="products-item__value">{{ $product->promo_price }}</span>
                        <span class="products-item__currency">&#8381;</span>
                      </div>
                      <div class="products-item__old-price item__old-price">
                        <span class="products-item__value js-item-old-price">{{ $product->retail_price }}</span>
                        <span class="products-item__currency">&#8381;</span>
                        <span class="line-through"></span>
                      </div>
                    @else
                      <div class="products-item__price products-item__retail-price">
                        <span class="products-item__value">{{ $product->retail_price }}</span>
                        <span class="products-item__currency">&#8381;</span>
                        <span class="line-through"></span>
                      </div>
                    @endif
                  </div>
                  
                </div>
                <div class="products-item__quantity">{{ $product->quantity }}</div>
              </div>
            @endforeach
          @else
            <div class="cart-aside-is-empty-image">
              <img src="/img/cart-aside-is-empty.svg" alt="">
            </div>
            <div class="cart-aside-is-empty-text">В корзине товаров нет</div>
          @endif
        </div>

        <div class="grey-line"></div>
        @if(isset($cart_count))
          <div class="place-order-btn active">
        @else
          <div class="place-order-btn">
        @endif
          <div class="place-order-btn__text">Оформить заказ</div>
          <div class="place-order-btn__total">
            <span class="place-order-btn__summ">0</span>
            <span class="place-order-btn__currency">&#8381;</span>
          </div>
          <a href="/cart" class="full-link"></a>
        </div>
      </div>
    @endif
    
  @else
    <div class="cart-is-empty">
      <div class="cart-is-empty-content cf-is-empty-content">
        <div class="cart-is-empty-image">
          <img src="/img/cart-is-empty.svg" alt="">
        </div>
      </div>
      <div class="cart-is-empty-content cf-is-empty-content">
        <div class="cf-is-empty-text">УПС.... В вашей корзине ничего нет(</div>
      </div>
      <div class="cart-is-empty-content cf-is-empty-content cf-is-empty-btns">
        <div class="cf-is-empty-btn cf-is-empty-back-btn" onclick="history.back();">
          <span class="cf-is-empty-btn__text">Вернуться назад</span>
        </div>
        <a href="{{ route('home') }}" class="cf-is-empty-btn cf-is-empty-home-btn">
          <span class="cf-is-empty-btn__text">Главная</span>
        </a>
      </div>
    </div>
  @endif

</div>

@endsection