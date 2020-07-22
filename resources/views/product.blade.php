@extends('layouts.app')

@section('title', 'Product')
@section('cart')
  @include("partials.nav-cart")
@endsection

@section('content')
  @isset($featured)
    @include("partials.barnners-grid")
  @endisset

  <div class="container mt-3 mb-4">
    <div class="row mt-5">
      <div class="col-xl-4 col-lg-5 col-md-6">
        <div class="slide-detail">
          @foreach($product->media as $item)
            <a href="{{$item}}">
              <img class="img-fluid lazyload" id="image-product" data-src="{{$item}}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="">
            </a>
          @endforeach
        </div>
        <div class="slider-nav">
          @foreach($product->media as $item)
            <div class="pl-1 pr-1 pt-2">
              <img class="img-fluid lazyload" data-src="{{$item}}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="">
            </div>
          @endforeach
        </div>
      </div>
      <div class="col-xl-8 col-lg-7 col-md-6 product">
        <div class="details mb-2">
          <h4 id="title-product">{{$product->name}}</h4>
          <h6 class="mb-3"><a href="/brand/{{$product->brand->slug}}" class="text-dark"><i class="las la-industry"></i> {{$product->brand->name}}</a></h6>
          <div class="labels d-flex">
            @if($product->new)
              <div class="new">New</div>@endif
            @if($product->sale_price)
              <div class="sale ml-2">Sale</div>@endif
          </div>
        </div>
        <div>
          {{$product->summary}}
        </div>
        <div class="details">
          <div class="price-box mb-3">
            <span class="special-price font-size-20">
              {{$product->sale_price ? number_format($product->sale_price, 0, ',', ','): number_format($product->price, 0, ',', ',')}}₫
            </span>
            <span class="old-price font-size-20{{ !!$product->sale_price ? "" : " d-none"}}">{{number_format($product->price, 0, ',', ',')}}₫</span>
          </div>
        </div>
        <form name="product-attribute">
          @foreach($product->productAttributes as $item)
            <div>
              <label class="d-flex align-items-center position-relative">
                <span class="checkbox bounce mr-1">
                  <input type="radio" name="attribute" value='{!!$item!!}'>
                  <svg viewBox="0 0 21 21">
                    <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
                  </svg>
                </span>
                <span id="attribute-{{$item->id}}">
                  @foreach($item->attributes_ids as $subItem)
                    {{$attributes[$subItem]->name}} @if(!$loop->last)<br> @endif
                  @endforeach
                </span>
              </label>
              <hr>
            </div>
          @endforeach
        </form>
        <div class="input-number">
          <input name="product-quality" id="product-quality" type="number" value="1" min="0" max="100" step="1" {{count($product->productAttributes) === 0 ? "" : "disabled"}}>
        </div>
        <button class="btn btn-danger mt-2 btn-lg" id="add-to-cart" data-url="/product/{{$product->slug}}" type="button" disabled data-product-id="{{$product->id}}">
          <i class="las la-shopping-cart"></i> Thêm vào giỏ
        </button>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-12">
        {!! $product->description !!}
      </div>
    </div>
  </div>

  @include("partials.slide-product", ["title" => "Sản phẩm liên quan", "array" => $products])

  @include("partials.slide-brand", ["classExtend" => "", "array" => $brands])
@endsection
@section("script")
  <script>
    let name_attribute = "";
    $("input[type='number']").InputSpinner();
    const { elements } = document["product-attribute"];
    for(let i = 0; i < elements.length; ++i){
      elements[i].addEventListener('change', (event) => {
        const value = JSON.parse(event.target.value);
        const element = document.getElementById("attribute-" + value.id);
        name_attribute = element.innerText;
        let price;
        if (!!value.sale_price) {
          price = value.sale_price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          const sale_price = value.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
          $(".old-price").removeClass("d-none").text(sale_price + "₫");
        }
        else {
          price = value.price.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
          $(".old-price").addClass("d-none");
        }
        $(".special-price").text(price + "₫");
        let quantity = $(".cart-product-" + value.id).attr("data-quantity");
        quantity = !!quantity ? parseInt(quantity) : 0;
        if (value.quantity - quantity > 0) {
          const input = $("#product-quality");
          $("#add-to-cart").attr("disabled", false).attr("product", event.target.value).attr("data-id", value.id);
          input.attr("disabled", false)
          input.attr("max", value.quantity)
          input.val(1)
        }
      })
    }
  </script>
@endsection
