<div class="slide-brand {{$classExtend ? $classExtend : ""}}">
  @foreach($array as $item)
    <div class="item">
      <a href="/brand/{{$item->slug}}"><img
          src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
          data-src="{{$item->logo}}" class="lazyload img-fluid"></a>
    </div>
  @endforeach
</div>
