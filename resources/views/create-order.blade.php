@extends('layouts.main')

@section('title', 'Оформление заказа')

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
    <a href="/cart">корзина</a>
  </div>
  <div class="arrow"></div>
  <div class="active">оформление заказа</div>
</div>

<div class="create-order js-create-order">

  <div class="cart-title page-title">Оформление <span class="green-text">заказа</span></div>
  
  @if($errors->any())
    <div class="alert alert-danger cart-errors">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
    
  <form id="place-order-form" class="form" action="/create-order-handler" method="post">

    <div class="create-order-item">
      <div class="create-order-item-title">1. Выберите способ доставки</div>
      <div class="create-order-delivery">
        <div class="row">
          <div class="col-md-6">
            <div class="dp-item delivery-item">
              <div class="dp-item__image delivery-item__image">
                <img src="/img/create-order-cdek.png" alt="">
              </div>
              <div class="dp-item__title delivery-item__title">СДЭК (в ПВЗ)</div>
              <div class="dp-item__description delivery-item__description">
                <div class="dp-item__text delivery-item__text">Стоимость доставки</div>
                <div class="dp-item__value delivery-item__value">
                  <span id="cdek-delivery-summ" class="dp-item__summ delivery-item__summ">0</span>
                  <span class="dp-item__text delivery-item__text">&#8381;</span>
                </div>
              </div>
              <div class="dp-item__description delivery-item__description">
                <div class="dp-item__text delivery-item__text">Срок доставки</div>
                <div class="dp-item__value delivery-item__value">
                  <span class="dp-item__summ delivery-item__summ">3-4</span>
                  <span class="dp-item__text delivery-item__text">дня</span>
                </div>
              </div>
              <div class="dp-item__radio delivery-item-radio">
                <input type="radio" name="delivery" id="delivery-cdek" class="custom-radio js-shipping-method" checked value="cdek">
                <label for="delivery-cdek" class="custom-radio-label"></label>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="dp-item delivery-item">
              <div class="dp-item__image delivery-item__image">
                <img src="/img/create-order-russian-post.png" alt="">
              </div>
              <div class="dp-item__title delivery-item__title">Почта России (в отделение)</div>
              <div class="dp-item__description delivery-item__description">
                <div class="dp-item__text delivery-item__text">Стоимость доставки</div>
                <div class="dp-item__value delivery-item__value">
                  <span id="russian-post-delivery-summ" class="dp-item__summ delivery-item__summ">0</span>
                  <span class="dp-item__currency delivery-item__currency">&#8381;</span>
                </div>
              </div>
              <div class="dp-item__description delivery-item__description">
                <div class="dp-item__text delivery-item__text">Срок доставки</div>
                <div class="dp-item__value delivery-item__value">
                  <span class="dp-item__summ delivery-item__summ">3-4</span>
                  <span class="dp-item__currency delivery-item__currency">дня</span>
                </div>
              </div>
              <div class="dp-item__radio delivery-item-radio">
                <input type="radio" name="delivery" id="delivery-russian-post" class="custom-radio js-shipping-method" value="russian-post">
                <label for="delivery-russian-post" class="custom-radio-label"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="create-order-item">
      <div class="create-order-item-title">2. Информация о покупателе</div>
      <div class="customer-info">
        <div class="customer-info-item">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="first-name" class="label">Имя <span class="orange-text" title="обязательно">*</span></label>
                <input type="text" name="first-name" id="first-name" class="input-field" required min="3" max="20" autocomplete="on">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="last-name" class="label">Фамилия <span class="orange-text" title="обязательно">*</span></label>
                <input type="text" name="last-name" id="last-name" class="input-field" required min="3" max="30" autocomplete="on">
              </div>
            </div>
          </div>
        </div>
        <div class="customer-info-item">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="phone" class="label">Телефон <span class="orange-text" title="обязательно">*</span></label>
                <input type="text" name="phone" id="phone" class="input-field js-input-phone-mask" required size="18" autocomplete="on">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="email" class="label">Email <span class="orange-text" title="обязательно">*</span></label>
                <input type="email" name="email" id="email" class="input-field" required min="5" max="50" autocomplete="on">
              </div>
            </div>
          </div>
        </div>
        <div class="customer-info-item">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="city" class="label">Город <span class="orange-text" title="обязательно">*</span></label>
                <input type="text" name="city" id="city" class="input-field" required min="3" max="50" readonly value="{{ $city['city'] }}">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="postcode" class="label">Почтовый индекс <span id="postcode-required" class="orange-text postcode-required" title="обязательно">*</span></label>
                <input type="number" name="postcode" id="postcode" class="input-field input-number" min="100000" max="999999" autocomplete="on">
              </div>
            </div>
          </div>
        </div>
        <div class="customer-info-item">
          <div class="form-group">
            <label for="address" class="label">Адрес <span class="orange-text" title="обязательно">*</span></label>
            <input type="text" name="address" id="address" class="input-field" required min="5" max="150" autocomplete="on">
          </div>
        </div>
        <div id="cdek-pvz-wrapper" class="customer-info-item cdek-pvz-wrapper active">
          <div class="form-group">
            <label class="label">Пункт выдачи заказов <span class="orange-text" title="обязательно">*</span></label>
            <select name="cdek-pvz" id="cdek-pvz-select" class="cdek-pvz-select">
              <option value="" selected disabled></option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="create-order-item">
      <div class="create-order-item-title">3. Состав заказа</div>
      <div class="create-order-products">

        @foreach($products as $product)
          <div class="product-item">
            <!-- <div class="product-item__image">
              <img src="{{-- asset('storage/uploads/products/' . $product->image) --}}" alt="">
            </div> -->
            <div class="product-item__content">
              <div class="product-item__title">{{ $product->title}}</div>
              <div class="product-item__quantity">
                <span class="product-item__quantity-value js-item-quantity">{{ $product->quantity }}</span>
                <span class="product-item__quantity-text">&nbsp;шт</span>
              </div>
            </div>
            <div class="js-item-weight hidden">{{ $product->weight }}</div>

            @if($product->promo_price)
              <!-- <div class="js-item-price hidden">{{ str_replace('.0', '', $product->promo_price) }}</div> -->
              <div class="js-item-price hidden">{{ $product->promo_price }}</div>
            @else
              <!-- <div class="js-item-price hidden">{{ str_replace('.0', '', $product->retail_price) }}</div> -->
              <div class="js-item-price hidden">{{ $product->retail_price }}</div>
            @endif

            @if($product->promo_price)
              <!-- <div class="js-item-old-price hidden">{{ str_replace('.0', '', $product->retail_price) }}</div> -->
              <div class="js-item-old-price hidden">{{ $product->retail_price }}</div>
            @endif
            
          </div>
        @endforeach

      </div>
    </div>

    <div class="create-order-item">
      <div class="create-order-item-title">4. Выберите способ оплаты</div>
      <div class="create-order-payment">
        <div class="row">
        <div class="col-md-6">
            <div class="dp-item payment-item">
              <div class="dp-item__image payment-item__image">
                <img src="/img/create-order-yookassa.png" alt="">
              </div>
              <div class="dp-item__title payment-item__title">Онлайн оплата</div>
              <div class="payment-item__description">
                <p>Привычная система онлайн-оплаты: банковской картой, через интернет-банк или электронный кошелек.</p>
              </div>
              <div class="dp-item__radio payment-item-radio">
                <input type="radio" name="payment" id="payment-yookassa" class="custom-radio" checked value="yookassa">
                <label for="payment-yookassa" class="custom-radio-label"></label>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="dp-item payment-item">
              <div class="dp-item__image payment-item__image">
                <img src="/img/create-order-cdek.png" alt="">
              </div>
              <div class="dp-item__title payment-item__title">Оплата на Пункте Выдачи CDEK</div>
              <div class="payment-item__description">
                <p>Оплата производится при получении посылки на ПВ CDEK, или Курьеру CDEK.</p>
                <p>Стоимость доставки насчитывается при оформлении заказа.</p>
              </div>
              <div class="dp-item__radio payment-item-radio">
                <input type="radio" name="payment" id="payment-cdek" class="custom-radio" value="cdek">
                <label for="payment-cdek" class="custom-radio-label"></label>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="dp-item payment-item payment-item-last">
              <div class="dp-item__image payment-item__image">
                <img src="/img/create-order-russian-post.png" alt="">
              </div>
              <div class="dp-item__title payment-item__title">Оплата Наложенным платежом на «Почте России»</div>
              <div class="payment-item__description">
                <p>Оплата производится при получении посылки в отделении Почты России.</p>
                <p>Доступна для заказов на сумму не более 2 000 рублей, более этой суммы только предоплата!</p>
              </div>
              <div class="dp-item__radio payment-item-radio">
                <input type="radio" name="payment" id="payment-russian-post" class="custom-radio" value="russian-post">
                <label for="payment-russian-post" class="custom-radio-label"></label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="cco-cart-aside cart-aside cart-total-aside">
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
          <span class="cart-total-aside__counter orange-text js-summary-discount">0</span>
          <span class="cart-total-aside__currency orange-text">&#8381;</span>
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
      <button id="place-order-btn" class="place-order-btn active">
        <div class="place-order-btn__text">Оформить заказ</div>
      </button>
    </div>
    <input type="hidden" name="summ" id="hidden-input-summ" value="">

    @csrf
  </form>

</div>

@endsection

@section('script')
  <script src="{{ asset('js/slimselect.min.js') }}"></script>
@endsection