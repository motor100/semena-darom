@section('title', $page->title)

@section('robots')
  <meta name="robots" content="noindex, nofollow">
@endsection

@extends('layouts.main')

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
  <div class="active">{{ $page->title }}</div>
</div>

<div class="polzovatelskoe-soglashenie-s-publichnoj-ofertoj">
  <div class="section-title-wrapper">
    <div class="section-title">
      <div class="section-title__text">{{ $page->title }}</div>
    </div>
    <div class="text">
      {!! $page->text !!}
    </div>
  </div>
</div>

@endsection