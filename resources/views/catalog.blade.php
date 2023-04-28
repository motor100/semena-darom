@extends('layouts.main')

@section('title', 'Каталог')

@section('content')

<div class="breadcrumbs">
  <div class="container">
    <div class="parent">
      <a href="{{ route('home') }}">главная страница</a>
    </div>
    <div class="arrow"></div>
    <div class="active">каталог</div>
  </div>
</div>

<div class="kontakty">
  <div class="page-title">Каталог</div>

  <div class="content-wrapper">

    <p>Категории</p>
    <div class="categories">
      @foreach($categories as $cat)
        <p>{{ $cat->title }}</p>
      @endforeach
    </div>

  </div>
  
</div> 

@endsection