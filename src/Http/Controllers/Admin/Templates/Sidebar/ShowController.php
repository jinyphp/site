<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Sidebar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ShowController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $sidebars = $this->getSidebarsFromJson();

        // 순차배열에서 인덱스 체크 (0부터 시작하므로 -1)
        $index = $id - 1;

        if (!isset($sidebars[$index]) || $index < 0) {
            abort(404, 'Sidebar not found');
        }

        $sidebar = $sidebars[$index];
        $sidebar['id'] = $id; // ID 추가

        return view('jiny-site::admin.templates.sidebar.show', compact('sidebar'));
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
