@extends('layouts.main')

@section('title', 'О компании')

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
  <div class="active">о компании</div>
</div>

<div class="o-kompanii">
  <div class="o-kompanii-item">
    <div class="row">
      <div class="col-md-7">
        <div class="o-kompanii-title page-title">Интернет-магазин<br>СЕМЕНА <span class="green-text">ДАРОМ</span></div>
        <div class="o-kompanii-description">Интернет магазин «СЕМЕНА ДАРОМ» (ООО «Челябинская Селекционная Станция») представляет на рынке семена от ЧЕЛЯБИНСКОЙ СЕЛЕКЦИОННОЙ СТАНЦИИ.</div>
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
      <div class="col-sm-4 col-6">
        <div class="o-kompanii-image">
          <img src="/img/o-kompanii-image.jpg" alt="">
        </div>
      </div>
      <div class="col-sm-4 col-6">
        <div class="o-kompanii-image">
          <img src="/img/o-kompanii-image.jpg" alt="">
        </div>
      </div>
      <div class="col-sm-4 col-6">
        <div class="o-kompanii-image">
          <img src="/img/o-kompanii-image.jpg" alt="">
        </div>
      </div>
    </div>
  </div>
  <div class="o-kompanii-item">
    <div class="row">
      <div class="col-lg-5">
        <div class="page-subtitle"><span class="green-text">Ежегодно</span>, <br>перед каждым новым сезоном</div>
      </div>
      <div class="col-lg-7">
        <p>Все наши семена проходят проверку на качество (энергия роста, всхожесть, чистоту, влажность и др.) в ФГУ «Россельхозцентр» по Челябинской области.</p>
        <p>И мы можем с гордостью заявить, что все наши семена соответствуют требованиям ГОСТ 32592-2013 по сортовым и посевным качествам, а так же отвечают всем требованиям самых взыскательных огородников и садоводов.</p>
        <p>Они свободны от карантинных объектов, благодаря неусыпному контролю Россельхознадзора.</p>
      </div>
    </div>
  </div>
  <div class="o-kompanii-item">
    <div class="purple-accent">
      <div class="title-wrapper">
        <div class="page-subtitle purple-accent-title">У нас Вы можете купить челябинские селекционные семена: цветов, овощей и ягод</div>
        <a href="/catalog" class="catalog-btn">Перейти в каталог</a>
      </div>
      <div class="o-kompanii-image hidden-mobile">
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
        <div class="page-subtitle o-kompanii-stock-title"><span class="green-text">Лучшие Условия</span> Хранения Семян</div>
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
  </div>
  <div class="frame">
    <div class="frame-title">Только у нас вы найдете челябинские селекционные семена, которые соответствуют сортовому и посевному качеству (ГОСТ 32592-2013).</div>
    <div class="o-kompanii-text">А также стоит отметить, что они подойдут даже<br> для требовательных огородников и садоводов.<br> Почему стоит выбирать наш интернет магазин:</div>
    <div class="row">
      <div class="col-md-8">
        <div class="color-frame-item orange-border">
          <div class="color-frame-item__image">
            <img src="/img/o-kompanii-warehouse.png" alt="">
          </div>
          <div class="color-frame-item__text">Челябинские семена хранятся только при оптимальных условиях и при правильном режиме.Поэтому биологический долговечный период сохраняется.</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="color-frame-item green-border">
          <div class="color-frame-item__image">
            <img src="/img/o-kompanii-agriculture.png" alt="">
          </div>
          <div class="color-frame-item__text">Каждый покупатель сможет найти любой вид семян, так как у нас представлен широкий ассортимент.</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="color-frame-item red-border">
          <div class="color-frame-item__image">
            <img src="/img/o-kompanii-verification.png" alt="">
          </div>
          <div class="color-frame-item__text">Семена всегда проходят контроль Россельхознадзора. Поэтому они наилучшие и не имеют карантинные организмы.</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="color-frame-item purple-border">
          <div class="color-frame-item__image">
            <img src="/img/o-kompanii-delivery.png" alt="">
          </div>
          <div class="color-frame-item__text">После оформления заказа, он отправляется в течении 2 дней. Доставкой занимается ФГУП «Почта России».</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="color-frame-item orange-border">
          <div class="color-frame-item__image">
            <img src="/img/o-kompanii-gift.png" alt="">
          </div>
          <div class="color-frame-item__text">При покупке вы можете получить различные бонусы.</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="color-frame-item green-border">
          <div class="color-frame-item__image">
            <img src="/img/o-kompanii-headset.png" alt="">
          </div>
          <div class="color-frame-item__text">Наши менеджеры окажут профессиональную консультацию по телефону или в онлайн чате.</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="color-frame-item green-border">
          <div class="color-frame-item__image">
            <img src="/img/o-kompanii-visa.png" alt="">
          </div>
          <div class="color-frame-item__text">Удобные способы оплаты.</div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="color-frame-item purple-border">
          <div class="color-frame-item__image">
            <img src="/img/o-kompanii-help.png" alt="">
          </div>
          <div class="color-frame-item__text">Раздел «Помощь садоводу» помоожет подобрать: удобрения, стимуляторы и иммуномодуляторы, средства от болезней и сорняков. А также различные средства от вредителей сада.</div>
        </div>
      </div>
    </div>
  </div>
  <div class="feedback">
    <div class="page-subtitle feedback-title">Если у Вас появятся любого рода вопросы, знайте мы тут, чтобы помочь Вам разобраться с ними.</div>
    <form id="feedback-form" class="form" action="" method="post">
      <div class="form-title">Ваши контакты:</div>
      <div class="flex-container">
        <div class="form-group">
          <label for="name-feedback" class="label">Имя</label>
          <input type="text" name="name" id="name-feedback" class="input-field js-name-callback-modal" minlength="3" maxlength="50" required>
        </div>
        <div class="form-group">
          <label for="phone-feedback" class="label">Телефон</label>
          <input type="text" name="phone" id="phone-feedback" class="input-field js-phone-callback-modal js-input-phone-mask" minlength="3" maxlength="50" required>
        </div>
        <div class="form-group">
          <label for="email-feedback" class="label">Email</label>
          <input type="email" name="email" id="email-feedback" class="input-field js-email-callback-modal" minlength="3" maxlength="100" required>
        </div>
      </div>
      <div class="flex-container">
        <div class="checkbox-wrapper">
          <input type="checkbox" name="checkbox" class="custom-checkbox js-checkbox-callback-modal" id="checkbox-feedback" checked required onchange="document.querySelector('.js-feedback-btn').disabled = !this.checked;">
          <label for="checkbox-feedback" class="custom-checkbox-label"></label>
          <span class="checkbox-text">Согласен с <a href="/politika-konfidencialnosti" class="privacy-policy-btn" target="_blank">политикой обработки персональных данных</a></span>
        </div>

        @csrf
        <input type="button" class="submit-btn js-feedback-btn" value="Заказать обратный звонок">
      </div>
    </form>
  </div>
  <div class="contacts">
    <div class="row">
      <div class="col-md-4">
        <div class="page-subtitle contacts-title">Наши <span class="green-text">контакты</span></div>
      </div>
      <div class="col-md-8">
        <div class="contacts-item">Связаться с нами Вы можете любым удобным для Вас способом <span class="light-grey-text">(телефон, имейл, онлайн консультант)</span></div>
        <div class="contacts-item">Телефон&nbsp;&nbsp;&nbsp;&nbsp;<a href="tel:+79507231013">+7 (950) 723 10 13</a>
        </div>
        <div class="contacts-item">Email&nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:info@semena-darom.ru">info@semena-darom.ru</a>
        </div>
      </div>
    </div>
  </div>
</div> 

@endsection

@section('script')
  <script src="{{ asset('/js/imask.min.js') }}"></script>
@endsection