@setTheme("admin.sidebar")
<x-theme theme="admin.sidebar">
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

                <div class="mt-2 d-flex justify-content-end gap-2">
                    <x-btn-video>
                        Video
                    </x-btn-video>

                    <x-btn-manual>
                        Manual
                    </x-btn-manual>
                </div>
            </div>

        </x-flex-between>

        <!-- dash info -->
        @includeIf('jiny-site::admin.dashboard.users', [])

        <x-ui-divider>사이트 컨덴츠 관리</x-ui-divider>

        @includeIf('jiny-site::admin.dashboard.cms', [])


        <x-ui-divider>사이트 관리</x-ui-divider>

        @includeIf('jiny-site::admin.dashboard.site', [])

        <x-ui-divider>사이트 설정</x-ui-divider>

        @includeIf('jiny-site::admin.dashboard.setting', [])

    </x-theme-layout>
</x-theme>

