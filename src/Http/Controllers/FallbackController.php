<?php
namespace Jiny\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Jiny\WireTable\Http\Controllers\LiveController;
class FallbackController extends LiveController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);
    }

    public function index(Request $request)
    {
        // 1.www절대경로 파일 체크
        // slot을 포함하는 www 절대경로로 접속하는 경우
        if($res = $this->wwwFile($_SERVER['REQUEST_URI'])) {
            return $res;
        }

        // 2.slot
        // 여기에 인증된 사용자에 대한 처리를 추가합니다.
        $user = Auth::user();
        $slots = config("jiny.site.userslot");

        if($user && count($slots)>0){
            if($slots && isset($slots[$user->id])) {
                $activeSlot = $slots[$user->id];
            } else {
                $activeSlot = "";
            }
        } else {
            // 설정파일에서 active slot을 읽어옴
            $slots = config("jiny.site.slot");
            $activeSlot = "";
            if(is_array($slots) && count($slots)>0) {
                foreach($slots as $slot => $item) {
                    if($item['active']) {
                        $activeSlot = $slot;
                    }
                }
            }
        }

        // 활성화된 slot 확인
        $path = resource_path('www');
        $slotPath = $path."/".$activeSlot;
        if(!is_dir($slotPath)) {
            return "슬롯 ".$activeSlot." 폴더가 존재하지 않습니다.";
        }

        if(isset($_SERVER['REQUEST_URI'])) {
            ## www.slot에서 검색
            if($res = $this->route_dynamic($_SERVER['REQUEST_URI'], $activeSlot)) {
                return $res;
            }
        }

        // 3.테마검색
        if(isset($_SERVER['REQUEST_URI'])) {
            if($res = $this->route_dynamic_theme($_SERVER['REQUEST_URI'])) {
                return $res;
            }
        }


        ## 4.오류 페이지 출력
        if($activeSlot) {
            ## 404 www 리소스에서
            $viewFile = "www.".$activeSlot."::404";
            if(view()->exists($viewFile)) {
                return view($viewFile);
            }

            // return $viewFile." 리소스를 찾을 수 없습니다.";
            return view("jiny-site::www.errors.404");
        }


        //return $_SERVER['REQUEST_URI']."의 리소스를 찾을 수 없습니다.";
        abort(404);
    }

    private function wwwFile($uri) {
        $path = resource_path('www');
        if($uri == '/') {
            $filename = $path.$uri."index";
        } else {
            $filename = $path.$uri;
        }

        if(file_exists($filename)) {
            $extension = strtolower(substr(strrchr($filename,"."),1));
            $content_Type="";
            switch( $extension ) {
                //case "html": $content_Type="text/xml"; break;
                case "gif": $content_Type="image/gif"; break;
                case "png": $content_Type="image/png"; break;
                case "jpeg":
                case "jpg": $content_Type="image/jpeg"; break;
                case "svg": $content_Type="image/svg+xml"; break;
                default:
            }


            if(file_exists($filename)) {
                $body = file_get_contents($filename);

                return response($body)
                ->header('Content-type',$content_Type);
            }

            return false;
        }
    }

    /**
     * 테마에서 지정된 동적라우트가 있는지 검사
     */
    private function route_dynamic_theme($uri) {
        $theme = xTheme()->getTheme();
        //// 세션에서 현재 테마이름을 읽기
        //$theme = session()->get('theme');
        if($theme) {
            $uriPath = str_replace(['/'], ".", $uri);
            $viewFile = $theme.$uriPath;
            //dd($viewFile);
            if (View::exists("theme::".$viewFile)) {
                return view("theme::".$viewFile);
            }

            /*
            $path = base_path('theme');
            $theme = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $theme);
            $themePath = $path.DIRECTORY_SEPARATOR.$theme;
            $uriPath = str_replace(['/','\\'], DIRECTORY_SEPARATOR, $uri);

            ## Blade뷰
            if (file_exists($themePath.$uriPath.".blade.php")) {
                $_theme = str_replace(['/','\\'], ".", $theme);
                $_uri = str_replace(['/','\\'], ".", $uri);
                return view("theme::".$_theme.$_uri);
            }
            */

            ##
            $path = base_path('theme');
            $uriPath = str_replace(['.'], DIRECTORY_SEPARATOR, $viewFile);
            //dd($path.DIRECTORY_SEPARATOR.$uriPath);

            //dd($themePath.$uriPath.".html");
            if (file_exists($path.DIRECTORY_SEPARATOR.$uriPath.".html")) {
                //$body = file_get_contents($themePath.$uriPath.".html");
                // BinaryFileResponse 인스턴스 생성
                $response = new BinaryFileResponse($path.DIRECTORY_SEPARATOR.$uriPath.".html");

                // Content-Type 헤더 설정
                $response->headers->set('Content-Type', "text/html; charset=utf-8");
                return $response;
            }

        }

    }

    private function route_dynamic($uri, $slot) {

        //dd($uri);

        //1. blade.php 파일이 있는 경우 찾아서 출력함
        if($res = $this->www_isBlade($uri, $slot)) {
            return $res;
        }

        //2. Markown 파일이 있는 경우 찾아서 출력함
        if($res = $this->www_isMarkdown($uri, $slot)) {
            return $res;
        }

        //3. 리소스가
        if($res = $this->route_isBladeResource($uri)) {
            return $res;
        }

        //4. 이미지 파일 경우
        if($res = $this->www_isImage($uri, $slot)) {
            return $res;
        }

    }

    private function www_isBlade($uri, $slot) {
        $prefix_www = "www";
        $filename = str_replace('/','.',$uri);
        $filename = ltrim($filename,".");
        if(!$filename) {
            $filename = "index";
        }

        // slot path and filename
        if($slot) {
            $slotFilename = $prefix_www."::".$slot.".".$filename;
        } else {
            $slotFilename = $prefix_www."::".$filename;
        }

        ## actions 값 확인
        $actionPath = resource_path("actions");
        $actionFile = $actionPath.DIRECTORY_SEPARATOR.str_replace('.',DIRECTORY_SEPARATOR,$filename);
        //dd($actionFile.".json");
        if(file_exists($actionFile.".json")) {
            $json = file_get_contents($actionFile.".json");
            $actions = json_decode($json, true);
        } else {
            $actions = null;
        }

        // 슬롯에 지정한 파일이름 존재하는 경우
        if(view()->exists($slotFilename)) {
            return view($slotFilename,[
                'actions' => $actions
            ]);
        }

        // 파일이 존재하지 않고, 폴더명인 경우
        // 폴더 안에 있는 index로 대체
        else
        if(view()->exists($slotFilename.".index")) {
            return view($slotFilename.".index",[
                'actions' => $actions
            ]);
        }
    }

    private function www_isMarkdown($uri, $slot) {
        $prefix_www = "www";
        $filename = str_replace('/', DIRECTORY_SEPARATOR, $uri);
        $filename = ltrim($filename, DIRECTORY_SEPARATOR);
        /*
        if(!$filename) {
            $filename = "index";
        }

        dd($filename);
        */

        // slot path
        $slotKey = $prefix_www.DIRECTORY_SEPARATOR.$slot;
        $path = resource_path($slotKey);


        $filePath = $path.DIRECTORY_SEPARATOR.$filename;

        $body = null;
        $mk = \Jiny\Markdown\MarkdownPage::instance();

        if(file_exists($filePath.".md")) {
            //$body = file_get_contents($filePath.".md");
            $body = $mk->load($filePath);

            //dump($filePath.".md");
        } else if(is_dir($filePath)) {
            $filePath = $filePath.DIRECTORY_SEPARATOR."index";
            if(file_exists($filePath.".md")) {
                //$body = file_get_contents($filePath.".md");
                $body = $mk->load($filePath);
            }
        }

        if($body) {
            // 마크다운 변환
            $mk->parser($body); //->render();
            //dd($mk);
            return $mk->view($prefix_www."::".$slot."._layouts.");
        }
    }

    private function www_isImage($uri, $slot) {
        //dd($uri);
        $prefix_www = "www";
        $filename = str_replace('/', DIRECTORY_SEPARATOR, $uri);
        $filename = ltrim($filename, DIRECTORY_SEPARATOR);

        // slot path
        $slotKey = $prefix_www.DIRECTORY_SEPARATOR.$slot;
        $path = resource_path($slotKey);

        if(file_exists($path.DIRECTORY_SEPARATOR.$filename)) {

            //$file = basename($filePath);
            $file = $path.DIRECTORY_SEPARATOR.$filename;
            $extension = strtolower(substr(strrchr($file,"."),1));
            $content_Type="";
            switch( $extension ) {
                //case "html": $content_Type="text/xml"; break;

                case "gif": $content_Type="image/gif"; break;
                case "png": $content_Type="image/png"; break;
                case "jpeg":
                case "jpg": $content_Type="image/jpeg"; break;
                case "svg": $content_Type="image/svg+xml"; break;
                default:
            }

            if(is_file($file)) {
                $body = file_get_contents($file);
                return response($body)
                    ->header('Content-type',$content_Type);
            }
        }




        // 마크다운 변환
        /*
        $mk = Jiny\Markdown\MarkdownPage::instance();
        $txt = $mk->load($path.DIRECTORY_SEPARATOR.$filename);
        if($txt) {
            $mk->parser($txt); //->render();
            return $mk->view($prefix_www."::".$slot."._layouts.");
        }
            */


    }

    private function route_isBladeResource($uri) {
        $filename = str_replace('/','.',$uri);
        $filename = ltrim($filename,".");

        // 리소스폴더에 파일명과 동일한 blade 파일이 있는지 확인
        if (view()->exists($filename))
        {
            // 리소스 뷰를 바로 출력합니다.
            return view($filename,[

            ]);
        }
        // 혹시 폴더명이 존재하는 경우, $filename/index.blade.php를
        // 출력합니다.
        else if (view()->exists($filename.".index"))
        {
            return view($filename.".index",[

            ]);
        }

    }






}
