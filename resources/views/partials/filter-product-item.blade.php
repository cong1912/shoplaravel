<div class="card d-table w-100">
  <button class="btn text-left w-100" type="button" data-toggle="collapse" data-target=".collapse{{$id}}">
    <i class="las {{$icon}}"></i> {{$name}}
    <i class="las la-angle-up float-right mt-1"></i>
  </button>
  <div class="collapse show collapse{{$id}}">
    <div class="card-body">
      @foreach($children as $subItem)
        <label class="d-flex align-items-center position-relative">
          <span class="checkbox bounce mr-1">
            <input type="checkbox" name="{{$slug}}" value="{{$subItem->slug}}" {{  isset($input[$slug]) && array_search($subItem->slug, $input[$slug]) > -1 ? "checked" : "" }}>
            <svg viewBox="0 0 21 21">
              <polyline points="5 10.75 8.5 14.25 16 6"></polyline>
            </svg>
          </span>
          {{$subItem->name}}
          @isset($subItem->products_count)
          <span class="position-absolute right">{{$subItem->products_count}}</span>
          @endisset
        </label>
      @endforeach
    </div>
  </div>
</div>
