@extends('dashboard.layout')

@section('title', $slide->title)

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

  <form class="form" action="{{ route('main-slider-update') }}" enctype="multipart/form-data" method="post">

    <div class="form-group mb-3">
      <label for="title" class="form-check-label mb-1">Заголовок</label>
      <input type="text" name="title" id="title" class="form-control" required value="{{ $slide->title }}">
    </div>
    <div class="form-group mb-3">
      <label for="text" class="form-check-label mb-1">Текст</label>
      <input type="text" name="text" id="text" class="form-control" required value="{{ $slide->text }}">
    </div>
    <div class="form-group mb-3">
      <div class="image-preview">
        <img src="{{ Storage::url($slide->image) }}" alt="">
      </div>
    </div>
    <div class="form-group mb-5">
      <div class="label-text mb-1">Изображение</div>
      <input type="file" name="input-main-file" id="input-main-file" class="inputfile" accept="image/jpeg,image/png">
      <label for="input-main-file" class="custom-inputfile-label">Выберите файл</label>
      <span class="namefile main-file-text">Файл не выбран</span>
    </div>
    <input type="hidden" name="id" value="{{ $slide->id }}">

    @csrf
    <button type="submit" class="btn btn-primary">Обновить</button>

  </form>

</div>

<script>
  const menuItem = 1;
</script>

@endsection