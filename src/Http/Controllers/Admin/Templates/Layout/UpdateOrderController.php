<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Layout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class UpdateOrderController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'string'
        ]);

        $order = $request->input('order');
        $this->updateLayoutOrder($order);

        return response()->json([
            'success' => true,
            'message' => 'Layout order updated successfully.'
        ]);
    }

    private function updateLayoutOrder($order)
    {
        $configPath = base_path('vendor/jiny/site/config/layouts.php');
        $config = include $configPath;

        $orderedConfig = [];

        // 새로운 순서대로 정렬
        foreach ($order as $key) {
            if (isset($config[$key])) {
                $orderedConfig[$key] = $config[$key];
            }
        }

        // 순서에 없는 항목들 추가
        foreach ($config as $key => $data) {
            if (!isset($orderedConfig[$key])) {
                $orderedConfig[$key] = $data;
            }
        }

        $configContent = "<?php\n\nreturn " . var_export($orderedConfig, true) . ";\n";
        File::put($configPath, $configContent);

        // Config 캐시 업데이트
        Config::set('site.layouts', $orderedConfig);
    }
}