<x-wire-table>
    {{-- 테이블 제목 --}}
    <x-wire-thead>
        <th width='200'>
            {!! xWireLink('tag', "orderBy('tag')") !!}
        </th>
        <th width='200'>이름</th>
        <th>경로/설명</th>
        <th width='200'>생성일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            {{-- 테이블 리스트 --}}
            <x-wire-tbody-item :selected="$selected" :item="$item">
                <td width='200'>
                    {{$item->tag}}
                </td>
                <td width='200'>
                    <x-click wire:click="edit({{$item->id}})">
                        {{$item->name}}
                    </x-click>

                </td>
                <td>
                    <div>{{$item->path}}</div>
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
