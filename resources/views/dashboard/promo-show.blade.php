@extends('dashboard.layout')

@section('title', $promo->title)

@section('dashboardcontent')

<div class="dashboard-content">

  <p class="show-item">{{ $promo->title }}</p>
  <p class="show-item">Скидка {{ $promo->discount }}%</p>
  <div class="show-item show-item__image">
    <img src="{{ Storage::url($promo->image) }}" alt="">
  </div>

<script>
  const menuItem = 2;
</script>

@endsection