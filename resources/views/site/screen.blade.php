<div>
    <x-form-text-clear
    placeholder="화면번호"
    aria-label="화면번호"
    wire:model="search" wire:keydown.enter="pageSearch" required=""/>


    @if ($popup)
    <x-wire-dialog-modal wire:model="popup" maxWidth="3xl">
        <x-slot name="title">
            <x-flex-between>
                <div>
                    {{ __('페이지 검색') }}
                </div>
                <div>
                    <span class="text-muted" wire:click="cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                          </svg>
                    </span>
                </div>
            </x-flex-between>
        </x-slot>

        <x-slot name="content">
            @foreach ($rows as $row)
            <div class="mb-2 border-bottom pb-2" wire:click="move('{{ $row['uri'] }}')">
                {{ $row['code'] }} : {{ $row['title'] }}
                <p class="text-muted">{{ $row['description'] }}</p>
            </div>
            @endforeach
        </x-slot>

        @if(isAdmin())
        <x-slot name="footer">
            <a href="{{prefix('admin')}}/site/screen"
            class="btn btn-primary btn-sm">
                화면관리
            </a>
        </x-slot>
        @endif
    </x-wire-dialog-modal>
    @endif
</div>
