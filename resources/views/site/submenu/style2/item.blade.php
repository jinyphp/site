<div class="dropend">
    <a class="list-group-item list-group-item-action justify-content-between dropdown-toggle text-wrap pe-3"
        @if(isset($item['href']))
        href="{{$item['href']}}"
        @else
        href="javascript:void(0);"
        @endif
    >

        {{$item['title']}}

        {{-- <x-click wire:click="edit('{{$ref}}-{{$i}}')">
            {{$item['title']}}
        </x-click> --}}

        {{--  --}}

        @if(isset($item['description']))
        <span class="visually-hidden">
            {{$item['description']}}
        </span>
        @endif
    </a>

    {{-- <ul style="list-style-type: none; border-left:1px solid;">
        @if(isset($item['items']))
            @includeIf("jiny-site::admin.menu_item.node",[
                'ref' => $ref."-".$i,
                'rows' => $item['items']
            ])
        @endif

        <li class="p-1">
            <x-click wire:click="create('{{$ref}}-{{$i}}')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-node-plus" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8M6.025 7.5a5 5 0 1 1 0 1H4A1.5 1.5 0 0 1 2.5 10h-1A1.5 1.5 0 0 1 0 8.5v-1A1.5 1.5 0 0 1 1.5 6h1A1.5 1.5 0 0 1 4 7.5zM11 5a.5.5 0 0 1 .5.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2A.5.5 0 0 1 11 5M1.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                </svg>
            </x-click>
        </li>

    </ul> --}}

</div>
