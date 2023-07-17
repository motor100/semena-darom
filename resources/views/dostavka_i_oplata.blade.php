@extends('layouts.main')

@section('title', 'Доставка и оплата')

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
  <div class="active">доставка и оплата</div>
</div>

<div class="dostavka-i-oplata">
  <div class="title-wrapper">
    <div class="row">
      <div class="col-md-8">
        <div class="dostavka-i-oplata-title page-title">Доставка <span class="green-text">по всей РФ</span></div>
        <div class="dostavka-i-oplata-description">Интернет-магазин «СеменаДаром» осуществляет доставку только в пределах Российской Федерации. Мы работаем с «Почтой России» и «CDEK»</div>
      </div>
      <div class="col-md-4">
        <div class="dostavka-i-oplata-image">
          <img src="/img/sdek.jpg" alt="">
        </div>
        <div class="dostavka-i-oplata-image">
          <img src="/img/russian-post.jpg" alt="">
        </div>
      </div>
    </div>
  </div>
  <div class="dostavka-i-oplata-item">
    <div class="row">
      <div class="col-md-6">
        <div class="dostavka-i-oplata-item__image">
          <img src="/img/dostavka-i-oplata-russian-post.png" alt="">
        </div>
        <div class="dostavka-i-oplata-item__text">«Почта России» — стоимость доставки для всех Регионов единая и составляет 290 руб.</div>
      </div>
      <div class="col-md-6">
        <div class="dostavka-i-oplata-item__image">
          <img src="/img/dostavka-i-oplata-sdek.png" alt="">
        </div>
        <div class="dostavka-i-oplata-item__text">«CDEK» — доставка осуществляется Курьером до двери, или до ближайшего к Вашему адресу Пункту Выдачи CDEK (стоимость доставки рассчитывается автоматически при оформлении заказа)</div>
      </div>
    </div>
  </div>
  <div class="grey-section">
    <div class="flex-container">
      <div class="grey-section__image">
        <img src="/img/dostavka-i-oplata-warning.png" alt="">
      </div>
      <div class="grey-section__text">Сформированный заказ отправляется в течение 2-х рабочих дней после подтверждения заказа. В случае выбора пред оплатного способа оплаты — в течение 2-х рабочих дней после оплаты заказа.</div>
    </div>
  </div>
  <div class="warranty">
    <div class="warranty-title page-subtitle">Гарантии</div>
    <div class="row">
      <div class="col-md-6">
        <div class="warranty-item">
          <div class="warranty-item__image">
            <img src="/img/dostavka-i-oplata-shield-check.png" alt="">
          </div>
          <div class="warranty-item__text">Всем нашим покупателям мы гарантируем бесспорный возврат денежных средств, если, вдруг, товар не дошел до адресата или пришёл не надлежащего качества (по нашей вине).</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="warranty-item">
          <div class="warranty-item__image">
            <img src="/img/dostavka-i-oplata-shield-check.png" alt="">
          </div>
          <div class="warranty-item__text">Мы также готовы компенсировать Вам все расходы, связанные с возвратом заказа.</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="warranty-item">
          <div class="warranty-item__image">
            <img src="/img/dostavka-i-oplata-shield-check.png" alt="">
          </div>
          <div class="warranty-item__text">Такого рода гарантии Вам могут дать лишь те интернет-магазины, которые ничего не скрывают и реализуют действительно качественные товары.</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="warranty-item">
          <div class="warranty-item__image">
            <img src="/img/dostavka-i-oplata-shield-check.png" alt="">
          </div>
          <div class="warranty-item__text">Мы готовы отвечать за качество наших товаров не только словами, но и рублем.</div>
        </div>
      </div>
    </div>
  </div>
  <div class="payment">
    <div class="payment-title page-subtitle"><span class="green-text">Оплата</span></div>
    <div class="payment-description">Интернет-магазин «СеменаДаром» принимает оплату следующими способами:</div>
    <div class="row">
      <div class="col-md-6">
        <div class="payment-item">
          <div class="payment-title-wrapper">
            <div class="payment-item__title">Оплата Наложенным платежом на «Почте России»</div>
            <img src="/img/dostavka-i-oplata-payment-russian-post.png" class="russian-post-logo" alt="">
          </div>
          <p class="payment-item__text">Оплата производится при получении посылки в отделении Почты России.</p>
          <p class="payment-item__text">Доступна для заказов на сумму не более 2 000 рублей, более этой суммы только предоплата!</p>
          <div class="green-text">Стоимость доставки: 290 руб.</div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="payment-item">
          <div class="payment-title-wrapper">
            <div class="payment-item__title">Оплата на Пункте Выдачи CDEK/Курьеру CDEK.</div>
            <img src="/img/dostavka-i-oplata-payment-sdek.png" class="sdek-logo" alt="">
          </div>
          <p class="payment-item__text">Оплата производится при получении посылки на ПВ CDEK, или Курьеру CDEK.</p>
          <p class="payment-item__text">Стоимость доставки насчитывается при оформлении заказа.</p>
        </div>
      </div>
    </div>
    <div class="online-payment">
      <div class="online-payment__text"><span class="green-text">Оплата Онлайн (Картой)</span></div>
      <div class="online-payment__logos">
        <img src="/img/dostavka-i-oplata-payment-mastercard.png" alt="">
        <img src="/img/dostavka-i-oplata-payment-visa.png" alt="">
      </div>
    </div>
  </div>
  <div class="questions">
    <div class="questions-item">
      <div class="page-subtitle">Как выглядит<br> <span class="green-text">процесс платежа</span></div>
      <div class="questions-item__description">Оплата происходит через авторизационный сервер Процессингового центра Банка с использованием Банковских кредитных карт платежных систем: VISA International и MasterCard World Wide</div>
      <div class="questions-item__logos">
        <img src="/img/dostavka-i-oplata-payment-mastercard.png" alt="">
        <img src="/img/dostavka-i-oplata-payment-visa.png" alt="">
      </div>
    </div>
    <div class="questions-item"> 
      <div class="page-subtitle">Как происходит возврат оплаты<br> <span class="green-text">в случае отказа клиентом от товара</span></div>
    </div>
  </div>
  <div class="grey-section">
    <div class="flex-container">
      <div class="grey-section__image">
        <img src="/img/dostavka-i-oplata-warning.png" alt="">
      </div>
      <div class="grey-section__text">Клиент имеет право вернуть свои деньги в 3-х случаях:</div>
    </div>
  </div>
  <div class="dostavka-i-oplata-item">
    <div class="row">
      <div class="col-md-4">
        <div class="product-return-item">1. Если нет товара на складе и Вы по ошибке сделали заказ - мы вернем Вам деньги (комиссия за наш счет)</div>
      </div>
      <div class="col-md-4">
        <div class="product-return-item">2. Если товар не отправлен до 3-х рабочих дней, Вы можете отписать на почту <span class="green-text">info@semena-darom.ru</span> и вернуть деньги</div>
      </div>
      <div class="col-md-4">
        <div class="product-return-item">3. Если Вам пришел товар и он не надлежащего качества, Вы пишите нам на почту <span class="green-text">info@semena-darom.ru</span> и мы возвращаем деньги</div>
      </div>
    </div>
  </div>
  <div class="dostavka-i-oplata-item">Возврат осуществляется <span class="red-text"> в течении 10 рабочих дней</span> на ту же карту, с которой мы приняли оплату. Мы можем запросить подтверждение личности, чека на покупку и фотографий негодности товара.</div>
  <div class="dostavka-i-oplata-item">
    <a href="/garantiya-vozvrata-denezhnyh-sredstv" class="green-text">Порядок и условия возврата денежных средств</a>
  </div>
</div> 

@endsection