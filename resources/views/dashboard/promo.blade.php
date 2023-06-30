@extends('dashboard.layout')

@section('title', 'Акции')

@section('dashboardcontent')

<div class="dashboard-content">

  <a href="{{ route('promos-create') }}" class="btn btn-success mb-3">Добавить</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th class="number-column" scope="col">№</th>
        <th scope="col">Название</th>
        <th scope="col">Скидка</th>
        <th scope="col">Изображение</th>
        <th class="button-column"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($promos as $promo)
        <tr>
          <td scope="row">{{ $loop->index + 1 }}</td>
          <td>{{ $promo->title}}</td>
          <td>{{ $promo->discount }}</td>
          <td>
            <div class="promo-image">
              <img src="{{ Storage::url($promo->image) }}" alt="">
            </div>
          </td>
          <td class="table-button">
            <a href="{{ route('promos-show', $promo->id) }}" class="btn btn-success">
              <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('promos-edit', $promo->id) }}" class="btn btn-primary">
              <i class="fas fa-pen"></i>
            </a>
            <form class="form" action="{{ route('promos-destroy', $promo->id) }}" method="get">
              @csrf
              <button type="submit" class="btn btn-danger">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

</div>

<script>
  const menuItem = 1;
</script>

@endsection