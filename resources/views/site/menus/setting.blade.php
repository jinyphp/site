<x-wire-dialog-modal wire:model="popupForm" :maxWidth="$popupWindowWidth">
    <x-slot name="title">
        {{ __('메뉴 위젯설정') }}
    </x-slot>

    <x-slot name="content">
        @includeIf("jiny-site::site.submenu.setting_form")
    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-between">
            <div>

            </div>
            <div class="text-right">
                <button type="button" class="btn btn-secondary"
                    wire:click="cancel">취소</button>
                <button type="button" class="btn btn-primary"
                    wire:click="widgetSave">적용</button>
            </div>
        </div>
    </x-slot>
</x-wire-dialog-modal>
