<x-wire-table>
    {{-- 테이블 제목 --}}
    <x-wire-thead>
        <th width='50'>Id</th>
        <th width='200'> {!! xWireLink('language', "orderBy('lang')") !!}</th>
        <th>이름</th>
        <th width='200'>생성일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            {{-- 테이블 리스트 --}}
            <x-wire-tbody-item :selected="$selected" :item="$item">
                <td width='50'>{{$item->id}}</td>
                <td width='200'>
                    <x-click wire:click="edit({{$item->id}})">
                        {{$item->lang}}
                    </x-click>
                </td>

                <td>
                    <x-click wire:click="edit({{$item->id}})">
                        {{$item->name}}
                    </x-click>
                    <div>{{$item->description}}</div>
                </td>

                <td width='200'>
                    <div>{{$item->created_at}}</div>
                </td>

            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table>
