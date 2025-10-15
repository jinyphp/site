<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Sidebar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DestroyController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $sidebars = $this->getSidebarsFromJson();

        // 순차배열에서 인덱스 체크 (0부터 시작하므로 -1)
        $index = $id - 1;

        if (!isset($sidebars[$index]) || $index < 0) {
            abort(404, 'Sidebar not found');
        }

        $this->removeFromSidebarsJson($index);

        return redirect()->route('admin.cms.templates.sidebar.index')
            ->with('success', '사이드바가 성공적으로 삭제되었습니다.');
    }

    private function getSidebarsFromJson()
    {
        $jsonPath = __DIR__ . '/../../../../../../config/sidebar.json';

        if (!File::exists($jsonPath)) {
            return [];
        }

        $json = File::get($jsonPath);
        return json_decode($json, true) ?? [];
    }

    private function removeFromSidebarsJson($index)
    {
        $jsonPath = __DIR__ . '/../../../../../../config/sidebar.json';
        $sidebars = $this->getSidebarsFromJson();

        // 순차배열에서 요소 제거 후 재정렬
        array_splice($sidebars, $index, 1);

        $json = json_encode($sidebars, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($jsonPath, $json);
    }
}
