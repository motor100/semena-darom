@extends('layouts.main')

@section('title', 'Регистрация')

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
  <div class="active">регистрация</div>
</div>

<div class="lk-register lk-login">
  <div class="page-title">Регистрация</span></div>
    <div class="row">
      <div class="col-xl-3 col-md-4">
        <div class="lk-login-text">Введите Ваши данные</div>

        @if($errors->any())
          <div class="alert alert-danger cart-errors">
            <ul>
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form class="form" action="{{ route('register') }}" method="POST">
          <div class="form-group">
            <label for="name" class="form-label">Имя</label>
            <input type="text" name="name" id="name" class="input-field" value="{{ old('name') }}" required autofocus>
          </div>

          <div class="form-group">
            <label for="email" class="form-label">Емайл</label>
            <input type="email" name="email" id="email" class="input-field" value="{{ old('email') }}" required>
          </div>

          <div class="form-group">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" name="password" id="password" class="input-field" min="8" max="20" required>
          </div>

          <div class="form-group">
            <label for="password_confirmation" class="form-label">Подтвердить пароль</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" min="8" max="20" required>
          </div>

          <div class="checkbox-wrapper">
            <input type="checkbox" name="checkbox" class="custom-checkbox" id="checkbox-register" checked required onchange="document.querySelector('.js-submit-btn').disabled = !this.checked;">
            <label for="checkbox-register" class="custom-checkbox-label"></label>
            <span class="checkbox-text">Согласен с <a href="/politika-konfidencialnosti" class="privacy-policy-btn" target="_blank">политикой обработки персональных данных</a></span>
          </div>

          <div class="g-recaptcha" data-sitekey="{{ config('google.client_key') }}"></div>

          @csrf
          <button type="submit" class="submit-btn js-submit-btn">Зарегистрироваться</button>
        </form>
      </div>
    </div>
</div>

@endsection

@section('script')
  <script src="https://www.google.com/recaptcha/api.js"></script>
@endsection