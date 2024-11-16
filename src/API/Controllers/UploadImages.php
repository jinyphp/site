<?php
namespace Jiny\Site\API\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * drag upload 경로 지정
 * path 경로로 이미지 파일을 업로드
 */
class UploadImages extends Controller
{
    private $path;

    /**
     * public 경로로 이미지 파일 업로드
     */
    public function dropzone(Request $requet)
    {
        $uploaded = [];

        // 업로드 경로 확인 및 폴더 생성
        $uri = parse_url($_POST['path'])['path'];
        $uploaded['path'] = $uri;
        $path = public_path($uri);
        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // 파일 업로드
        if (!empty($_FILES['file']['name'][0])) {

            // 여러개 파일 등록
            $files = [];
            foreach ($_FILES['file']['name'] as $pos => $name) {
                $info = pathinfo($name);

                ## 이미지 파일
                if($info['extension'] == "jpg"
                    || $info['extension'] == "gif"
                    || $info['extension'] == "png"
                    || $info['extension'] == "svg") {

                    $source = $_FILES['file']['tmp_name'][$pos];
                    $filename = $path.DIRECTORY_SEPARATOR.$name;

                    if(move_uploaded_file($source, $filename)) {
                        $files[] = [
                            'name' => $name,
                            'path' => $filename,
                            'status' => 'success'
                        ];
                    }

                }
            }

            $uploaded['files'] = $files;

        }

        return response()->json($uploaded);
    }

}
