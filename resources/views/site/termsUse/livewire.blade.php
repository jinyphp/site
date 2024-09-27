<div>
    {{-- 회원약관 사용자 뷰 --}}
    <div class="row">
        <div class="col-2">
            @includeIf("jiny-site::site.termsUse.list")

        </div>
        <div class="col-10">
            @if($term)
                @if($design)
                    @includeIf("jiny-site::site.termsUse.edit")
                @else
                    @includeIf("jiny-site::site.termsUse.condition")
                @endif
            @else
                {{-- slug 가 선택되어 있지 않음, terms == null --}}
                @foreach($terms as $item)
                <div class="d-flex justify-content-between">
                    <h2 class="h4">
                        <a href="/terms/{{$item['slug']}}"
                            style="text-decoration: none; color: #333;">
                            {{$item['title']}}
                        </a>
                    </h2>
                    <div>

                        <button class="btn btn-info" wire:click="agree('{{$item['id']}}')">
                            약관 동의
                        </button>

                    </div>
                </div>
                @endforeach

            @endif
        </div>
    </div>

    <!-- 위젯 팝업 -->
    @if ($popupForm)
        @includeIf("jiny-wire-table::table_popup_forms.popup_forms")
    @endif
</div>
