@extends('layouts.app')

@section('title', $page->name)
@section('cart')
  @include("partials.nav-cart")
@endsection

@section('content')
  @isset($featured)
    @include("partials.barnners-grid")
  @endisset
  <div class="container mt-3 mb-4">
    {!! $page->body !!}
  </div>
  @include("partials.slide-brand", ["classExtend" => "", "array" => $brands])
@endsection
