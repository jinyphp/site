<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Sidebar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'sidebar_key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $sidebars = $this->getSidebarsFromJson();

        // 순차배열에서 인덱스 체크 (0부터 시작하므로 -1)
        $index = $id - 1;

        if (!isset($sidebars[$index]) || $index < 0) {
            abort(404, 'Sidebar not found');
        }

        // 중복 키 체크 (자기 자신 제외)
        if ($this->isDuplicateKey($request->sidebar_key, $index)) {
            return back()->withErrors(['sidebar_key' => '이미 존재하는 사이드바 키입니다.'])->withInput();
        }

        $this->updateSidebarsJson($index, $request->all());

        return redirect()->route('admin.cms.templates.sidebar.index')
            ->with('success', '사이드바가 성공적으로 수정되었습니다.');
    }

    private function isDuplicateKey($key, $excludeIndex)
    {
        $sidebars = $this->getSidebarsFromJson();

        foreach ($sidebars as $index => $sidebar) {
            if ($index !== $excludeIndex && $sidebar['sidebar_key'] === $key) {
                return true;
            }
        }

        return false;
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

    private function updateSidebarsJson($index, $data)
    {
        $jsonPath = __DIR__ . '/../../../../../../config/sidebar.json';
        $sidebars = $this->getSidebarsFromJson();

        // 사이드바 데이터 업데이트
        $sidebars[$index] = [
            'sidebar_key' => $data['sidebar_key'],
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'template' => $data['template'] ?? '',
            'position' => $data['position'] ?? '',
            'collapsible' => isset($data['collapsible']),
            'fixed' => isset($data['fixed']),
        ];

        $json = json_encode($sidebars, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($jsonPath, $json);
    }
}
