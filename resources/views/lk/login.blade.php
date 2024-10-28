@extends('layouts.main')

@section('title', 'Войти в личный кабинет')

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
  <div class="active">войти в личный кабинет</div>
</div>

<div class="lk-login">
  <div class="page-title">Войти<br><span class="green-text">в личный кабинет</span></div>
  <div class="row">
    <div class="col-xl-3 col-md-4">
      <div class="lk-login-subtitle"><span class="green-text">Вход</span></div>
      <div class="lk-login-text">Введите Ваши данные</div>
      <form class="form" action="{{ route('login') }}" method="POST">
        <div class="form-group">
          <label for="email" class="form-label">Емайл</label>
          <input type="email" name="email" id="email" class="input-field" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
          <label for="password" class="form-label">Пароль</label>
          <input type="password" name="password" id="password" class="input-field" required>
        </div>
        <div class="checkbox-wrapper">
          <input type="checkbox" name="remember_me" class="custom-checkbox" id="checkbox-remember" checked>
          <label for="checkbox-remember" class="custom-checkbox-label"></label>
          <span class="checkbox-text">Запомнить меня</span>
        </div>

        @csrf
        <button type="submit" class="submit-btn js-submit-btn">Войти</button>
      </form>
    </div>
    <div class="col-xl-3 col-md-1"></div>
    <div class="col-xl-3 col-md-4">
      <div class="lk-login-subtitle">Нет акаунта?</div>
      <div class="lk-login-text">Зарегистрируйтесь на сайте и получайте первыми новости о скидках и распродажах!</div>
      <a href="{{ route('register') }}" class="submit-btn register-btn">Зарегистрироваться</a>
    </div>
  </div>
</div>

@endsection 