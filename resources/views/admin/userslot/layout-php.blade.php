<x-theme theme="admin.sidebar">
    {{-- 설정 파일을 생성할 수 있는 출력 템플릿 --}}
    <x-theme-layout>

        @includeIf("jiny-wire-table::layouts.title")

        <div class="card">
            <div class="card-body">
                <x-flex-between>
                    <div>
                        <h4 class="header-title">
                            @if(isset($actions['title']))
                            {{$actions['title']}}
                            @endif
                        </h4>
                        <p class="text-muted font-14">
                            @if(isset($actions['subtitle']))
                            {{$actions['subtitle']}}
                            @endif

                        </p>
                    </div>
                    <div>
                        @if(isset($actions['create']) && $actions['create'])
                            @livewire('ButtonPopupCreate',['title' => "추가"])
                        @endif
                    </div>
                </x-flex-between>

                @livewire('site-userslot-setting',[
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
