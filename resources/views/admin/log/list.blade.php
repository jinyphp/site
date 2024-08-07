<x-wire-table>
    {{-- 테이블 제목 --}}
    <x-wire-thead>
        <th width='200'>Year</th>
        <th width='200'>Month</th>
        <th width='200'>Day</th>
        <th>uri</th>
        <th width='200'>방문수</th>
        <th width='200'>갱신일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            {{-- 테이블 리스트 --}}
            <x-wire-tbody-item :selected="$selected" :item="$item">

                <td width='200'>
                    {{$item->year}}
                </td>
                <td width='200'>
                    {{$item->month}}
                </td>
                <td width='200'>
                    {{$item->day}}
                </td>

                <td>
                    {{$item->uri}}
                </td>
                <td width='200'>{{$item->cnt}}</td>
                <td width='200'>{{$item->updated_at}}</td>
            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table>
