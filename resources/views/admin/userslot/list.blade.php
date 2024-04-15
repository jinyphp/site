<div>
    @push('css')
    <style>
        .row-selected {
            background-color: #fcf7c2;
        }

        table {
            width: 100%;
        }

        table th {
            padding: 12px 8px;
        }

        table tr {
            border-bottom: 1px solid #dddddd;
        }

        table tr:last-child {
            /*border-bottom: none;*/ /* 마지막 tr에 대한 밑줄을 없애는 스타일 */
        }

        table td {
            padding: 12px 8px;
        }
    </style>
    @endpush

    <table>
        <thead>
            <tr>
                <th width="200">사용자</th>
                <th width="200">code</th>
                <th></th>
                <th width="30">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $key => $item)
            <tr>
                <td width="200">

                    {{ user($key)->email }}
                </td>
                <td width="200">
                    <x-click wire:click="edit('{{$key}}')">
                        {{$item}}
                    </x-click>
                </td>
                <td>

                </td>
                <td width="30">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grip-vertical" viewBox="0 0 16 16">
                        <path d="M7 2a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M7 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M7 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-3 3a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-3 3a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                    </svg>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>




    <!-- 팝업 데이터 수정창 -->
    @if ($popupForm)
    <x-wire-dialog-modal wire:model="popupForm" maxWidth="3xl">
        <x-slot name="title">
            @if ($edit_id)
            {{ __('수정') }}
            @else
            {{ __('신규 입력') }}
            @endif
        </x-slot>

        <x-slot name="content">
            @includeIf($actions['view']['form'])
        </x-slot>


        <x-slot name="footer">
            @if ($edit_id)
            {{-- 수정폼--}}
            <x-flex-between>
                <div> {{-- 2단계 삭제 --}}
                    @if($popupDelete)
                    <span class="text-red-600">정말로 삭제를 진행할까요?</span>
                    <button type="button" class="btn btn-danger" wire:click="deleteConfirm">삭제</button>
                    @else
                    <button type="button" class="btn btn-warning" wire:click="delete">삭제</button>
                    @endif
                </div>
                <div> {{-- right --}}
                    <button type="button" class="btn btn-secondary"
                        wire:click="cancel">취소</button>
                    <button type="button" class="btn btn-info"
                        wire:click="update">수정</button>
                </div>
            </x-flex-between>

            @else
            {{-- 생성폼 --}}
            <div class="flex justify-between">
                <div></div>
                <div class="text-right">
                    <button type="button" class="btn btn-secondary"
                        wire:click="cancel">취소</button>
                    <button type="button" class="btn btn-primary"
                        wire:click="store">저장</button>
                </div>
            </div>
            @endif
        </x-slot>
    </x-wire-dialog-modal>
    @endif

</div>
