@extends('layouts.main')

@section('title', 'Контакты')

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
  <div class="active">контакты</div>
</div>

<div class="kontakty">
  <div class="content-wrapper">
    <div class="kontakty-title page-title">Контакты</div>
    <div class="company-name">Общество с ограниченной ответственностью - ООО "Уральские Семена"</div>
    <div class="flex-container">
      <div class="kontakty-item">
        <div class="kontakty-item__title">Адрес</div>
        <div class="kontakty-item__text">
          <img src="/img/contacts-geolocation.svg" alt="">
          <span>456300 Россия, Челябинская область, город Миасс, Объездная дорога 4/48, офис 3.</span>
          </div>
      </div>
      <div class="kontakty-item">
        <div class="kontakty-item__title">Телефон</div>
        <div class="kontakty-item__text">
          <img src="/img/contacts-phone.svg" alt="">
          <span>+7 (902) 614-09-67</span>
        </div>
      </div>
      <div class="kontakty-item">
        <div class="kontakty-item__title">Эл. почта</div>
        <div class="kontakty-item__text">
          <img src="/img/contacts-email.svg" alt="">
          <span>info@semena-darom.ru</span>
        </div>
      </div>
    </div>
    <div class="kontakty-subtitle">Реквизиты</div>
    <div class="flex-container">
      <div class="kontakty-item">
        <div class="kontakty-item__title">ОГРН</div>
        <div class="kontakty-item__text">41177456098434</div>
      </div>
      <div class="kontakty-item">
        <div class="kontakty-item__title">ИНН</div>
        <div class="kontakty-item__text">7415099134</div>
      </div>
      <div class="kontakty-item">
        <div class="kontakty-item__title">КПП</div>
        <div class="kontakty-item__text">741501001</div>
      </div>
    </div>
    <div class="flex-container mb60">
      <div class="kontakty-item">
        <div class="kontakty-item__title">ПАО "Сбербанк"</div>
        <div class="kontakty-item__text">454048, г. Челябинск, ул. Энтузиастов, 9а.</div>
      </div>
      <div class="kontakty-item">
        <div class="kontakty-item__title">Расчетный счет</div>
        <div class="kontakty-item__text">40702810372000021827</div>
      </div>
      <div class="kontakty-item">
        <div class="kontakty-item__title">Кор счет</div>
        <div class="kontakty-item__text">30101810700000000602</div>
      </div>
    </div>

    <div class="map">
      <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A81307a1b8cec7e06bf9f9d518352f7464f896c561e2a2eb27539dacfcda47122&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
    </div>

  </div>
  
</div> 

@endsection