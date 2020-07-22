<div class="list-products mt-3">
  @foreach($array as $item)
    @if($loop->index % 2 === 0)
      <div class="row"> @endif

        <div class="col-12 mb-3">
          <div class="row product mb-4">
            <div class="col-xl-2 col-lg-3 col-md-4 col-12">
              <div class="image">
                <a href="/product/{{$item->slug}}">
                  <img class="img-fluid lazyload" data-src="{{ $item->media[0] }}"
                       src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="">
                  <img class="img-fluid lazyload"
                       data-src="{{ count($item->media) > 1 ? $item->media[1] : $item->media[0] }}"
                       src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="">
                </a>
              </div>
              <div class="labels">
                @if($item->new)
                  <div class="new">{{__('client.new')}}</div>@endif
                @if($item->sale_price)
                  <div class="sale">{{__('client.sale')}}</div>@endif
              </div>
            </div>
            <div class="col-xl-10 col-lg-9 col-md-8 col-12 details">

              <a href="/product/{{$item->slug}}">
                <h4 class="mt-2">{{$item->name}}</h4>
              </a>
              <div>
                {{ $item->summary }}
              </div>
              <hr class="mb-2 mt-2">
              <div class="price-box">
                <span class="special-price">{{$item->sale_price ? number_format($item->sale_price, 0, ',', ',') : number_format($item->price, 0, ',', ',')}}₫</span>
                @if($item->sale_price)<span class="old-price">{{number_format($item->price, 0, ',', ',')}}₫</span>@endif
              </div>
            </div>
          </div>
        </div>

        @if($loop->index % 2 === 1  || $loop->last)
      </div>@endif
  @endforeach
</div>
<nav class="nav-pagination">
  <ul class="nav justify-content-center">
    @for($x = 1; $x <= intval(ceil($array->total() / $array->perPage())); $x++)
      @if($x === 1)
        <li class="nav-item">
          <a class="nav-link{{ $array->currentPage() === $x ? " disabled": "" }}" data-page="{{$array->currentPage() - 1}}"><i class="las la-angle-left"></i></a>
        </li>
      @endif

      <li class="nav-item">
        <a class="nav-link{{ $array->currentPage() === $x ? " active disabled" : "" }}" data-page="{{$x}}">{{$x}}</a>
      </li>

      @if($x === intval(ceil($array->total() / $array->perPage())))
        <li class="nav-item">
          <a class="nav-link{{ $array->currentPage() === $x ? " disabled": "" }}" data-page="{{$array->currentPage() + 1}}"><i class="las la-angle-right"></i></a>
        </li>
      @endif
    @endfor
  </ul>
</nav>
@section('script-pagination')
<script>
  $(".nav-pagination").on("click",".nav-link",(e) => {
    const { page: id } = e.target.dataset
    const { pathname, search } = window.location
    const title = "|page|";
    if (!search || search.indexOf(title) < 0)
      document.location.href = pathname + (!!search ? search + "&": "?") + title + "=\"" + id + "\"";
    else document.location.href = search.split("&").map((item) => {
      if (item.indexOf(title) > -1) return (item.indexOf("?") > -1 ? "?" : "") + title + "=\"" + id + "\""
      return item
    }).join("&")
  });

</script>
@endsection
