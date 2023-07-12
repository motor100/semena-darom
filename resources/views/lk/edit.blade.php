@extends('layouts.main')

@section('title', 'Личные данные')

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
  <div class="active">личные данные</div>
</div>

<div class="lk-edit lk-login">
  <div class="page-title">Личные данные</div>

  @include('lk.lk-navigation')

  <div class="lk-edit-wrapper">

    <div class="edit-item">
      <div class="row">
        <div class="col-3">
          <div class="lk-login-text">Обновить данные</div>
          <form id="send-verification" method="post" action="{{ route('verification.send') }}">
              @csrf
          </form>
          <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            <div class="form-group">
              <label for="name" class="form-label">Имя</label>
              <input type="text" name="name" id="name" class="input-field" value="{{ $user->name }}" required autofocus>
            </div>

            <div class="form-group">
              <label for="email" class="form-label">Емайл</label>
              <input type="email" name="email" id="email" class="input-field" value="{{ $user->email }}" required>
            </div>

            <button type="submit" class="submit-btn js-submit-btn">Обновить</button>
          </form>
        </div>
      </div>
    </div>

    <div class="edit-item">
      <div class="row">
        <div class="col-3">
          <div class="lk-login-text">Обновить пароль</div>
          
          <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
            @csrf
            @method('put')

            <div class="form-group">
              <label for="current_password" class="form-label">Текущий пароль</label>
              <input type="password" name="current_password" id="current_password" class="input-field" min="8" max="20" required>
            </div>


            <div class="form-group">
              <label for="password" class="form-label">Новый пароль</label>
              <input type="password" name="password" id="password" class="input-field" min="8" max="20" required>
            </div>

            <div class="form-group">
              <label for="password_confirmation" class="form-label">Подтвердить пароль</label>
              <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" min="8" max="20" required>
            </div>

            <button type="submit" class="submit-btn js-submit-btn">Обновить</button>
          </form>
        </div>
      </div>
    </div>

    <div class="edit-item">
      <div class="row">
        <div class="col-3">
          <div class="lk-login-text">Удалить профиль</div>
          <form class="form" action="{{ route('profile.destroy') }}" method="post">
              @csrf
              @method('delete')

              <p>Введите пароль чтобы подтвердить удаление</p>

              <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" name="password" id="password" class="input-field" min="8" max="20" required>
              </div>

              <button type="submit" class="submit-btn js-submit-btn">Удалить</button>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection 