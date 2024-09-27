<div>
    @if($country && count($rows) > 0)
    <div class="dropdown d-none d-md-block nav">
        <a class="nav-link animate-underline dropdown-toggle fw-normal py-1 px-0"
            href="javascript:void(0);"
            data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
          <span class="animate-target">{{$rows[$location]['name']}}</span>
        </a>
        <ul class="dropdown-menu fs-sm" style="--cz-dropdown-spacer: .5rem">
            @foreach($rows as $item)
            <li>
                <a class="dropdown-item"
                href="javascript:void(0);"
                wire:click="choose('{{$item['id']}}')">{{$item['name']}}</a>
            </li>
            @endforeach
          {{-- <li><a class="dropdown-item" href="#!">Los Angeles</a></li>
          <li><a class="dropdown-item" href="#!">New York</a></li>
          <li><a class="dropdown-item" href="#!">Philadelphia</a></li> --}}
        </ul>
    </div>
    @endif
</div>
