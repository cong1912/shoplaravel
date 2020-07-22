<div class="col-lg-3 d-lg-block filter pt-lg-0 pb-lg-0 pt-3 pb-3">
  <h4>{{__('client.shopBy')}} <a class="text-dark open-close d-block d-lg-none float-right" data-menu-show=".filter"><i class="las la-times"></i></a></h4>
  <form name="filter-product" class="accordion" method="GET">
    <div class="card d-table w-100">
      <button class="btn text-left w-100" type="button" data-toggle="collapse" data-target=".collapseZero">
        <i class="las la-coins"></i> {{__('client.price')}}
        <i class="las la-angle-up float-right mt-1"></i>
      </button>
      <div class="collapse show collapseZero">
        <div class="card-body">
          <div class="slider-wrapper mt-5">
            <div
              id="slider-range"
              data-max="{{$inputs["max_price"]}}"
              data-min="{{$inputs["min_price"]}}"
              data-min-value="{{isset($inputs["|price_range|"]) ? $inputs["|price_range|"][0]:null}}"
              data-max-value="{{isset($inputs["|price_range|"]) ? $inputs["|price_range|"][1]:null}}"
            ></div>

            <div class="range-wrapper">
              <div class="range"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @isset($categories)
      @include("partials.filter-product-item", ["name" => __('client.category'),"slug" => "|category|","icon" => "la-sitemap","children" => $categories,"input" => $inputs, "id" => "primary"])
    @endisset
    @isset($brands)
      @include("partials.filter-product-item", ["name" => __('client.brand'),"slug" => "|brand|","icon" => "la-industry","children" => $brands, "input" => $inputs, "id" => "primary"])
    @endisset

    @foreach($attributes as $item)
      @include("partials.filter-product-item", ["name" => $item->name,"slug" => "|attribute|","icon" => $item->icon,"children" => $item->children, "input" => $inputs, "id" => $item->id])
    @endforeach
    <div class="card d-table w-100">
      <button class="btn btn-primary w-100" id="submit-form" type="button" data-form="filter-product">
        <i class="las la-filter"></i> {{__('client.filterProducts')}}
      </button>
      <button class="btn btn-danger w-100" id="reset-form" type="button">
        <i class="las la-ban"></i> {{__('client.clearProductFiltering')}}
      </button>
    </div>
  </form>
</div>
@section('script-filter')
<script>
  // Initiate Slider
  const sliderRange = $("#slider-range");
  let max = sliderRange.data("max") + "";
  max = parseInt(max.substring(0, max.length - 3));
  let min = sliderRange.data("min") + "";
  min = parseInt(min.substring(0, min.length - 3));
  const minValue = !!sliderRange.data("min-value") ? sliderRange.data("min-value") : min;
  const maxValue = !!sliderRange.data("max-value") ? sliderRange.data("max-value") : max;
  sliderRange.slider({
    range: true,
    min: min < minValue ? min : minValue,
    max: max > maxValue ? max : maxValue,
    step: 1,
    values: [minValue, maxValue]
  });

  // Move the range wrapper into the generated divs
  $(".ui-slider-range").append($(".range-wrapper"));

  // Apply initial values to the range container
  $(".range").html(`<span class="range-value">${sliderRange.slider("values", 0).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}K<sup>đ</sup></span><span class="range-divider"></span><span class="range-value">${sliderRange.slider("values", 1).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}K<sup>đ</sup></span>`);

  sliderRange.slider({
    slide: function(event, ui) {
      $(".range").html(`<span class="range-value">${ui.values[0].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}K<sup>đ</sup></span><span class="range-divider"></span><span class="range-value">${ui.values[1].toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")}K<sup>đ</sup></span>`);
    }
  });

  document.getElementById("submit-form").addEventListener("click", (e) => {
    const data = {
      "|price_range|": sliderRange.slider("values"),
      "|page|": "1",
      "|category|": null,
      "|brand|": null,
      "|attribute|": null,
    }
    const { elements } = document[e.target.dataset.form]
    for(let i = 0; i < elements.length; ++i){
      if(elements[i].checked){
        if (!data[elements[i].name]) {
          data[elements[i].name] = []
        }
        data[elements[i].name].push(elements[i].value)
      }
    }
    handleChangeUrl(data);
  })

  const handleChangeUrl = (data) => {
    const { pathname, search } = window.location
    let url = pathname + (search.indexOf("?") === 0 ? search : "" )
    for (let key in data) {
      if (search.indexOf(key) === -1 || url.indexOf(key) === -1) {
        url += (url.indexOf("?") === -1 && data[key] ? "?" : "&") + (data[key] ? key + "=" + JSON.stringify(data[key]) : "");
      } else {
        let tempSearch = url.indexOf(key) === -1 ? search : url;
        tempSearch =  tempSearch.split("&").map((item, index) => {
          if (item.indexOf(key) > -1) {
            if (data[key] === null) return null
            return (index === 0 ? "?" : "") + key + "=" + JSON.stringify(data[key]);
          }
          return item
        })
        tempSearch = tempSearch.filter((item) => item);
        url = tempSearch.join("&")
      }
    }
    url = url.split("&").filter((item) => item).join("&")
    document.location.href = url;
  }

  document.getElementById("reset-form").addEventListener("click", (e) => {
    const data = {
      "|price_range|": null,
      "|page|": "1",
      "|category|": null,
      "|brand|": null,
      "|attribute|": null,
    }
    handleChangeUrl(data);
  });
</script>
@endsection
