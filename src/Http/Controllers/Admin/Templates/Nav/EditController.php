<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Nav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EditController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $navs = $this->getNavsFromJson();

        // 순차배열에서 인덱스 체크 (0부터 시작하므로 -1)
        $index = $id - 1;

        if (!isset($navs[$index]) || $index < 0) {
            abort(404, 'Nav not found');
        }

        $nav = $navs[$index];
        $nav['id'] = $id; // ID 추가

        return view('jiny-site::admin.templates.nav.edit', compact('nav'));
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
