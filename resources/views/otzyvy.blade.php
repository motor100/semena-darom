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
  <div class="content-wrapper">
    <div class="otzyvy-title">Отзывы о магазине<br> <span class="light-green-text text-uppercase">Семена Даром</span></div>
    <a href="#add-comment" class="add-comment-btn">Оставить комментарий</a>

    <div class="testimonials">
      @foreach($testimonials as $testimonial)
        <div class="testimonials-item">
          <div class="testimonials-item__name">{{ $testimonial->name }}</div>
          @if($testimonial->image)
            <div class="testimonials-item__text mb30">{{ $testimonial->text }}</div>
            <div class="testimonials-item__image">
              <img src="{{ Storage::url($testimonial->image) }}" alt="">
            </div>
          @else
            <div class="testimonials-item__text">{{ $testimonial->text }}</div>
          @endif
        </div>
      @endforeach
    </div>

    <div class="pagination-links">
      <div class="container">
        {{ $testimonials->links() }}
      </div>
    </div>

    <!-- Убрать если будет через ajax -->
    @if($errors->any())
      <div class="errors">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    <div class="form-wrapper">
      <div id="add-comment" class="form-title">Оставить комментарий</div>
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
          <label for="text">Комментарий</label>
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

        <div class="checkbox-wrapper">
          <input type="checkbox" name="checkbox" class="custom-checkbox" id="checkbox-callback-modal" checked required onchange="document.querySelector('.js-callback-modal-btn').disabled = !this.checked;">
          <label for="checkbox-callback-modal" class="custom-checkbox-label"></label>
          <span class="checkbox-text">Согласен с <a href="/politika-konfidencialnosti" class="privacy-policy-btn" target="_blank">политикой обработки персональных данных</a></span>
        </div>

        @csrf
        <input type="submit" class="submit-btn js-callback-modal-btn" value="Оставить комментарий">
      </form>
    </div>

  </div>
  
</div> 

@endsection

@section('script')
  <script src="https://www.google.com/recaptcha/api.js"></script>
@endsection