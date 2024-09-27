<x-www-app>
    <x-www-layout>
        <div class="container">
            {{-- 페이지 삽입된 widgets 을 loop로 출력합니다. --}}
            {{-- @includeIf('jiny-site-page::design.widgetLoop') --}}
            @livewire('site-widget-loop')

            {{-- @includeIf('jiny-site-page::design.script') --}}

            {{-- 드레그 하여 element 요소를 삽입합니다. --}}
            @includeIf('jiny-site-page::design.dropzone')

            {{-- Admin Rule Setting --}}
            {{-- @include('jiny-site-page::setMarkRule') --}}

            {{-- @livewire('site-design-widgets') --}}
        </div>
    </x-www-layout>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('page-realod', (event) => {
                console.log("page-realod");
                location.reload();
            });
        });
    </script>
</x-www-app>
