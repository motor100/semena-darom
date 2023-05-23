@extends('layouts.main')

@section('title', 'О компании')

@section('content')

<div class="breadcrumbs">
  <div class="container">
    <div class="back" onclick="history.back();">
      <span class="back-text">вернуться назад</span>
      <img src="/img/breadscrumbs-back.png" alt="">
    </div>
    <div class="parent">
      <a href="{{ route('home') }}">главная страница</a>
    </div>
    <div class="arrow"></div>
    <div class="active">о компании</div>
  </div>
</div>

<div class="o-kompanii">
  <div class="content-wrapper">
    <div class="o-kompanii-item">
      <div class="row">
        <div class="col-md-7">
          <div class="o-kompanii-title">Интернет-магазин СЕМЕНА <span class="light-green-text">ДАРОМ</span></div>
          <div class="o-kompanii-description">Интернет магазин «СЕМЕНАДАРОМ» (ООО «Уральские Семена») представляет на рынке семена от ЧЕЛЯБИНСКОЙ СЕЛЕКЦИОННОЙ СТАНЦИИ.</div>
        </div>
        <div class="col-md-5">
          <div class="o-kompanii-image">
            <img src="/img/o-kompanii-image.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="o-kompanii-item">
      <div class="o-kompanii-text">Это уникально подобранная, апробированная в условиях зоны рискованного земледелия, серия сортов и гибридов, которые в любое, даже в самое неблагоприятное лето, одарят Вас щедрым и богатым урожаем.</div>
    </div>
    <div class="o-kompanii-item">
      <div class="row">
        <div class="col-md-4">
          <div class="o-kompanii-image">
            <img src="/img/o-kompanii-image.jpg" alt="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="o-kompanii-image">
            <img src="/img/o-kompanii-image.jpg" alt="">
          </div>
        </div>
        <div class="col-md-4">
          <div class="o-kompanii-image">
            <img src="/img/o-kompanii-image.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="o-kompanii-item">
      <div class="row">
        <div class="col-md-5">
          <div class="o-kompanii-subtitle"><span class="light-green-text">Ежегодно</span>, <br>перед каждым новым сезоном</div>
        </div>
        <div class="col-md-7">
          <p>Все наши семена проходят проверку на качество (энергия роста, всхожесть, чистоту, влажность и др.) в ФГУ «Россельхозцентр» по Челябинской области.</p>
          <p>И мы можем с гордостью заявить, что все наши семена соответствуют требованиям ГОСТ 32592-2013 по сортовым и посевным качествам, а так же отвечают всем требованиям самых взыскательных огородников и садоводов.</p>
          <p>Они свободны от карантинных объектов, благодаря неусыпному контролю Россельхознадзора.</p>
        </div>
      </div>
    </div>
    <div class="o-kompanii-item">
      <div class="purple-accent">
        <div class="title-wrapper">
          <div class="o-kompanii-subtitle purple-accent-title">У нас Вы можете купить челябинские селекционные семена: цветов, овощей и ягод</div>
          <a href="/catalog" class="catalog-btn">Перейти в каталог</a>
        </div>
        <div class="o-kompanii-image">
          <img src="/img/o-kompanii-accent.jpg" alt="">
        </div>
      </div>
    </div>
    <div class="o-kompanii-item">
      <div class="o-kompanii-text">Также в нашем интернет магазине вы найдете: удобрения, стимуляторы и иммуномодуляторы, средства от болезней, средства от сорняков, средства для борьбы с вредителями... Все то, что так необходимо в помощь садоводу.</div>
    </div>
    <div class="o-kompanii-item">
      <div class="row">
        <div class="col-md-5">
          <div class="o-kompanii-subtitle o-kompanii-stock-title"><span class="light-green-text">Лучшие Условия</span> Хранения Семян</div>
          <div class="o-kompanii-image o-kompanii-stock-image">
            <img src="/img/o-kompanii-stock1.jpg" alt="">
          </div>
          <div class="o-kompanii-image o-kompanii-stock-image">
            <img src="/img/o-kompanii-stock2.jpg" alt="">
          </div>
        </div>
        <div class="col-md-7">
          <p class="o-kompanii-text">Наши семена сохраняют свою Биологическую Долговечность за счет правильного режима и оптимальных условий хранения.</p>
          <p class="o-kompanii-text">Таким образом они долго сохраняют свою способность к прорастанию со времени созревания их на материнском растении.</p>
          <p class="o-kompanii-text">На наших складах поддерживается самые высокие стандарты хранения (с оптимальной влажностью воздуха и температуры).</p>
          <p class="o-kompanii-text">Благодаря этому Челябинские семена также сохраняют свою Хозяйственную Долговечность и всхожесть.</p>
          <div class="o-kompanii-image">
            <img src="/img/o-kompanii-stock3.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="grey-section">
      <div class="flex-container">
        <div class="grey-section__image">
          <img src="/img/first-order-percent.png" alt="">
        </div>
        <div class="grey-section__text">Купить семена Челябинской селекции Вы сможете в нашем интернет магазине «СеменаДаром» по самой выгодной цене на рынке</div>
      </div>
      <div class="corner-right"></div>
      <a href="#" class="full-link"></a>
    </div>
    <div class="frame">
      <div class="frame-title">Только у нас вы найдете челябинские селекционные семена, которые соответствуют сортовому и посевному качеству (ГОСТ 32592-2013).</div>
      <div class="o-kompanii-text">А также стоит отметить, что они подойдут даже<br> для требовательных огородников и садоводов.<br> Почему стоит выбирать наш интернет магазин:</div>
    </div>


  </div>
</div> 

@endsection