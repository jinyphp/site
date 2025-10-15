<div>
    <div class="d-flex justify-content-center align-items-center gap-2">
        <a class="btn btn-primary" href="/">Home</a>

        <x-click class="btn btn-secondary" wire:click="create()">
            페이지 추가
        </x-click>
    </div>

    <!-- 팝업 데이터 수정창 -->
    @if ($popupForm)
    <x-wire-dialog-modal wire:model="popupForm" :maxWidth="$popupWindowWidth">
        <x-slot name="title">
            {{ __('현재 url을 기반으로 새로운 페이지를 생성합니다.') }}
        </x-slot>

        <x-slot name="content">

            <div class="flex gap-4">
                <button class="btn btn-primary flex items-center gap-2" wire:click="board()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3 1h10v8H5V6zm1 3h8v1H6V9zm0 2h8v1H6v-1z" clip-rule="evenodd" />
                    </svg>
                    게시판
                </button>

                @if(function_exists('is_markdown_installed'))
                <button class="btn btn-primary flex items-center gap-2" wire:click="markdown()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-markdown-fill" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm11.5 1a.5.5 0 0 0-.5.5v3.793L9.854 8.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L12 9.293V5.5a.5.5 0 0 0-.5-.5M3.56 7.01h.056l1.428 3.239h.774l1.42-3.24h.056V11h1.073V5.001h-1.2l-1.71 3.894h-.039l-1.71-3.894H2.5V11h1.06z"/>
                    </svg>
                    마크다운
                </button>
                @endif

                <button class="btn btn-primary flex items-center gap-2" wire:click="html()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-code" viewBox="0 0 16 16">
                        <path d="M5.854 4.854a.5.5 0 1 0-.708-.708l-3.5 3.5a.5.5 0 0 0 0 .708l3.5 3.5a.5.5 0 0 0 .708-.708L2.707 8zm4.292 0a.5.5 0 0 1 .708-.708l3.5 3.5a.5.5 0 0 1 0 .708l-3.5 3.5a.5.5 0 0 1-.708-.708L13.293 8z"/>
                    </svg>
                    HTML
                </button>

                <button class="btn btn-primary flex items-center gap-2" wire:click="blade()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-braces" viewBox="0 0 16 16">
                        <path d="M2.114 8.063V7.9c1.005-.102 1.497-.615 1.497-1.6V4.503c0-1.094.39-1.538 1.354-1.538h.273V2h-.376C3.25 2 2.49 2.759 2.49 4.352v1.524c0 1.094-.376 1.456-1.49 1.456v1.299c1.114 0 1.49.362 1.49 1.456v1.524c0 1.593.759 2.352 2.372 2.352h.376v-.964h-.273c-.964 0-1.354-.444-1.354-1.538V9.663c0-.984-.492-1.497-1.497-1.6M13.886 7.9v.163c-1.005.103-1.497.616-1.497 1.6v1.798c0 1.094-.39 1.538-1.354 1.538h-.273v.964h.376c1.613 0 2.372-.759 2.372-2.352v-1.524c0-1.094.376-1.456 1.49-1.456V7.332c-1.114 0-1.49-.362-1.49-1.456V4.352C13.51 2.759 12.75 2 11.138 2h-.376v.964h.273c.964 0 1.354.444 1.354 1.538V6.3c0 .984.492 1.497 1.497 1.6"/>
                    </svg>
                    Blade
                </button>

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
