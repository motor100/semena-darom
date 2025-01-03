@section('title', 'Гарантия возврата денежных средств')

@section('robots')
  <meta name="robots" content="noindex, nofollow">
@endsection

@extends('layouts.main')

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
  <div class="active">Гарантия возврата денежных средств</div>
</div>

<div class="garantiya-vozvrata-denezhnyh-sredstv"> 
  <div class="page-title">Гарантия <span class="green-text">возврата денежных средств</span></div>
  <p>Уважаемые клиенты!</p>
  <p>Всем нашим покупателям мы гарантируем <strong>бесспорный возврат денежных средств</strong>, если, вдруг, товар не дошел до адресата, или товар пришел с дефектами связанными с транспортировкой. Мы также готовы компенсировать Вам все расходы, связанные с возвратом заказа.</p>
  <div class="page-subtitle">ВАЖНО!</div>
  <p>При получении посылки (в почтовом отделении, пункте выдачи или курьером) настоятельно <strong>рекомендуется в присутствии работника вскрыть посылку и проверить:</strong></p>
  <ul>
    <li>Содержимое количества товара (согласно расходной накладной, находящейся внутри посылки).</li>
    <li>Целостность внешней упаковки;</li>
  </ul>
  <p>В случае отсутствия какой-либо позиции (указанной в расходной накладной), обнаружения недоброкачественного товара, требуется вместе с работником составить "Акт Проверки".</p>
  <div class="page-subtitle">ПРЕТЕНЗИИ:</div>
  <p class="text-semibold">На случай того, если с Вашим заказом что-то не так, то претензии принимаются (в течение двадцати дней с момента получения посылки):</p>
  <ul>
    <li>В письменном виде на нашу электронную почту info@semena-darom.ru.</li>
    <li>Либо по телефону +7 351 777 87 99</li>
  </ul>
  <p>А также принимаются только при наличии копии, или оригинала описи вложения ("Акт Проверки") на полученную посылку, составленного в день получение посылки.</p>
  <p>Интернет-магазин не несет ответственности за задержку доставки заказов по вине почты и транспортных компаний.</p>
</div>

@endsection