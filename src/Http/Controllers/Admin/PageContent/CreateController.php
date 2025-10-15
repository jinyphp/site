<?php

namespace Jiny\Site\Http\Controllers\Admin\PageContent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jiny\Site\Models\SitePage;

class CreateController extends Controller
{
    /**
     * 새로운 콘텐츠 블럭 생성 폼 표시
     */
    public function __invoke(Request $request, $pageId)
    {
        $page = SitePage::findOrFail($pageId);

        // 사용 가능한 블럭 타입 목록
        $blockTypes = $this->getAvailableBlockTypes();

        // 기본값 설정
        $content = (object) [
            'id' => null,
            'page_id' => $pageId,
            'block_type' => 'text',
            'title' => '',
            'content' => '',
            'css_class' => '',
            'settings' => [],
            'sort_order' => $this->getNextSortOrder($pageId),
            'is_active' => true,
            'hide_title' => false,
        ];

        return view('jiny-site::admin.page-content.create', compact('page', 'content', 'blockTypes'));
    }

    private function getAvailableBlockTypes()
    {
        return [
            'text' => [
                'name' => '텍스트',
                'icon' => 'fe fe-type',
                'description' => '일반 텍스트 블럭'
            ],
            'html' => [
                'name' => 'HTML',
                'icon' => 'fe fe-code',
                'description' => 'HTML 코드 블럭'
            ],
            'markdown' => [
                'name' => '마크다운',
                'icon' => 'fe fe-edit-3',
                'description' => '마크다운 형식 블럭'
            ],
            'blade' => [
                'name' => 'Blade 템플릿',
                'icon' => 'fe fe-file-text',
                'description' => 'Laravel Blade 템플릿 블럭'
            ],
            'image' => [
                'name' => '이미지',
                'icon' => 'fe fe-image',
                'description' => '이미지 블럭'
            ],
            'video' => [
                'name' => '비디오',
                'icon' => 'fe fe-video',
                'description' => '비디오 블럭'
            ],
            'code' => [
                'name' => '코드',
                'icon' => 'fe fe-code',
                'description' => '코드 하이라이트 블럭'
            ],
            'divider' => [
                'name' => '구분선',
                'icon' => 'fe fe-minus',
                'description' => '구분선 블럭'
            ],
            'button' => [
                'name' => '버튼',
                'icon' => 'fe fe-square',
                'description' => '버튼 링크 블럭'
            ],
            'alert' => [
                'name' => '알림박스',
                'icon' => 'fe fe-info',
                'description' => '알림 메시지 블럭'
            ]
        ];
    }

    private function getNextSortOrder($pageId)
    {
        return \Jiny\Site\Models\SitePageContent::where('page_id', $pageId)
            ->max('sort_order') + 1;
    }
}