<x-theme theme="admin.sidebar">
    {{-- 설정 파일을 생성할 수 있는 출력 템플릿 --}}
    <x-theme-layout>

        @includeIf("jiny-wire-table::layouts.title")

        <div class="card">
            <div class="card-body">
                @livewire('site-slot-setting',[
                    'actions'=>$actions])
            </div>
        </div>

        {{-- SuperAdmin Actions Setting --}}
        {{--
        @if(Module::has('Actions'))
            @livewire('setActionRule', ['actions'=>$actions])
        @endif
        --}}
    </x-theme-layout>
</x-theme>
