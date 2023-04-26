@extends('layouts.main')

@section('title', 'Контакты')

@section('content')

<div class="breadcrumbs">
  <div class="container">
    <div class="parent">
      <a href="{{ route('home') }}">главная страница</a>
    </div>
    <div class="arrow"></div>
    <div class="active">контакты</div>
  </div>
</div>

<div class="kontakty">
  <div class="page-title">Контакты</div>

  <div class="content-wrapper">

    <p>Общество с ограниченной ответственностью - ООО "Уральские Семена"</p>
    <p>Адрес: 456300 Россия, Челябинская область, город Миасс, Объездная дорога 4/48, офис 3.</p>
    <p>Телефон: +7 (902) 614-09-67</p>
    <p>E-mail: info@semena-darom.ru</p>
    <p>ИНН: 7415099134</p>
    <p>ОГРН: 1177456098434</p>
    <p>КПП: 741501001</p>
    <p>Расчетный счет: 40702810372000021827</p>
    <p>ПАО "Сбербанк": 454048, г. Челябинск, ул. Энтузиастов, 9а.</p>
    <p>БИК банка: 047501602</p>
    <p>Кор счет: 30101810700000000602</p>

    <div class="map">
      <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A81307a1b8cec7e06bf9f9d518352f7464f896c561e2a2eb27539dacfcda47122&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
    </div>

  </div>
  
</div> 

@endsection