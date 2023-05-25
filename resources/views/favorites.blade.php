@extends('layouts.main')

@section('title', 'Избранное')

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
  <div class="active">избранное</div>
</div>

<div class="favorites">
  <div class="content-wrapper">
    <div class="favorites-title">Избранное</div>
  


  </div>
</div>

@endsection