<div class="container slide-product">
  <div class="row">
    <div class="col d-block d-lg-flex justify-content-between align-items-center header mt-4">
      <h3 class="mb-0 pr-2 text-center text-lg-left">{{$title}}</h3>
    </div>
  </div>
  <div class="row">
    <div class="col mt-4">
      <ul class="list-unstyled action-slide">
        @foreach($array as $item)
          @if($loop->index % 2 === 0)
            <li> @endif
              <div class="product">
                <div class="image">
                  <a href="/product/{{$item->slug}}">
                    <img class="img-fluid lazyload" data-src="{{ $item->media[0] }}"
                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="">
                    <img class="img-fluid lazyload"
                         data-src="{{ count($item->media) > 1 ? $item->media[1] : $item->media[0] }}"
                         src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="">
                  </a>
                  <div class="actions">
                    <a href="/product/{{$item->slug}}">
                      <i class="las la-eye"></i>
                      <span>{{__('client.detail')}}</span>
                    </a>
                  </div>
                  <div class="labels">
                    @if($item->new)
                      <div class="new">{{__('client.new')}}</div>@endif
                    @if($item->sale_price)
                      <div class="sale">{{__('client.sale')}}</div>@endif
                  </div>
                </div>
                <div class="details">
                  <a href="/product/{{$item->slug}}">
                    {{$item->name}}
                  </a>
                  <div class="price-box">
                    <span class="special-price">{{$item->sale_price ? number_format($item->sale_price, 0, ',', ',') : number_format($item->price, 0, ',', ',')}}₫</span>
                    @if($item->sale_price)<span class="old-price">{{number_format($item->price, 0, ',', ',')}}₫</span>@endif
                  </div>
                </div>
              </div>
              @if($loop->index % 2 === 1  || $loop->last)
            </li>@endif
        @endforeach
      </ul>
    </div>
  </div>
</div>
