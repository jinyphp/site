<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Nav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DestroyController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $navs = $this->getNavsFromJson();

        // 순차배열에서 인덱스 체크 (0부터 시작하므로 -1)
        $index = $id - 1;

        if (!isset($navs[$index]) || $index < 0) {
            abort(404, 'Nav not found');
        }

        $this->removeFromNavsJson($index);

        return redirect()->route('admin.cms.templates.nav.index')
            ->with('success', '네비게이션이 성공적으로 삭제되었습니다.');
    }

    private function getNavsFromJson()
    {
        $jsonPath = __DIR__ . '/../../../../../../config/navs.json';

        if (!File::exists($jsonPath)) {
            return [];
        }

        $json = File::get($jsonPath);
        return json_decode($json, true) ?? [];
    }

    private function removeFromNavsJson($index)
    {
        $jsonPath = __DIR__ . '/../../../../../../config/navs.json';
        $navs = $this->getNavsFromJson();

        // 순차배열에서 요소 제거 후 재정렬
        array_splice($navs, $index, 1);

        $json = json_encode($navs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($jsonPath, $json);
    }
}
