<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Nav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $navs = $this->getNavsFromJson();

        // 배열 인덱스를 ID로 변환 (1부터 시작)
        foreach ($navs as $index => &$nav) {
            $nav['id'] = $index + 1;
        }

        return view('jiny-site::admin.templates.nav.index', compact('navs'));
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
}
