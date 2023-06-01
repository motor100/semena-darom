@extends('layouts.main')

@section('title', 'Каталог')

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
  <div class="active">каталог</div>
</div>

<div class="catalog">
  @if(isset($category_title))
    <div class="page-title">{{ $category_title }}</div>
  @else
    <div class="page-title">Каталог</div>
  @endif

  @foreach($products as $product)
    <p>{{ $product->title }}</p>
  @endforeach

  
</div> 

@endsection