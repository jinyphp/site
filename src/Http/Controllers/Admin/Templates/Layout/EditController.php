<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Layout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EditController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $layouts = $this->getLayoutsFromJson();

        // 순차배열에서 인덱스 체크 (0부터 시작하므로 -1)
        $index = $id - 1;

        if (!isset($layouts[$index]) || $index < 0) {
            abort(404, 'Layout not found');
        }

        $layout = $layouts[$index];
        $layout['id'] = $id;

        return view('jiny-site::admin.templates.layout.edit', [
            'layout' => $layout
        ]);
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
}