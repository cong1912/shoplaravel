@extends('layouts.app')

@section('title', __('client.category'))
@section('cart')
  @include("partials.nav-cart")
@endsection

@section('content')
  @isset($featured)
    @include("partials.barnners-grid")
  @endisset

  <div class="container mt-3 mb-5">
    <div class="row mb-5 mt-5">
      @include("partials.filter-product", ["categories" => null, "brands" => $brands, "attributes" => $attributes, "inputs" => $inputs])
      <div class="col-lg-9 col-md-12">
        @include("partials.sort-product", ["name" => $category->name, "inputs" => $inputs, "selects" => $selects])

        @include("partials.list-product", ["array" => $products])

      </div>
    </div>
  </div>

  @include("partials.slide-brand", ["classExtend" => "", "array" => $brands])
@endsection
