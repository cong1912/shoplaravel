<nav id="my-menu" class="d-block d-md-none">
  <ul title="{{__('client.allCategories')}}">
    @foreach($array as $item)
      <li>
        <span><i class="las {{$item->icon}}"></i>{{ $item->name }}</span>
        @if (count($item->children) > 0)
          <ul>
            @foreach($item->children as $subItem)
              <li>
                <a href="/category/{{ $subItem->url }}">{{ $subItem->name }} ({{$subItem->products_count}})</a>
              </li>
            @endforeach
          </ul>
        @endif
      </li>
    @endforeach
  </ul>
</nav>
