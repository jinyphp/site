<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Nav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'nav_key' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
        ]);

        // 중복 키 체크
        if ($this->isDuplicateKey($request->nav_key)) {
            return back()->withErrors(['nav_key' => '이미 존재하는 네비게이션 키입니다.'])->withInput();
        }

        $this->addToNavsJson($request->all());

        return redirect()->route('admin.cms.templates.nav.index')
            ->with('success', '네비게이션이 성공적으로 생성되었습니다.');
    }

    private function isDuplicateKey($key)
    {
        $navs = $this->getNavsFromJson();

        foreach ($navs as $nav) {
            if ($nav['nav_key'] === $key) {
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

    private function addToNavsJson($data)
    {
        $jsonPath = __DIR__ . '/../../../../../../config/navs.json';
        $navs = $this->getNavsFromJson();

        // 새 네비게이션 데이터 준비
        $newNav = [
            'nav_key' => $data['nav_key'],
            'name' => $data['name'],
            'description' => $data['description'] ?? '',
            'template' => $data['template'] ?? '',
            'type' => $data['type'] ?? '',
            'dropdown' => isset($data['dropdown']),
            'mobile_responsive' => isset($data['mobile_responsive']),
        ];

        $navs[] = $newNav;

        $json = json_encode($navs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($jsonPath, $json);
    }
}
