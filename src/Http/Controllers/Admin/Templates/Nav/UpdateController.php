<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Nav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'nav_key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        $navs = $this->getNavsFromJson();

        // 순차배열에서 인덱스 체크 (0부터 시작하므로 -1)
        $index = $id - 1;

        if (!isset($navs[$index]) || $index < 0) {
            abort(404, 'Nav not found');
        }

        // 중복 키 체크 (자기 자신 제외)
        if ($this->isDuplicateKey($request->nav_key, $index)) {
            return back()->withErrors(['nav_key' => '이미 존재하는 네비게이션 키입니다.'])->withInput();
        }

        $this->updateNavsJson($index, $request->all());

        return redirect()->route('admin.cms.templates.nav.index')
            ->with('success', '네비게이션이 성공적으로 수정되었습니다.');
    }

    private function isDuplicateKey($key, $excludeIndex)
    {
        $navs = $this->getNavsFromJson();

        foreach ($navs as $index => $nav) {
            if ($index !== $excludeIndex && $nav['nav_key'] === $key) {
                return true;
            }
        }

        return false;
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

    private function updateNavsJson($index, $data)
    {
        $jsonPath = __DIR__ . '/../../../../../../config/navs.json';
        $navs = $this->getNavsFromJson();

        // 네비게이션 데이터 업데이트
        $navs[$index] = [
            'nav_key' => $data['nav_key'],
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'template' => $data['template'] ?? '',
            'type' => $data['type'] ?? '',
            'dropdown' => isset($data['dropdown']),
            'mobile_responsive' => isset($data['mobile_responsive']),
        ];

        $json = json_encode($navs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($jsonPath, $json);
    }
}
