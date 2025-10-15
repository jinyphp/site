<?php

namespace Jiny\Site\Api\Controllers\PageWidget;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * 페이지 위젯 드래그 API 컨트롤러
 *
 * 진입 경로:
 * Route::post('/api/pages/drag/pos') → DragController::__invoke()
 */
class DragController extends Controller
{
    public function __invoke(Request $request)
    {
        $uploaded = [];

        $uri = parse_url($_POST['_uri'])['path'];
        $uploaded['uri'] = $uri;

        $path = resource_path("actions");
        $path .= str_replace('/', DIRECTORY_SEPARATOR, $uri);
        $path .= ".json";
        $uploaded['path'] = $path;

        if (file_exists($path)) {
            $actions = json_decode(file_get_contents($path), true);
        } else {
            $actions = [];
        }

        // 새로운 저장 목록 변환
        $temp = [];
        foreach ($_POST['pos'] as $i) {
            if (isset($actions['widgets'][$i])) {
                $temp[] = $actions['widgets'][$i];
            }
        }

        $actions['widgets'] = $temp; // 수정된 순서 재저장
        file_put_contents($path, json_encode($actions, JSON_PRETTY_PRINT));

        return response()->json($uploaded);
    }
}
