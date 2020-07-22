@extends('layouts.app')

@section('title', __('client.homePage'))
@section('cart')
  @include("partials.nav-cart")
@endsection

@section('content')
    <div class="slide-show">
      @foreach($slides as $item)
      <div class="cover d-flex align-items-center" style="background-image: url({{$item->image}});">
        <div class="container text-{{$item->position}}">
          <h2>{!! $item->name!!}</h2>
          <p>{!! $item->body !!}</p>
          @isset($item->button)<a class="btn btn-danger" href="{{$item->url}}" role="button">{{$item->button}}</a>@endisset
        </div>
      </div>
      @endforeach
    </div>

    @isset($featured)
      @include("partials.barnners-grid")
    @endisset
    @include("partials.slide-brand", ["classExtend" => "mb-5", "array" => $brands])
    @include("partials.slide-product", ["title" => __('client.sellingProducts'), "array" => $productFeatured])
    @include("partials.slide-product", ["title" => __('client.newProducts'), "array" => $productNew])

@endsection
