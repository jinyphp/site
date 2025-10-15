<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Layout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StoreController extends Controller
{
    public function __invoke(Request $request)
    {
        $layouts = $this->getLayoutsFromJson();

        $request->validate([
            'layout_key' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($layouts) {
                    // 순차배열에서 layout_key 중복 체크
                    foreach ($layouts as $layout) {
                        if (isset($layout['layout_key']) && $layout['layout_key'] === $value) {
                            $fail('The layout key already exists.');
                            break;
                        }
                    }
                }
            ],
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'header' => 'nullable|string|max:255',
            'footer' => 'nullable|string|max:255',
            'sidebar' => 'nullable|string|max:255',
        ]);

        $layoutData = [
            'layout_key' => $request->input('layout_key'),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'header' => $request->input('header'),
            'footer' => $request->input('footer'),
            'sidebar' => $request->input('sidebar'),
        ];

        $this->addToLayoutsJson($layoutData);

        return redirect()->route('admin.cms.templates.layout.index')
            ->with('success', 'Layout created successfully.');
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

    private function addToLayoutsJson($data)
    {
        $jsonPath = __DIR__ . '/../../../../../../config/layouts.json';
        $layouts = $this->getLayoutsFromJson();

        // 순차배열에 새로운 레이아웃 추가
        $layouts[] = $data;

        $json = json_encode($layouts, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        File::put($jsonPath, $json);
    }
}