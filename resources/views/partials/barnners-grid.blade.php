<ul class="banners-grid list-unstyled d-md-flex mb-1">
  @isset($featured[0])
  <li>
    <a href="/category/{{$featured[0]->slug}}" class="img-container">
      <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
           data-src="{{$featured[0]->image}}" alt="" class="lazyload">
      <div class="short-info">
        <h3>{{$featured[0]->name}}</h3>
      </div>
    </a>
  </li>
  @endisset
  @isset($featured[1])
  <li>
    <a href="/category/{{$featured[1]->slug}}" class="img-container">
      <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
           data-src="{{$featured[1]->image}}" alt="" class="lazyload">
      <div class="short-info">
        <h3>{{$featured[1]->name}}</h3>
      </div>
    </a>
  </li>
  @endisset
  @isset($featured[2], $featured[3])
  <li>
    <a href="/category/{{$featured[2]->slug}}" class="img-container two">
      <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
           data-src="{{$featured[2]->image}}" alt="" class="lazyload right">
      <div class="short-info">
        <h3>{{$featured[2]->name}}</h3>
      </div>
    </a>
    <a href="/category/{{$featured[3]->slug}}" class="img-container two">
      <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
           data-src="{{$featured[3]->image}}" alt="" class="lazyload">
      <div class="short-info">
        <h3>{{$featured[3]->name}}</h3>
      </div>
    </a>
  </li>
  @endisset

</ul>
