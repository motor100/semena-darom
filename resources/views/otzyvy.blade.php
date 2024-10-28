@extends('layouts.main')

@section('title', 'Отзывы')

@section('content')

<div class="breadcrumbs">
  <div class="back" onclick="history.back();">
    <span class="back-text">вернуться назад</span>
    <img src="/img/breadscrumbs-back.png" alt="">
  </div>
  <div class="parent">
    <a href="{{ route('home') }}">главная</a>
  </div>
  <div class="arrow"></div>
  <div class="active">отзывы</div>
</div>

<div class="otzyvy">

  <div class="otzyvy-title page-title">Отзывы о магазине<br> <span class="green-text text-uppercase">Семена Даром</span></div>
  <a href="#add-testimonial" class="add-testimonial-btn">Оставить отзыв</a>

  <div class="testimonials">
    @foreach($testimonials as $testimonial)
      <div class="testimonials-item">
        <div class="testimonials-item__name">{{ $testimonial->name }}</div>
        @if($testimonial->image)
          <div class="testimonials-item__text mb30">{!! $testimonial->text !!}</div>
          <div class="testimonials-item__image">
            <img src="{{ Storage::url($testimonial->image) }}" alt="">
          </div>
        @else
          <div class="testimonials-item__text">{!! $testimonial->text !!}</div>
        @endif
      </div>
    @endforeach
  </div>

  <div class="pagination-links">
    <div class="container">
      {{ $testimonials->links('pagination.custom') }}
    </div>
  </div>

  <div class="form-wrapper">
    <div id="add-testimonial" class="form-title">Оставить отзыв</div>
    <form id="testimonial-form" class="form" enctype="multipart/form-data" method="post">
      <div class="flex-container">
        <div class="form-group">
          <input type="text" name="name" id="testimonial-name" class="input-field" minlength="3" maxlength="50" required placeholder="Имя">
        </div>
        <div class="form-group">
          <input type="email" name="email" id="testimonial-email" class="input-field" minlength="3" maxlength="100" placeholder="Email">
        </div>
      </div>
      <div class="form-group">
        <textarea name="text" minlength="3" id="testimonial-text" class="textarea" maxlength="1000" required placeholder="Отзыв"></textarea>
      </div>
      <div class="form-group">
        <input type="file" name="file" id="input-main-file" class="inputfile" accept="image/jpeg,image/png">
        <label for="input-main-file" class="custom-inputfile-label">Прикрепить файл</label>
        <span class="namefile main-file-text">Файл не выбран</span>
      </div>
      <div class="g-recaptcha" data-sitekey="{{ config('google.client_key') }}"></div>

      @csrf
      <button type="button" class="submit-btn js-testimonial-btn">Оставить отзыв</button>

      <div class="checkbox-wrapper">
        <input type="checkbox" name="checkbox" class="custom-checkbox" id="checkbox-testimonial" checked required onchange="document.querySelector('.js-testimonial-btn').disabled = !this.checked;">
        <label for="checkbox-testimonial" class="custom-checkbox-label"></label>
        <span class="checkbox-text">Согласен с <a href="/politika-konfidencialnosti" class="privacy-policy-btn" target="_blank">политикой обработки персональных данных</a></span>
      </div>

    </form>
  </div>

</div> 

@endsection

@section('script')
  <script src="https://www.google.com/recaptcha/api.js"></script>
@endsection