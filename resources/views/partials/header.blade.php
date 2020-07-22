<header class="header">
  <div class="main-header">
    <div class="container">
      <div class="row small-gutters">
        <div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
          <div class="text-lg-left text-center logo">
            <a href="/"><img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                    data-src="/images/logo.svg" alt="" height="30" class="lazyload"></a>
          </div>
        </div>
        <div class="col-xl-6 col-lg-7">
          <a class="open-close show-menu d-block d-lg-none" data-menu-show=".main-menu" href="javascript:void(0);">
            <i class="las la-bars"></i>
          </a>
          <div class="main-menu">
            <div class="header-menu text-center">
              <a><img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                      data-src="images/logo.svg" alt="" height="30" class="lazyload"></a>
              <a href="#" class="open-close close-menu" data-menu-show=".main-menu"><i class="las la-times"></i></a>
            </div>
            <ul class="nav">
              @foreach($menus as $menu)
                <li class="nav-item">
                  <a class="nav-link " href="{{$menu->is_homepage ? "/": "/page/".$menu->page_slug}}">{{$menu->name}}</a>
                </li>
              @endforeach

            </ul>
          </div>
        </div>
        <div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-right">
          <a class="phone-top" href="tel://9438843343">
            <div><strong>{{__('client.support')}}</strong><br/>+94 423-23-221</div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="main-nav">
    <div class="container">
      <div class="row small-gutters">
        <div class="col-md-4 col">
          <ul class="nav d-none d-md-inline-block">
            <li class="nav-item">
              <div class="dropdown dropdown-left">
                <a class="nav-link pl-0 d-flex align-items-center font-size-15" href="#">
                  <i class="las la-bars mr-2"></i> <strong>{{__('client.allCategories')}}</strong>
                </a>
                <div class="dropdown-menu pt-0 pb-0">
                  <div class="row mr-0 ml-0">
                    @for ($i = 0; $i < count($array); $i++)
                      @if($i === 0 || $array[$i]->col !== $array[$i - 1]->col)
                        <div class="col"> @endif

                          <h5 class="pt-3 pb-2 text-center"><i
                              class="las {{$array[$i]->icon}}"></i> {{$array[$i]->name}}</h5>
                          @if (count($array[$i]->children) > 0)
                            <ul>
                              @foreach($array[$i]->children as $subItem)
                                <li>
                                  <a href="/category/{{ $subItem->url }}">{{ $subItem->name }} ({{$subItem->products_count}})</a>
                                </li>
                              @endforeach
                            </ul>
                          @endif
                          @if($i + 1 === count($array) || $array[$i + 1]->col !== $array[$i]->col)
                        </div> @endif
                    @endfor
                  </div>
                </div>
              </div>
            </li>
          </ul>
          <a class="nav-link d-flex align-items-center font-size-15 show-menu-category d-inline-block d-md-none"
             href="#">
            <strong>{{__('client.allCategories')}}</strong>
          </a>
        </div>
        <div class="col-md-5 col d-md-flex align-items-center search">
          <div class="d-block d-md-none">
            <ul class="nav justify-content-end">
              <li class="nav-item">
                <a class="nav-link show-search-mobile">
                  <i class="las la-search"></i>
                </a>
              </li>
              @yield('cart')
            </ul>
          </div>
          <form action="/search" class="input-group d-none d-md-flex">
            <input type="text" name="product" class="form-control" placeholder="{{__('client.searchOver1kProducts')}}" required value="{{isset($inputs["product"]) ? $inputs["product"] : ""}}">
            <div class="input-group-prepend">
              <button type="submit" class="input-group-text button-search">
                <i class="las la-search"></i>
              </button>
            </div>
          </form>
        </div>
        <div class="col-md-3 d-none d-md-block">
          <ul class="nav justify-content-end">
            @yield('cart')
          </ul>
        </div>
      </div>
    </div>
    <form action="/search" class="container search-mobile">
      <div class="input-group mt-1">
        <input type="text" name="product" class="form-control" value="{{isset($inputs["product"]) ? $inputs["product"] : ""}}" placeholder="{{__('client.searchOver1kProducts')}}" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block mt-3 mb-3 button-search">{{__('client.shopNow')}}</button>
    </form>
  </div>
</header>
@section("script-header")
<script>
  // Scroll menu -----------------------------------------------------------------------------

  const CheckMenu = (element, topCurrent) => {
    const _self = $(element);
    const _prev = $(element).prev();
    const _topMenu = _prev.position().top + _self.height();
    if (_topMenu < topCurrent && !_self.hasClass("sticky-menu")) {
      _self.addClass("sticky-menu");
      _prev.css("margin-bottom", _self.height());
    } else if (_topMenu > topCurrent && _self.hasClass("sticky-menu")) {
      _self.removeClass("sticky-menu");
      _prev.css("margin-bottom", 0);
    }
  };
  CheckMenu(".main-nav", $(window).scrollTop());
  $(window).scroll((e) => {
    CheckMenu(".main-nav", e.currentTarget.pageYOffset);
  });

  // Menu mobile -----------------------------------------------------------------------------
  $(".open-close").click((e) => {
    $(e.currentTarget.dataset.menuShow).toggleClass("show");
  });

  const menu = new MmenuLight(
    document.querySelector( "#my-menu" ),
    "(max-width: 767px)"
  );

  menu.navigation({
    title: "{{__('client.allCategories')}}",
    theme: "dark"
  });
  const drawer = menu.offcanvas();
  $(".show-menu-category").click(() => {
    drawer.open();
  });


  // Search Mobile --------------------------------------------------------------------------
  $(".show-search-mobile").click(() => {
    console.log($(".search-mobile"));
    $(".search-mobile").toggleClass("show");
  });
</script>
@endsection
