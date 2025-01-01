@extends('dashboard.layout')

@section('title', 'Товары')

@section('dashboardcontent')

<div class="dashboard-content">

  <form class="form mb-5" action="/admin/products" method="get">
    <div class="form-group mb-3">
      <label for="search_query">Поиск</label>
      <input type="text" class="form-control input-number" name="search_query" id="search_query" maxlength="200" required>
    </div>
    <button type="submit" class="btn btn-primary">Найти</button>
  </form>

  <a href="{{ route('products-create') }}" class="btn btn-success mb-3">Добавить</a>
  <table class="table table-striped">
    <thead>
      <tr>
        <th class="number-column">№</th>
        <th>Название</th>
        <th class="button-column"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($products as $pr)
        <tr>
          <th>{{ $loop->index + 1 }}</th>
          <td>{{ $pr->title }}</td>
          <td class="table-button">
            <a href="/catalog/{{ $pr->category->slug }}/{{ $pr->slug }}" class="btn btn-success" target="_blank">
              <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('products-edit', $pr->id) }}" class="btn btn-primary">
              <i class="fas fa-pen"></i>
            </a>
            <form class="form" action="{{ route('products-destroy', $pr->id) }}" method="get">
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

  {{ $products->links() }}

</div>

<script>
  const menuItem = 0;
</script>

@endsection