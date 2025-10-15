<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Layout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $layouts = $this->getLayoutsFromJson();

        return view('jiny-site::admin.templates.layout.index', [
            'layouts' => $layouts
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