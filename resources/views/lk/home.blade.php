@extends('layouts.main')

@section('title', 'Личный кабинет')

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
  <div class="active">личный кабинет</div>
</div>

<div class="lk">
  <div class="page-title">Личный кабинет</div>
  

</div>

@endsection 