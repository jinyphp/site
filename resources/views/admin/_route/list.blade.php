<table class="table table-striped table-centered mb-0">
    <thead>
        <tr>
            @if(count($rows))
            <th width='20'>
                <input type='checkbox' class="form-check-input" wire:model="selectedall">
            </th>
            @endif
            <th width='50'>Id</th>
            <th>
                <div class="d-flex">
                    <span class="me-2">
                        {!! xWireLink('Route', "orderBy('route')") !!}
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371zm1.57-.785L11 2.687h-.047l-.652 2.157z"/>
                        <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293z"/>
                    </svg>
                </div>
            </th>
            <th>
                <div class="d-flex">
                    <span class="me-2">
                        type
                    </span>
                </div>
            </th>
            <th width='100'>
                <div class="d-flex">
                    <span class="me-2">
                        조회수
                    </span>
                </div>
            </th>
            <th width='180'>
                <div class="d-flex">
                    <span class="me-2">
                        생성일자
                    </span>
                </div>
            </th>
            <th width='30'>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </th>
        </tr>
    </thead>
    @if(!empty($rows))
    <tbody>
        @foreach ($rows as $item)
            {{-- row-selected --}}
            @if(in_array($item->id, $selected))
            <tr class="row-selected">
            @else
            <tr>
            @endif

            <td width='20'>
                <input type='checkbox' name='ids' value="{{$item->id}}"
                class="form-check-input"
                wire:model="selected">
            </td>

            <td width='50'>{{$item->id}}</td>

            <td >
                {!! $popupEdit($item, $item->route) !!}

                <a href="{{$item->route}}" class="px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                {{$item->title}}
            </td>
            <td>
                {{$type = parserValue($item->type)}}
                @if($type=="포스트")
                / {{$item->post}}
                @endif
            </td>
            <td width='180'>{{$item->cnt}}</td>
            <td width='180'>{{$item->created_at}}</td>
            <td width='30'>

            </td>
        @endforeach

    </tbody>
    @endif
</table>

@if(count($rows)==0)
<div class="alert alert-secondary mt-4">
    등록된 데이터가 없습니다.
</div>
@endif


