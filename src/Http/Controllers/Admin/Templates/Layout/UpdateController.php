<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Layout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $layouts = $this->getLayoutsFromJson();

        // 순차배열에서 인덱스 체크 (0부터 시작하므로 -1)
        $index = $id - 1;

        if (!isset($layouts[$index]) || $index < 0) {
            abort(404, 'Layout not found');
        }

        $request->validate([
            'layout_key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'header' => 'nullable|string|max:255',
            'footer' => 'nullable|string|max:255',
            'sidebar' => 'nullable|string|max:255',
        ]);

        $layoutData = [
            'layout_key' => $request->input('layout_key'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'header' => $request->input('header'),
            'footer' => $request->input('footer'),
            'sidebar' => $request->input('sidebar'),
        ];

        $this->updateLayoutsJson($index, $layoutData);

        return redirect()->route('admin.cms.templates.layout.index')
            ->with('success', '레이아웃이 성공적으로 업데이트되었습니다.');
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

    private function updateLayoutsJson($index, $data)
    {
        $jsonPath = __DIR__ . '/../../../../../../config/layouts.json';
        $layouts = $this->getLayoutsFromJson();

        $layouts[$index] = $data;

        $json = json_encode($layouts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($jsonPath, $json);
    }
}