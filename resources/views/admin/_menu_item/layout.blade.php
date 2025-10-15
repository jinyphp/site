<x-theme name="admin.sidebar">
    <x-theme-layout>

        <x-flex-between>
            <div class="page-title-box">
                <x-flex class="align-items-center gap-2">
                    <h1 class="align-middle h3 d-inline">
                        @if (isset($actions['title']))
                        {{$actions['title']}}
                        @endif
                    </h1>
                    {{-- <x-badge-info>Admin</x-badge-info> --}}
                </x-flex>
                <p>
                    @if (isset($actions['subtitle']))
                        {{$actions['subtitle']}}
                    @endif
                </p>
            </div>

            <div class="page-title-box">
                <x-breadcrumb-item>
                    {{$actions['route']['uri']}}
                </x-breadcrumb-item>

                <div class="d-flex justify-content-end gap-2">
                    <x-btn-video>
                        Video
                    </x-btn-video>

                    <x-btn-manual>
                        Manual
                    </x-btn-manual>
                </div>
            </div>

        </x-flex-between>

        <div class="row mt-2">
            <div class="col-2">
                <div class="card">
                    @livewire('site-menu-code')
                </div>
            </div>
            <div class="col-10">
                @livewire('site-menu-item')
            </div>
        </div>




    </x-theme-layout>
</x-theme>

