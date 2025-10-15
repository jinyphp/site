<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Layout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DestroyController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $layouts = $this->getLayoutsFromJson();

        // 순차배열에서 인덱스 체크 (0부터 시작하므로 -1)
        $index = $id - 1;

        if (!isset($layouts[$index]) || $index < 0) {
            abort(404, 'Layout not found');
        }

        $this->removeFromLayoutsJson($index);

        return redirect()->route('admin.cms.templates.layout.index')
            ->with('success', '레이아웃이 성공적으로 삭제되었습니다.');
    }

    private function getLayoutsFromJson()
    {
        $jsonPath = __DIR__ . '/../../../../../../config/layouts.json';

        if (!File::exists($jsonPath)) {
            return [];
        }

        $json = File::get($jsonPath);
        return json_decode($json, true) ?? [];
    }

    private function removeFromLayoutsJson($index)
    {
        $jsonPath = __DIR__ . '/../../../../../../config/layouts.json';
        $layouts = $this->getLayoutsFromJson();

        // 순차배열에서 요소 제거 후 재정렬
        array_splice($layouts, $index, 1);

        $json = json_encode($layouts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($jsonPath, $json);
    }
}