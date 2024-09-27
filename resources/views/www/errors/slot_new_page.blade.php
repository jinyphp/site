<div>
    <x-flex-center class="gap-2">
        <a class="btn btn-primary" href="/">Home</a>

        <x-click class="btn btn-secondary" wire:click="create()">
            페이지 추가
        </x-click>
    </x-flex-center>

    <!-- 팝업 데이터 수정창 -->
    @if ($popupForm)
    <x-wire-dialog-modal wire:model="popupForm" :maxWidth="$popupWindowWidth">
        <x-slot name="title">
            {{ __('현재 url을 기반으로 새로운 페이지를 생성합니다.') }}
        </x-slot>

        <x-slot name="content">

            <div class="d-flex">
                <button class="btn btn-primary" wire:click="board()">계시판</button>
            </div>

            <p>기존에 있는 파일을 드레그 하여 업로드 및 페이지를 구성할 수 있습니다.</p>

        </x-slot>


        <x-slot name="footer">
            <div class="flex justify-between">
                <div>
                    <button type="button" class="btn btn-secondary"
                        wire:click="cancel">취소</button>
                </div>
                <div class="text-right">

                    <button type="button" class="btn btn-primary"
                        wire:click="make">생성</button>
                </div>
            </div>
        </x-slot>
    </x-wire-dialog-modal>
    @endif
</div>
