<x-www-layout>
    <main>
        @if(isset($actions['view']['main']))
            @if(is_array($actions['view']['main']))
                @foreach ($actions['view']['main'] as $section)
                <section>
                    @includeIf($section)
                </section>
                @endforeach
            @else
                @includeIf($actions['view']['main'])
            @endif
        @else
        <div class="alert alert-danger" role="alert">
            컨트롤러에서 출력할 main 화면이 지정되어 있지 않습니다.
        </div>
        @endif
    </main>
</x-www-layout>
