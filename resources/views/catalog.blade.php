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
    <a href="{{ route('home') }}">главная</a>
  </div>
  <div class="arrow"></div>
  <div class="parent">
    <a href="{{ route('catalog') }}">каталог</a>
  </div>
  
</div>

<div class="catalog-page">
  <div class="page-title">Каталог</div>

  <div class="catalog-nav-wrapper">
    <div class="catalog-nav">
      <div class="catalog-nav-top-row">
        <div class="aside-nav-item">
          <div class="aside-nav-item__image">
            <img src="{{ asset('img/percent-icon.svg') }}" alt="">
          </div>
          <div class="aside-nav-item__title">Акции</div>
          <a href="/akcii" class="full-link"></a>
        </div>
        <div class="aside-nav-item">
          <div class="aside-nav-item__image">
            <img src="{{ asset('img/package-icon.svg') }}" alt="">
          </div>
          <div class="aside-nav-item__title">Новинки</div>
          <a href="/novinki" class="full-link"></a>
        </div>
      </div>
      <div class="catalog-nav-categories">
      
        @foreach($parent_categories as $cat)
          <div class="catalog-nav-category">
            <div class="aside-nav-item">
              <div class="aside-nav-item__image">
                <img src="{{ Storage::url($cat->image) }}" alt="">
              </div>
              <div class="aside-nav-item__title">{{ $cat->title }}</div>
              @if(!$cat->child_category)
                <a href="{{ route('category', ['category' => $cat->slug]) }}" class="full-link"></a>
              @endif
            </div>
            @if($cat->child_category)
              <div class="catalog-nav-subcategories">
                @foreach($cat->child_category as $ct)
                  <a href="{{ route('category', ['category' => $ct->slug]) }}" class="catalog-nav-subcategory-title">{{ $ct->title }}</a>
                @endforeach
              </div>
            @endif
          </div>
        @endforeach

      </div>
    </div>
  </div>

</div> 

@endsection