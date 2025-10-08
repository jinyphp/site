<?php

namespace Jiny\Site\Api\Controllers\PageWidget;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * 404 페이지 파일 업로드 API 컨트롤러
 *
 * 진입 경로:
 * Route::post('/api/upload/404') → Upload404Controller::__invoke()
 */
class Upload404Controller extends Controller
{
    protected $config;

    public function __construct()
    {
        $this->loadConfig();
    }

    protected function loadConfig()
    {
        $this->config = [
            'upload_path' => 'pages',
            'allowed_extensions' => ['md', 'htm', 'html', 'jpg', 'gif', 'png', 'svg', 'php'],
        ];
    }

    public function __invoke(Request $request)
    {
        $uploaded = [];

        if (!empty($_FILES['file']['name'][0])) {
            foreach ($_FILES['file']['name'] as $pos => $name) {
                $info = pathinfo($name);

                // 파일 확장자별 처리
                switch ($info['extension']) {
                    case 'md':
                        $uploaded = $this->uploadMarkdown($pos, $name);
                        break;
                    case 'htm':
                    case 'html':
                        $uploaded = $this->uploadHtml($pos, $name);
                        break;
                    case 'jpg':
                    case 'gif':
                    case 'png':
                    case 'svg':
                        $uploaded = $this->uploadImage($pos, $name);
                        break;
                    case 'php':
                        $uploaded = $this->uploadBlade($pos, $name);
                        break;
                }

                $uploaded['info'] = $info;
            }
        }

        return response()->json($uploaded);
    }

    protected function uploadFile($pos, $name)
    {
        $uploaded = [];
        $slot = $this->getSlot();
        $uploaded['slot'] = $slot;

        $path = resource_path("www");
        if ($slot) {
            $path .= DIRECTORY_SEPARATOR . $slot;
        }

        $uri = parse_url($_POST['_uri'])['path'];
        $uploaded['uri'] = $uri;

        $path .= str_replace("/", DIRECTORY_SEPARATOR, $uri);
        $uploaded['path'] = $path;

        $filename = $path . DIRECTORY_SEPARATOR . $name;
        $uploaded['name'] = $name;
        $uploaded['file'] = $filename;

        $source = $_FILES['file']['tmp_name'][$pos];

        if (move_uploaded_file($source, $filename)) {
            $uploaded['status'] = "upload success";
        }

        return $uploaded;
    }

    protected function uploadMarkdown($pos, $name)
    {
        $uploaded = $this->uploadFile($pos, $name);
        return $this->updateWidgets('widget-markdown', $uploaded);
    }

    protected function uploadHtml($pos, $name)
    {
        $uploaded = $this->uploadFile($pos, $name);
        return $this->updateWidgets('widget-html', $uploaded);
    }

    protected function uploadImage($pos, $name)
    {
        $uploaded = $this->uploadFile($pos, $name);
        $uploaded['name'] = [$uploaded['name']];
        return $this->updateWidgets('widget-image', $uploaded);
    }

    protected function uploadBlade($pos, $name)
    {
        $uploaded = $this->uploadFile($pos, $name);
        return $this->updateWidgets('widget-blade', $uploaded);
    }

    protected function updateWidgets($element, $uploaded)
    {
        $path = resource_path("actions");
        $file = $path . str_replace('/', DIRECTORY_SEPARATOR, $uploaded['uri']) . ".json";

        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }

        $actions = file_exists($file) ? json_decode(file_get_contents($file), true) : [];

        if (!isset($actions['widgets'])) {
            $actions['widgets'] = [];
        }

        $key = uniqid(mt_rand() . $element, true);
        $key = str_replace('.', '', $key);

        $actions['widgets'][] = [
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
            'enable' => 1,
            'key' => $key,
            'route' => $uploaded['uri'],
            'path' => $uploaded['name'],
            'element' => $element,
            'pos' => 1,
            'ref' => 0,
            'level' => 1
        ];

        file_put_contents($file, json_encode($actions, JSON_PRETTY_PRINT));

        return $uploaded;
    }

    protected function getSlot()
    {
        $user = Auth::user();
        $slots = config("site.userslot");

        if ($user && count($slots) > 0) {
            if (isset($slots[$user->id])) {
                return $slots[$user->id];
            }
        }

        $slots = config("site.slot");
        if (is_array($slots) && count($slots) > 0) {
            foreach ($slots as $slot => $item) {
                if ($item['active'] ?? false) {
                    return $slot;
                }
            }
        }

        return false;
    }
}
