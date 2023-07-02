@extends('layouts.main')

@section('title', 'Оформление заказа')

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
    <a href="/cart">корзина</a>
  </div>
  <div class="arrow"></div>
  <div class="active">оформление заказа</div>
</div>

<div class="create-order">

  <div class="cart-title page-title">Оформление <span class="green-text">заказа</span></div>
  
  <!-- 
  @if($errors->any())
    <div class="errors-wrapper">
      <div class="container">
        <div class="alert alert-danger cart-errors">
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  @endif
   -->  

   <div class="create-order-item">
    <div class="create-order-item-title">1. Выберите способ доставки</div>
    <div class="create-order-item-delivery">
      <div class="row">
        <div class="col-6">
          <div class="delivery-item">
            <div class="delivery-item__image">
              <img src="/img/create-order-russian-post.png" alt="">
            </div>
            <div class="delivery-item__title">Почта России (в отделение)</div>
            <div class="delivery-item__description">
              <div class="delivery-item__text">Стоимость доставки</div>
              <div class="delivery-item__value">
                <span class="delivery-item__summ">280</span>
                <span class="delivery-item__currency">&#8381;</span>
              </div>
            </div>
            <div class="delivery-item__description">
              <div class="delivery-item__text">Срок доставки</div>
              <div class="delivery-item__value">
                <span class="delivery-item__summ">3</span>
                <span class="delivery-item__currency delivery-item__days">дня</span>
              </div>
            </div>
            <div class="delivery-item-checkbox">
              <input type="checkbox" id="russian-post-checkbox" class="custom-checkbox">
              <label for="russian-post-checkbox" class="custom-checkbox-label"></label>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="delivery-item">
            <div class="delivery-item__image">
              <img src="/img/create-order-sdek.png" alt="">
            </div>
            <div class="delivery-item__title">СДЭК (в отделение)</div>
            <div class="delivery-item__description">
              <div class="delivery-item__text">Стоимость доставки</div>
              <div class="delivery-item__value">
                <span class="delivery-item__summ">344</span>
                <span class="delivery-item__currency">&#8381;</span>
              </div>
            </div>
            <div class="delivery-item__description">
              <div class="delivery-item__text">Срок доставки</div>
              <div class="delivery-item__value">
                <span class="delivery-item__summ">3-4</span>
                <span class="delivery-item__currency delivery-item__days">дня</span>
              </div>
            </div>
            <div class="delivery-item-checkbox">
              <input type="checkbox" id="sdek-checkbox" class="custom-checkbox">
              <label for="sdek-checkbox" class="custom-checkbox-label"></label>
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
          <div class="col-6">
            <div class="form-group">
              <label for="first-name" class="label">Имя</label>
              <input type="text" name="first-name" id="first-name" class="input-field" placeholder="Имя">
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="last-name" class="label">Фамилия</label>
              <input type="text" name="last-name" id="last-name" class="input-field" placeholder="Фамилия">
            </div>
          </div>
        </div>
      </div>
      <div class="customer-info-item">
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="phone" class="label">Телефон</label>
              <input type="text" name="phone" id="phone" class="input-field" placeholder="Телефон">
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="email" class="label">Email</label>
              <input type="email" name="last-name" id="email" class="input-field" placeholder="Email">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="create-order-item">
    <div class="create-order-item-title">3. Состав заказа</div>

  </div>

</div>

@endsection