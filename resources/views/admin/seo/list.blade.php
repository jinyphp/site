<x-wire-table>
    {{-- 테이블 제목 --}}
    <x-wire-thead>

        <th>uri</th>

        <th width='200'>갱신일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            {{-- 테이블 리스트 --}}
            <x-wire-tbody-item :selected="$selected" :item="$item">



                <td>
                    <div>{{$item->uri}}</div>
                    <div>{{$item->title}}</div>

                </td>

                <td width='200'>{{$item->updated_at}}</td>
            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table>
