<div class="dropdown d-none d-md-block nav">

    <a class="nav-link dropdown-toggle py-1 px-0"
        href="javascript:void(0);"
        data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false"
        aria-label="Country select: USA">

        <div class="ratio ratio-1x1" style="width: 20px">
            <img src="{{$rows[$country]['image']}}" alt="{{$rows[$country]['name']}}">
        </div>
    </a>

    <ul class="dropdown-menu fs-sm" style="--cz-dropdown-spacer: .5rem">
        @foreach($rows as $item)
        <li>
        <a class="dropdown-item"
            href="javascript:void(0);"
            wire:click="choose('{{$item['code']}}')">
            <img src="{{$item['image']}}"
                class="flex-shrink-0 me-2" width="20"
                alt="{{$item['name']}}">
            {{$item['name']}}
        </a>
        </li>
        @endforeach
    </ul>
</div>
