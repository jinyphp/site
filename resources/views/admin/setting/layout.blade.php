<x-theme theme="admin.sidebar">
    {{-- 설정 파일을 생성할 수 있는 출력 템플릿 --}}
    <x-theme-layout>

        <div class="d-flex justify-content-between my-2">
            <div class="">
                <h3>
                @if(isset($actions['title']))
                    {{$actions['title']}}
                @endif
                </h3>
                <div class="lead text-center" style="font-size: 1rem;">
                @if(isset($actions['subtitle']))
                    {{$actions['subtitle']}}
                @endif
                </div>
            </div>

            <div class="flex justify-content-end align-items-top">

                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Admin</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="/admin/site">Site</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Dashbaord
                    </li>
                </ol>

            </div>
        </div>


        @livewire('WireConfigPHP', ['actions'=>$actions])

        {{-- SuperAdmin Actions Setting --}}
        {{-- @if(Module::has('Actions'))
            @livewire('setActionRule', ['actions'=>$actions])
        @endif --}}

    </x-theme-layout>
</x-theme>
