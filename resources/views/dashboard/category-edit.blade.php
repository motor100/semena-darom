@extends('dashboard.layout')

@section('title', 'Редактировать категорию')

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

  <form class="form" action="{{ route('category-update', $category->id) }}" method="post" enctype="multipart/form-data">
    <div class="form-group mb-3">
      <label for="title">Заголовок</label>
      <input type="text" class="form-control" name="title" id="title" maxlength="200" required value="{{ $category->title }}">
    </div>
    <div class="form-group mb-3">
      <label for="sort">Сортировка</label>
      <input type="number" class="form-control input-number" name="sort" id="sort" min="0" max="100" required value="{{ $category->sort }}">
    </div>
    <div class="form-group">
      <div class="image-preview">
        <img src="{{ Storage::url($category->image) }}" alt="">
      </div>
    </div>
    <div class="form-group mb-5">
      <div class="label-text mb-1">Изображение</div>
      <input type="file" name="input-main-file" id="input-main-file" class="inputfile" accept="image/jpeg,image/png">
      <label for="input-main-file" class="custom-inputfile-label">Выберите файл</label>
      <span class="namefile main-file-text">Файл не выбран</span>
    </div>
    @if($category->parent > 0)
    <div class="form-group mb-3">
      <select name="parent" class="form-select mt-1">
        @foreach($parent_ct as $pct)
          @if($pct->id == $current_ct->id)
            <option value="{{ $pct->id }}" selected>{{ $pct->title }}</option>
          @else
            <option value="{{ $pct->id }}">{{ $pct->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    @else
      <input type="hidden" name="parent" value="0">
    @endif

    <input type="hidden" name="id" value="{{ $category->id }}">

    @csrf
    <button type="submit" class="btn btn-primary">Обновить</button>
  </form>

</div>

<script>
  const menuItem = 1;
</script>

@endsection