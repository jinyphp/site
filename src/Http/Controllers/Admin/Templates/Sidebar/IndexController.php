<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Sidebar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $sidebars = $this->getSidebarsFromJson();

        // 배열 인덱스를 ID로 변환 (1부터 시작)
        foreach ($sidebars as $index => &$sidebar) {
            $sidebar['id'] = $index + 1;
        }

        return view('jiny-site::admin.templates.sidebar.index', compact('sidebars'));
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
}
