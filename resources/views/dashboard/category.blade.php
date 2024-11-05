@extends('dashboard.layout')

@section('title', 'Категории')

@section('dashboardcontent')

<div class="dashboard-content">

  <form class="form mb-5" action="/admin/category" method="get">
    <div class="form-group mb-3">
      <label for="search_query">Поиск</label>
      <input type="text" class="form-control input-number" name="search_query" id="search_query" maxlength="200" required>
    </div>
    <button type="submit" class="btn btn-primary">Найти</button>
  </form>

  <a href="{{ route('category-create') }}" class="btn btn-success mb-3">Добавить</a>
  <table class="table table-striped mb-5">
    <thead>
      <tr>
        <th class="number-column" scope="col">№</th>
        <th scope="col">Название</th>
        <th class="button-column"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($categories as $ct)
        <tr>
          <th scope="row">{{ $ct->sort }}</th>
          <td>{{ $ct->title}}</td>
          <td class="table-button">
            <a href="/catalog/{{  $ct->slug }}" class="btn btn-success" target="_blank">
              <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('category-edit', $ct->id) }}" class="btn btn-primary">
              <i class="fas fa-pen"></i>
            </a>
            <form class="form" action="{{ route('category-destroy', $ct->id) }}" method="get">
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

  @if(isset($subcategories))
    <div class="subcategory">Подкатегории</div>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="number-column" scope="col">№</th>
          <th scope="col">Название</th>
          <th class="button-column"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($subcategories as $sct)
          <tr>
            <th scope="row">{{ $sct->sort }}</th>
            <td>{{ $sct->title}}</td>
            <td class="table-button">
              <a href="/catalog/{{ $sct->slug }}" class="btn btn-success" target="_blank">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('category-edit', $sct->id) }}" class="btn btn-primary">
                <i class="fas fa-pen"></i>
              </a>
              <form class="form" action="{{ route('category-destroy', $sct->id) }}" method="get">
                <button type="submit" class="btn btn-danger">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

</div>

<script>
  const menuItem = 1;
</script>
@endsection