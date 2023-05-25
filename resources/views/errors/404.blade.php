@extends('layouts.main')

@section('title', '404')

@section('content')
<div class="page404">
  <div class="container">
    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="image404">
          <img src="/img/404.png" alt="">
        </div>
        <div class="text404">УПС.... Что-то пошло не так или такой страницы не существует(</div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4 ms-auto">
        <div class="btn404 white-btn" onclick="history.back();">Вернуться назад</div>
      </div>
      <div class="col-md-4 me-auto">
        <a href="{{ route('home') }}" class="btn404 purple-btn">Главная</a>
      </div>
    </div>
  </div>
</div>
@endsection  