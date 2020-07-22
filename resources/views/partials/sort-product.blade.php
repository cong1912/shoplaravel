<h3>
  {{$name}}
  <button class="btn btn-outline-danger float-right d-block d-lg-none open-close" data-menu-show=".filter">
    <i class="las la-filter"></i>
  </button>
</h3>
<form name="sort-product" class="form-row justify-content-end" action="">
  @foreach($selects as $key=>$item)
  <div class="col-auto">
    <select name="{{$key}}" class="form-control select2">
      @foreach($item as $itemSelect)
      <option value="{{$itemSelect["value"]}}" title="{{$key}}" {{isset($inputs[$key]) && $inputs[$key] === $itemSelect["value"] ? "selected" : "" }}>
        {{$itemSelect["text"]}}
      </option>
      @endforeach
    </select>
  </div>
  @endforeach
</form>
@section('script-sort')
<script>
  $(".select2").select2({ theme: "bootstrap" }).on('select2:select', function (e) {
    const { id, title } = e.params.data;
    const { pathname, search } = window.location
    if (!search || search.indexOf(title) < 0)
      document.location.href = pathname + (!!search ? search + "&": "?") + title + "=\"" + id + "\"";
    else document.location.href = search.split("&").map((item) => {
      if (item.indexOf(title) > -1) return (item.indexOf("?") > -1 ? "?" : "") + title + "=\"" + id + "\""
      return item
    }).join("&")
  });

</script>
@endsection
