@extends('dashboard.layout')

@section('title', 'Производители')

@section('dashboardcontent')

<div class="dashboard-content">

  <form class="form mb-5" action="{{ route('admin.brands') }}" method="get">
    <div class="form-group mb-3">
      <label for="search_query">Поиск</label>
      <input type="text" class="form-control input-number" name="search_query" id="search_query" maxlength="200" required>
    </div>
    <button type="submit" class="btn btn-primary">Найти</button>
  </form>

  <a href="{{ route('admin.brands-create') }}" class="btn btn-success mb-3">Добавить</a>
  <table class="table table-striped mb-5">
    <thead>
      <tr>
        <th class="number-column" scope="col">№</th>
        <th scope="col">Название</th>
        <th class="button-column"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($brands as $brand)
        <tr>
          <th scope="row">{{ $loop->index + 1 }}</th>
          <td>{{ $brand->title}}</td>
          <td class="table-button">
            <a href="#" class="btn btn-success">
              <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('admin.brands-edit', $brand->id) }}" class="btn btn-primary">
              <i class="fas fa-pen"></i>
            </a>
            <button type="button" class="btn btn-danger del-btn" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-route="{{ route('admin.brands-destroy', $brand->id) }}">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

</div>

@include('dashboard.modal')

<script>
  const menuItem = 7;
</script>
@endsection

@section('script')
  <script src="{{ asset('/adminpanel/js/bootstrap.min.js') }}"></script>
@endsection