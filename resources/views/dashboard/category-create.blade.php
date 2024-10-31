@extends('dashboard.layout')

@section('title', 'Добавить категорию')

@section('dashboardcontent')

<div class="dashboard-content">
    
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form class="form" action="{{ route('category-store') }}" method="post" enctype="multipart/form-data">
    <div class="form-group mb-3">
      <label for="title">Название</label>
      <input type="text" class="form-control" name="title" id="title" maxlength="200" required>
    </div>
    <div class="form-group mb-3">
      <label for="sort">Сортировка</label>
      <input type="number" class="form-control input-number" name="sort" id="sort" min="0" max="100" required>
    </div>
    <div class="form-group mb-5">
      <div class="label-text mb-1">Изображение</div>
      <input type="file" name="input-main-file" id="input-main-file" class="inputfile" required accept="image/jpeg,image/png">
      <label for="input-main-file" class="custom-inputfile-label">Выберите файл</label>
      <span class="namefile main-file-text">Файл не выбран</span>
    </div>

    @csrf
    <button type="submit" class="btn btn-primary">Добавить</button>
  </form>

</div>

<script>
  const menuItem = 1;
</script>

@endsection