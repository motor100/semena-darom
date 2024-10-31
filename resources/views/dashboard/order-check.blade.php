@extends('dashboard.layout')

@section('title')
Заказ {{ $id }}
@endsection

@section('dashboardcontent')

<div class="dashboard-content">

  <form id="search-form" class="form mb-5">
    <div class="form-group mb-3">
      <label for="search_query" class="mb-1">Поиск</label>
      <input type="number" name="search_query" id="search_query" class="form-control input-number">
    </div>
    <input type="hidden" name="order_id" id="order-id-input" value="{{ $id }}">

    @csrf
    <button type="submit" class="btn btn-primary">Найти</button>
  </form>

  <table class="table">
    <tr>
      <th>№</th>
      <th>Название</th>
      <th>Количество</th>
      <th>Цена</th>
      <th>Количество</th>
      <th>Цена</th>
    </tr>
    @foreach($products as $key => $value)
      <tr class="product-row" data-id="{{ $value->id }}">
        <td>{{ $key + 1 }}</td>
        <td>{{ $value->title }}</td>
        <td>{{ $value->quantity }}</td>
        <td>{{ $value->summ }}</td>
        <td class="quantity-in"></td>
        <td class="summ-in"></td>
      </tr>
    @endforeach
    <tr class="text-bold">
      <td></td>
      <td>Итого</td>
      <td>{{ $total["quantity"] }}</td>
      <td>{{ $total["summ"] }}</td>
      <td id="check-quantity"></td>
      <td id="check-summ"></td>
    </tr>
  </table>

  <div class="error-message"></div>

  <script>

    const searchForm = document.querySelector('#search-form'),
          errorMessage = document.querySelector('.error-message');

    searchForm.onsubmit = function() {

      fetch('/ajax/ordercheck', {
        method: 'POST',
        cache: 'no-cache',
        body: new FormData(searchForm)
      })
      .then((response) => response.json())
      .then(json => {
        console.log(json);
        if (json.hasOwnProperty('no_product')) {
          errorMessage.innerText = 'Товар не найден';
          return false;
        }

        if (json.hasOwnProperty('no_in_order')) {
          errorMessage.innerText = 'Этого товара нет в заказе';
          return false;
        }

        const productRows = document.querySelectorAll('.product-row');
        productRows.forEach((item) => {
          if (item.dataset.id == json.id) {
            // Если в поле Количество input
            /*
            let quantityInput = item.querySelector('.quantity-input');
            quantityInput.value = Number(quantityInput.value) + 1;
            */

            // Если в поле Количество td
            let quantityIn = item.querySelector('.quantity-in'),
                summIn = item.querySelector('.summ-in');

            let quan = Number(quantityIn.innerText) + 1;

            quantityIn.innerText = quan;

            let price = json.promo_price ? json.promo_price : json.retail_price;

            summIn.innerText = quan * price;
          }
        });

        // Вызов функции пересчет количества и суммы
        calc();

        return false;

      })
      .catch((error) => {
        console.log(error);
      })

      // submit event preventDefault
      return false; 
    }

    // Если в поле Количество input
    // В функции calc() заменить .innerText на .value

    // Если в поле Количество td
    // Функция пересчет количества и суммы
    function calc() {
      const quantityIns = document.querySelectorAll('.quantity-in'),
            summIns = document.querySelectorAll('.summ-in');

      const checkQuantity = document.getElementById('check-quantity'),
            checkSumm = document.getElementById('check-summ');

      let quant = 0,
          summ = 0;

      quantityIns.forEach((item) => {
        quant += Number(item.innerText);
      });
      checkQuantity.innerText = quant;

      summIns.forEach((item) => {
        summ += Number(item.innerText);
      });
      checkSumm.innerText = summ;

      return false;
    }

  </script>

</div>

<script>
  const menuItem = 5;
</script>

@endsection