@extends('dashboard.layout')

@section('title', $promo->title)

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

  <form class="form" action="{{ route('promos-update', $promo->id) }}" enctype="multipart/form-data" method="post">

    <div class="form-group mb-3">
      <label for="title" class="form-check-label mb-1">Заголовок</label>
      <input type="text" name="title" id="title" class="form-control" required value="{{ $promo->title }}">
    </div>
    <div class="form-group mb-3">
      <label for="discount" class="form-check-label mb-1">Скидка</label>
      <input type="number" name="discount" id="discount" class="form-control input-number" required value="{{ $promo->discount }}">
    </div>
    <div class="form-group mb-3">
      <div class="image-preview">
        <img src="{{ Storage::url($promo->image) }}" alt="">
      </div>
    </div>
    <div class="form-group mb-5">
      <div class="label-text mb-1">Изображение</div>
      <input type="file" name="input-main-file" id="input-main-file" class="inputfile" accept="image/jpeg,image/png">
      <label for="input-main-file" class="custom-inputfile-label">Выберите файл</label>
      <span class="namefile main-file-text">Файл не выбран</span>
    </div>

    @csrf
    <button type="submit" class="btn btn-primary">Обновить</button>

  </form>

</div>

<script>
  const menuItem = 4;
</script>

@endsection