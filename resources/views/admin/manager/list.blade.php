<x-wire-table>
    {{-- 테이블 제목 --}}
    <x-wire-thead>
        <th width='200'>역할</th>
        <th width='200'>User</th>
        <th>이메일</th>
        <th width='200'>담당자</th>
        <th width='200'>등록일자</th>
    </x-wire-thead>
    <tbody>
        @if(!empty($rows))
            @foreach ($rows as $item)
            {{-- 테이블 리스트 --}}
            <x-wire-tbody-item :selected="$selected" :item="$item">

                <td width='200'>
                    {{$item->role}}
                </td>
                <td width='200'>
                    {{$item->user}} / {{$item->user_name}}
                </td>

                <td>
                    <div>
                        <x-click wire:click="edit({{$item->id}})">
                            {{$item->email}}
                        </x-click>
                    </div>
                    <p>{{$item->description}}</p>
                </td>
                <td width='200'>{{$item->manager}}</td>
                <td width='200'>{{$item->created_at}}</td>
            </x-wire-tbody-item>
            @endforeach
        @endif
    </tbody>
</x-wire-table>
