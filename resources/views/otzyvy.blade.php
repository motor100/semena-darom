@extends('layouts.main')

@section('title', 'Отзывы')

@section('content')

<div class="breadcrumbs">
  <div class="back" onclick="history.back();">
    <span class="back-text">вернуться назад</span>
    <img src="/img/breadscrumbs-back.png" alt="">
  </div>
  <div class="parent">
    <a href="{{ route('home') }}">главная страница</a>
  </div>
  <div class="arrow"></div>
  <div class="active">отзывы</div>
</div>

<div class="otzyvy">
  <div class="page-title">Отзывы</div>

  <div class="content-wrapper">

    <!-- Убрать если будет через ajax -->
    @if($errors->any())
      <div class="errors">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <form class="form" action="/otzyvy-store" enctype="multipart/form-data" method="post">
      <div class="form-group">
        <label for="name">Имя</label>
        <input type="text" name="name" id="name" minlength="3" maxlength="50" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" minlength="3" maxlength="100" required>
      </div>
      <div class="form-group">
        <label for="text">Текст</label>
        <textarea name="text" minlength="3" id="text" maxlength="1000" required></textarea>
      </div>
      <div class="form-group">
        <div class="label-text">Фото</div>
        <input type="file" name="file" id="input-main-file" class="inputfile" accept="image/jpeg,image/png">
        <label for="input-main-file" class="custom-inputfile-label">Выберите файл</label>
        <span class="namefile main-file-text">Файл не выбран</span>
      </div>
      <div class="captcha">
        <div class="g-recaptcha" data-sitekey="{{ config('google.client_key') }}"></div>
      </div>

      @csrf
      <input type="submit" value="Отправить">
    </form>

    <div class="testimonials">
      @foreach($testimonials as $testimonial)
        <div class="item">
          <p>{{ $testimonial->name }}</p>
          <p>{{ $testimonial->short_created_at }}</p>
          <p>{{ $testimonial->text }}</p>
          <div class="image">
            <img src="{{ Storage::url($testimonial->image) }}" alt="">
          </div>
        </div>
      @endforeach
    </div>

  </div>
  
</div> 

@endsection

@section('script')
  <script src="https://www.google.com/recaptcha/api.js"></script>
@endsection