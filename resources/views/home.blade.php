@extends('layouts.main')

@section('title', 'Купить семена с доставкой по всей России')

@section('content')

  <p>Товары</p>

  @foreach($products as $product)
    <div class="item">
      <div class="item-title">{{ $product->title }}</div>
    </div>
  @endforeach

  

@endsection