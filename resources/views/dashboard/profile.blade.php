@extends('dashboard.layout')

@section('title', 'Профиль')

@section('dashboardcontent')

<div class="dashboard-content">

  <div class="edit-item">

    <h5 class="lk-login-text mb-3">Обновить данные</h5>
    <form id="send-verification" class="form" action="{{ route('verification.send') }}" method="post">
        @csrf
    </form>
    <form class="form mb-5" action="{{ route('admin.profile.update') }}" method="post">
      @csrf
      @method('patch')

      <div class="form-group mb-3">
        <label for="name" class="form-label">Имя</label>
        <input type="text" name="name" id="name" class="form-control input-field" value="{{ $admin->name }}" required autofocus>
      </div>

      <div class="form-group mb-3">
        <label for="email" class="form-label">Емайл</label>
        <input type="email" name="email" id="email" class="form-control input-field" value="{{ $admin->email }}" required>
      </div>

      <button type="submit" class="btn btn-primary submit-btn js-submit-btn">Обновить</button>
    </form>

  </div>

  <div class="edit-item">

    <h5 class="lk-login-text mb-3">Обновить пароль</h5>
    
    <form class="form mb-5" action="{{ route('password.update') }}" method="post">
      @csrf
      @method('put')

      <div class="form-group mb-3">
        <label for="current_password" class="form-label">Текущий пароль</label>
        <input type="password" name="current_password" id="current_password" class="form-control input-field" min="8" max="20" required>
      </div>

      <div class="form-group mb-3">
        <label for="password" class="form-label">Новый пароль</label>
        <input type="password" name="password" id="password" class="form-control input-field" min="8" max="20" required>
      </div>

      <div class="form-group mb-3">
        <label for="password_confirmation" class="form-label">Подтвердить пароль</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-field" min="8" max="20" required>
      </div>

      <button type="submit" class="btn btn-primary submit-btn js-submit-btn">Обновить</button>
    </form>

  </div>

  <div class="edit-item">

    <h5 class="lk-login-text mb-3">Удалить профиль</h5>
    <form class="form mb-5" action="{{ route('admin.profile.destroy') }}" method="post">
      @csrf
      @method('delete')

      <p>Введите пароль чтобы подтвердить удаление</p>

      <div class="form-group mb-3">
        <label for="password" class="form-label">Пароль</label>
        <input type="password" name="password" id="password" class="form-control input-field" min="8" max="20" required>
      </div>

      <button type="submit" class="btn btn-primary submit-btn js-submit-btn">Удалить</button>
    </form>
  </div>

</div>

@endsection 