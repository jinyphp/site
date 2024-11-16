<div>

    <div class="row">
        <aside class="col-2">
            {{-- 약관 목록 --}}
            @includeIf("jiny-site::site.termsUse.list")

        </aside>
        <article class="col-10">
            @if($term)
                @if($design)
                    {{-- 약관 수정 --}}
                    @includeIf("jiny-site::site.termsUse.edit")
                @else
                    {{-- 약관 조회 --}}
                    @includeIf("jiny-site::site.termsUse.condition")
                @endif
            @else
                {{-- slug 가 선택되어 있지 않음, terms == null --}}

                <div class="mb-4">
                    <h2 class="h3 mb-3">사이트 이용약관</h2>
                    <p>
                        본 웹사이트는 사용자의 권리와 의무를 명확히 하고 원활한 서비스 제공을 위해 다음과 같은 이용약관을 제시하고 있습니다.
                        각 약관을 주의 깊게 읽어보시고 동의해 주시기 바랍니다.
                        약관에 동의하시면 본 웹사이트의 서비스를 이용하실 수 있습니다.
                    </p>
                </div>
                @foreach($terms as $item)
                <div class="d-flex gap-2">
                    <h2 class="h4">
                        <a href="/terms/{{$item['slug']}}"
                            style="text-decoration: none; color: #333;">
                            {{$item['title']}}
                        </a>
                    </h2>
                    <div>
                        {{--
                        <button class="btn btn-info btn-sm" wire:click="agree('{{$item['id']}}')">
                            약관 동의
                        </button>
                        --}}
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </article>

    <!-- 위젯 팝업 -->
    @if ($popupForm)
        @includeIf("jiny-wire-table::table_popup_forms.popup_forms")
    @endif
</div>
