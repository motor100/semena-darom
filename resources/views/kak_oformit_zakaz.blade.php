@extends('layouts.main')

@section('title', 'Как заказать')

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
  <div class="active">как оформить заказ</div>
</div>

<div class="kak-zakazat">
  <div class="content-wrapper">
    <div class="kak-zakazat-title page-title">Как оформить<br><span class="green-text">заказ</span></div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 1</span></div>
          <div class="kak-zakazat-subtitle">Для того, чтобы перейти к выбору товаров, Вам необходимо нажать на Раздел «КАТАЛОГ» и выбрать интересующий Вас Раздел:</div>
          <ul class="marker-list">
            <li class="list-item">Семена Овощей;</li>
            <li class="list-item">Семена Цветов;</li>
            <li class="list-item">Трава, Газон;</li>
            <li class="list-item">В помощь Садоводу (Удобрения).</li>
          </ul>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step1.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 2</span></div>
          <div class="kak-zakazat-subtitle">Далее выберите необходимую Категорию Товаров:</div>
          <ul class="marker-list">
            <li class="list-item">В левой колонке;</li>
            <li class="list-item">Либо кликните по картинке.</li>
          </ul>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step2.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 3</span></div>
          <div class="kak-zakazat-subtitle">Подберите интересующий Вас товар.</div>
          <ol class="number-list">
            <li class="list-item">Вы можете сразу же выбрать количество и положить товар в Корзину;</li>
            <li class="list-item">Либо перейти в «КАРТОЧКУ ТОВАРА», чтобы увидеть всю информацию о нем и оттуда положить товар в корзину.</li>
          </ol>
          <p>А также, Вы можете воспользоваться «ПОИСКОМ» по сайту (чтобы быстро найти любой интересующий Вас товар);</p>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step3.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 4</span></div>
          <div class="kak-zakazat-subtitle">Когда Вы выбрали какой-либо товар, то:</div>
          <ul class="marker-list">
            <li class="list-item">Можете сразу перейти в Корзину для Завершения «ОФОРМЛЕНИЯ ЗАКАЗА»;</li>
            <li class="list-item">Либо нажать на кнопку «ВЕРНУТЬСЯ В МАГАЗИН» и продолжить класть другой товар в Корзину.</li>
          </ul>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step4.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 5</span></div>
          <div class="kak-zakazat-subtitle">Вот что необходимо сделать в Корзине, чтобы продолжить Оформление Заказа:</div>
          <ul class="marker-list">
            <li class="list-item">Вас ждет «Бесплатный Подарок» от нас, прилагаемый к любому Заказу;</li>
            <li class="list-item">Вы можете удалить любой товар из Корзины (кроме бонусных), если Вы передумали его брать;</li>
            <li class="list-item">К любому товару (кроме бонусных) можно добавить его количество;</li>
            <li class="list-item">После чего, Вам необходимо нажать на кнопку «ОФОРМИТЬ ЗАКАЗ», чтобы перейти к следующим Шагам оформления заказа.</li>
          </ul>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step5.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="grey-section">
      <div class="flex-container">
        <div class="grey-section__image">
          <img src="/img/first-order-percent.png" alt="">
        </div>
        <div class="grey-section__text"><span class="red-text">Примечание:</span> При заказе на сумму свыше 2000 руб. Вы получите СКИДКУ - 10% на весь заказ. Просто наберите товара в Корзину на 2000+ руб. и ваша сумма автоматически пересчитается.</div>
      </div>
      <div class="corner-right"></div>
      <a href="#" class="full-link"></a>
    </div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 6</span></div>
          <div class="kak-zakazat-subtitle">После этого Вас выведет на страницу, где Вам необходимо будет выбрать один из 3-х Способов «Заполнения Заявки»:</div>
          <ol class="number-list">
            <li class="list-item">Вы можете «ЗАКАЗАТЬ БЕЗ РЕГИСТРАЦИИ» на Сайте (для этого нажмите на кнопку);</li>
            <li class="list-item">Если Вы уже были зарегистрированы на нашем сайте, то можете сделать «ВХОД» и все Ваши Данные (ФИО, адрес и т. д.) заполнит автоматически на следующем шаге;</li>
            <li class="list-item">Вы можете «ЗАРЕГИСТРИРОВАТЬСЯ», чтобы в личном кабинете видеть «Статус Вашего Заказа», быть в курсе всех новостей и для быстрого заполнения данных.</li>
          </ol>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step6.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 7</span></div>
          <div class="kak-zakazat-subtitle">После этого Вас переведет на «2-й ШАГ ОФОРМЛЕНИЯ ЗАКАЗА».</div>
          <ul class="marker-list">
            <li class="list-item">Заполните пожалуйста корректно все Ваши данные (чтобы доставка пришла на правильный Адрес)</li>
            <li class="list-item">Нажмите «ДАЛЕЕ», чтобы перейти к выбору Способов Доставки.</li>
          </ul>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step7.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="grey-section">
      <div class="flex-container">
        <div class="grey-section__image">
          <img src="/img/first-order-percent.png" alt="">
        </div>
        <div class="grey-section__text"><span class="red-text">Примечание:</span> если у Вас нет Емейла, либо он не проходит (по каким-то причинам), то нажмите галочку в квадратик и Ваша регистрация не будет остановлена.</div>
      </div>
      <div class="corner-right"></div>
      <a href="#" class="full-link"></a>
    </div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 8</span></div>
          <div class="kak-zakazat-subtitle">Пока мы отправляем «ПОЧТОЙ РОССИИ» и «SDEK», поэтому просто нажмите на кнопку «ДАЛЕЕ», чтобы перейти к выбору Способов Оплаты.</div>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step8.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="kak-zakazat-item">
      <div class="row mb20">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 9</span></div>
          <div class="kak-zakazat-subtitle">Далее Вам необходимо будет выбрать один из Способов Оплаты:</div>
          <ul class="marker-list">
            <li class="list-item">НАЛОЖЕННЫЙ ПЛАТЕЖ (Вы платите только при получении на Почте);</li>
            <li class="list-item">ОНЛАЙН-ОПЛАТА (Вы оплачиваете сразу одним из способов Онлайн Перевода)</li>
          </ul>
          <p>Если Вы хотите оплатить при получении товара (на Почте):</p>
          <ol class="number-list">
            <li class="list-item">То поставьте Галочку рядом с Наложенным платежом;</li>
            <li class="list-item">Затем нажмите кнопку «ДАЛЕЕ», чтобы перейти на страницу подтверждения заказа.</li>
          </ol>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step9-1.jpg" alt="">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step9-2.jpg" alt="">
          </div>
        </div>
        <div class="col-md-5">
          <div class="kak-zakazat-subtitle">Если Вы все же хотите оплатить сразу Онлайн:</div>
          <ol class="number-list">
            <li class="list-item">То поставьте Галочку рядом с Наложенным платежом.</li>
            <li class="list-item">Затем нажмите кнопку «ДАЛЕЕ», чтобы перейти на страницу подтверждения заказа.</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 10</span></div>
          <div class="kak-zakazat-subtitle">После этого Вас переведет на 5-й ШАГ, где Вам необходимо будет:</div>
          <ol class="number-list">
            <li class="list-item">Последний раз подтвердить все данные (выбранный Вами товар, Ваш адрес, и т. д.);</li>
            <li class="list-item">Нажать на кнопку «ПОДТВЕРДИТЬ ЗАКАЗ».</li>
          </ol>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step10.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="grey-section">
      <div class="flex-container">
        <div class="grey-section__image">
          <img src="/img/first-order-percent.png" alt="">
        </div>
        <div class="grey-section__text"><span class="red-text">Примечание:</span> вы можете изменить количество выбранных товаров или удалить что-либо, нажав на кнопку «ЗДЕСЬ» (прямо под таблицей).</div>
      </div>
      <div class="corner-right"></div>
      <a href="#" class="full-link"></a>
    </div>
    <div class="kak-zakazat-item">А также, если у Вас есть какая-то специфическая просьба (к доставке и т.д.), то Вы можете прикрепить Комментарий к Заказу и наш менеджер обязательно учтет Вашу просьбу.</div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 11</span></div>
          <div class="kak-zakazat-subtitle">Если Вы выбрали способ доставки «НАЛОЖЕННЫЙ ПЛАТЕЖ», то Вас перекинет на данную страницу.</div>
          <p>Это значит, что Ваш заказ Успешно Оформлен и мы отправим его уже в течении 1-х суток.</p>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step11.jpg" alt="">
          </div>
        </div>
      </div>
    </div>
    <div class="kak-zakazat-item">
      <div class="row">
        <div class="col-md-5">
          <div class="kak-zakazat-step"><span class="green-text">Шаг 12</span></div>
          <div class="kak-zakazat-subtitle">Если же Вы выбрали способ оплаты «ОНЛАЙН-ОПЛАТА», то Вас выведет на данную страницу, где вам необходимо:</div>
          <ul class="marker-list">
            <li class="list-item">Выбрать один из удобных Вам способов перевода средств (онлайн);</li>
            <li class="list-item">Пройти все шаги и оплатить заказ.</li>
          </ul>
        </div>
        <div class="col-md-7">
          <div class="kak-zakazat-image">
            <img src="/img/kak-zakazat-step12.jpg" alt="">
          </div>
        </div>
      </div>
    </div>



    
    
  </div>
</div> 

@endsection