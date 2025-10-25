{{--
/**
 * Welcome Blocks Loop Template
 *
 * @description
 * Welcome.json에서 정의된 블록들을 순차적으로 렌더링하는 템플릿입니다.
 * 각 블록은 개별 뷰 템플릿을 포함하며, 설정값들이 전달됩니다.
 *
 * @variables
 * - $welcomeBlocks : array - Welcome.json에서 로드된 활성화된 블록 배열
 *
 * @block_structure
 * [
 *   {
 *     "id": 1,
 *     "name": "Block Name",
 *     "view": "jiny-site::www.blocks.template-name",
 *     "enabled": true,
 *     "order": 1,
 *     "config": { "title": "Block Title", "background": "#ffffff" }
 *   }
 * ]
 *
 * @passed_to_blocks
 * - $blockConfig : array - 블록별 설정값 (config 필드)
 * - $blockName   : string - 블록 이름
 * - $blockId     : int - 블록 ID
 *
 * @fallback
 * 블록이 없을 경우 기본 welcome 화면을 표시합니다.
 *
 * @file_location
 * /vendor/jiny/site/resources/views/www/welcome/loop.blade.php
 */
--}}

{{-- Welcome Blocks Section Container --}}
<div class="welcome-blocks">
    {{-- 블록이 설정되어 있는 경우 --}}
    @if(!empty($welcomeBlocks))
        {{-- Welcome.json에서 정의된 각 블록을 순차적으로 처리 --}}
        @foreach($welcomeBlocks as $block)
            {{--
                개별 블록 섹션
                - data-block-id: 블록 고유 ID
                - data-block-name: 블록 이름
                - style: config.background가 있으면 배경색 적용
            --}}
            <section class="welcome-block"
                        data-block-id="{{ $block['id'] }}"
                        data-block-name="{{ $block['name'] }}"
                        @if(isset($block['config']['background']))
                            style="background-color: {{ $block['config']['background'] }};"
                        @endif>

                {{-- 블록 래퍼 - 개별 블록 컨텐츠를 감싸는 컨테이너 --}}
                <div class="block-wrapper">
                    {{-- 지정된 뷰 템플릿이 존재하는지 확인 --}}
                    @if(view()->exists($block['view']))
                        {{--
                            블록 뷰 템플릿 포함
                            전달되는 변수들:
                            - blockConfig: 블록별 설정값 (JSON config 필드)
                            - blockName: 블록 이름
                            - blockId: 블록 ID
                        --}}
                        @include($block['view'], [
                            'blockConfig' => $block['config'] ?? [],
                            'blockName' => $block['name'],
                            'blockId' => $block['id']
                        ])
                    @else
                        {{-- 뷰 템플릿이 없을 경우 대체 화면 --}}
                        <div class="container py-5 text-center">
                            <div class="alert alert-warning">
                                <h5>{{ $block['name'] }}</h5>
                                <p class="mb-0">뷰 템플릿을 찾을 수 없습니다: <code>{{ $block['view'] }}</code></p>
                                {{-- 디버그 모드일 경우 추가 정보 표시 --}}
                                @if(config('app.debug'))
                                    <small class="text-muted d-block mt-2">
                                        블록 ID: {{ $block['id'] ?? 'N/A' }} |
                                        순서: {{ $block['order'] ?? 'N/A' }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        @endforeach
    @else
        {{-- 설정된 블록이 없을 경우 기본 Welcome 화면 표시 --}}
        <section class="default-welcome">
            <div class="container py-5 text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h1 class="display-4 fw-bold mb-4">Welcome to Our Site</h1>
                        <p class="lead mb-4">
                            This is the default welcome page. Configure welcome blocks in the admin panel to customize this page.
                        </p>
                        {{-- 관리자 패널로 이동하는 버튼들 --}}
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            <a href="/admin/cms/welcome" class="btn btn-primary btn-lg px-4 gap-3">
                                Configure Welcome Blocks
                            </a>
                            <a href="#" class="btn btn-outline-secondary btn-lg px-4">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>

{{--
/**
 * 사용 예시:
 *
 * 1. 블록 뷰 템플릿에서 설정값 사용
 * <h1>{{ $blockConfig['title'] ?? 'Default Title' }}</h1>
 * <p>{{ $blockConfig['description'] ?? '' }}</p>
 *
 * 2. 배경색 적용
 * "config": { "background": "#f8f9fa" }
 *
 * 3. 커스텀 설정값
 * "config": {
 *   "title": "Custom Title",
 *   "button_text": "Click Me",
 *   "button_url": "/contact"
 * }
 */
--}}
