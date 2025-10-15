<?php

namespace Jiny\Site\Http\Controllers\Admin\Templates\Layout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class BulkActionController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'layouts' => 'required|array',
            'layouts.*' => 'string'
        ]);

        $action = $request->input('action');
        $layoutKeys = $request->input('layouts');

        if ($action === 'delete') {
            $this->bulkDelete($layoutKeys);
            $message = count($layoutKeys) . ' layout(s) deleted successfully.';
        }

        return redirect()->route('admin.cms.templates.layout.index')
            ->with('success', $message ?? 'Bulk action completed.');
    }

    private function bulkDelete($layoutKeys)
    {
        $configPath = base_path('vendor/jiny/site/config/layouts.php');
        $config = include $configPath;

        foreach ($layoutKeys as $key) {
            unset($config[$key]);
            Config::offsetUnset('site.layouts.' . $key);
        }

        $configContent = "<?php\n\nreturn " . var_export($config, true) . ";\n";
        File::put($configPath, $configContent);
    }
}