@extends('layouts.main')

@section('title', 'Каталог')

@section('style')
  <link rel="stylesheet" href="{{ asset('css/slimselect.min.css') }}">
@endsection

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
  <div class="parent">
    <a href="{{ route('catalog') }}">каталог</a>
  </div>
  
</div>

<div class="catalog">
  <div class="page-title">Каталог</div>

  @foreach($categories as $category)
    <p>
      <a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a>
    </p>
  @endforeach

  

  

</div> 

@endsection