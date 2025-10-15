<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Sidebar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'sidebar_key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        // 중복 키 체크
        if ($this->isDuplicateKey($request->sidebar_key)) {
            return back()->withErrors(['sidebar_key' => '이미 존재하는 사이드바 키입니다.'])->withInput();
        }

        $this->addToSidebarsJson($request->all());

        return redirect()->route('admin.cms.templates.sidebar.index')
            ->with('success', '사이드바가 성공적으로 생성되었습니다.');
    }

    private function isDuplicateKey($key)
    {
        $sidebars = $this->getSidebarsFromJson();

        foreach ($sidebars as $sidebar) {
            if ($sidebar['sidebar_key'] === $key) {
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

    private function addToSidebarsJson($data)
    {
        $jsonPath = __DIR__ . '/../../../../../../config/sidebar.json';
        $sidebars = $this->getSidebarsFromJson();

        // 새 사이드바 데이터 준비
        $newSidebar = [
            'sidebar_key' => $data['sidebar_key'],
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'template' => $data['template'] ?? '',
            'position' => $data['position'] ?? '',
            'collapsible' => isset($data['collapsible']),
            'fixed' => isset($data['fixed']),
        ];

        $sidebars[] = $newSidebar;

        $json = json_encode($sidebars, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($jsonPath, $json);
    }
}
