<?php
namespace Jiny\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\DB;

/**
 * 동적 페이지 반환
 */
class FallbackController extends Controller
{
    public function __construct()
    {
        // parent::__construct();
        // $this->setVisit($this);
    }

    ## 페이지 반환
    public function index(Request $request)
    {
        $url = $request->path();
        $urlPath = str_replace('/',DIRECTORY_SEPARATOR, $url);
        //dd($url);

        // route0. CMS 동적 페이지 체크 (최우선)
        // /admin/cms/pages에서 등록한 페이지들을 가장 먼저 처리
        if($res = $this->route_cms_pages($url)) {
            return $res;
        }

        // // route1. 컨트롤러 동작 처리
        // // uri에 대한 actions 설정값이 있는 경우,
        // // 설정 정보에 따라서 라우트 동작을 처리

        // $pathAction = resource_path("actions");
        // if(file_exists($pathAction.DIRECTORY_SEPARATOR.$urlPath.".json")) {
        //     $this->actions = json_file_decode($pathAction.DIRECTORY_SEPARATOR.$urlPath.".json");
        //     if($res = $this->processByActions($request)) {
        //         return $res;
        //     }
        // }

        // // route2. www 절대경로 파일 체크
        // // slot을 포함하는 www 절대경로로 접속하는 경우
        // if($res = $this->wwwFile($url)) {
        //     return $res;
        // }

        // // route3. slot 리소스 파일 체크
        // // 활성화된 slot 확인
        // $activeSlot = Slot()->name;
        // $path = resource_path('www');
        // $slotPath = $path."/".$activeSlot;
        // if(!is_dir($slotPath)) {
        //     return "슬롯 ".$activeSlot." 폴더가 존재하지 않습니다.";
        // }

        // // route4. slot 리소스 파일 체크
        // if(isset($url)) {
        //     ## www.slot에서 검색
        //     if($res = $this->route_dynamic($url, $activeSlot)) {
        //         return $res;
        //     }
        // }

        // // route5. 테마 리소스 파일 체크
        // if(isset($url)) {
        //     if($res = $this->route_dynamic_theme($url)) {
        //         return $res;
        //     }
        // }


        // // board slug 체크
        // if($res = $this->route_board_slug($_SERVER['REQUEST_URI'])) {
        //     return $res;
        // }

        // // route6. 오류 페이지 출력
        // if($res = $this->page404($activeSlot)) {
        //     return $res;
        // }

        // //return $_SERVER['REQUEST_URI']."의 리소스를 찾을 수 없습니다.";
        // abort(404);


        return view("jiny-site::errors.404");
    }

    /**
     * 재귀호출, 다차원 배열값 병합하기
     */
    private function actionMergeValues(&$actions, $items)
    {
        foreach($items as $key => $value) {
            if(is_array($value)) {
                $this->actionMergeValues($actions[$key], $value);
            }
            $actions[$key] = $value;
        }
    }

    private function processByActions($request)
    {
        // 동작타입 분석
        if(isset($this->actions['type'])) {
            $type = $this->actions['type'];
            switch($type) {
                case 'board':
                    // 계시판 테이블 컨트롤러
                    // 싱글 popup형 계시판만 적용
                    //$obj = new \Jiny\Site\Board\Http\Controllers\Site\SiteBoardTable();
                    $obj = new \Jiny\Site\Board\Http\Controllers\Site\SiteBoardPopup();
                    $this->actionMergeValues($obj->actions, $this->actions);

                    return $obj->index($request);
                    //break;
            }
        }

        return null;
    }

    /**
     * 404 페이지 출력
     */
    private function page404($activeSlot)
    {
        // 우선순위1 : actions 설정값
        if (isset($this->actions['view']['layout'])) {
            $aViewLayout = $this->actions['view']['layout'];
            if ($aViewLayout) {
                if($res = siteViewName($aViewLayout)){
                    return view($res);
                    //return $res;
                }
            }
        }

        // 우선순위2 : 기본 404 페이지
        if($res = siteViewName("jiny-site::www.errors.404")){
            return view($res);
            //return $res;
        }

        // 우선순위3 : 기본 404 페이지


    }

    /**
     * slot 리소스 파일 체크
     */
    private function route_dynamic($uri, $slot)
    {


        //1. blade.php 파일이 있는 경우 찾아서 출력함
        if($res = $this->www_isBlade($uri, $slot)) {
            return $res;
        }

        //dd("aa4");

        //2. Markown 파일이 있는 경우 찾아서 출력함
        if($res = $this->www_isMarkdown($uri, $slot)) {
            return $res;
        }

        //3. Html 파일이 있는 경우 찾아서 출력함
        if($res = $this->www_isHtml($uri, $slot)) {
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


    private function wwwFile($uri)
    {

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
        // xTheme() 함수가 삭제되었으므로 세션에서 테마 확인
        $theme = session('theme', null);
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


    /**
     * 슬롯 www에서
     * blade.php 파일 출력
     */
    private function www_isBlade($uri, $slot) {
        $prefix_www = "www";
        $filename = str_replace('/', DIRECTORY_SEPARATOR, $uri);
        $filename = ltrim($filename, DIRECTORY_SEPARATOR);

        $path = resource_path($prefix_www.DIRECTORY_SEPARATOR.$slot);

        $filePath = $path.DIRECTORY_SEPARATOR.$filename;

        // 페이지 내부에서 라이브와이어 컴포넌트 출력
        if(file_exists($filePath.".blade.php")) {
            //return view("jiny-site-page::site.blade.layout");
            $bladePath = "www::".$slot.".".str_replace('/','.',$uri);
            return view($bladePath);
        } else if(is_dir($filePath)) {
            $filePath = $filePath.DIRECTORY_SEPARATOR."index";
            if(file_exists($filePath.".blade.php")) {
                //return view("jiny-site-page::site.blade.layout");
                $bladePath = "www::".$slot.".".str_replace('/','.',$uri).".index";
                return view($bladePath);
            }
        }

        return false;

        // $prefix_www = "www";
        // $filename = str_replace('/','.',$uri);
        // $filename = ltrim($filename,".");
        // if(!$filename) {
        //     $filename = "index";
        // }

        // // slot path and filename
        // if($slot) {
        //     $slotFilename = $prefix_www."::".$slot.".".$filename;
        // } else {
        //     $slotFilename = $prefix_www."::".$filename;
        // }

        // ## actions 값 확인
        // $actionPath = resource_path("actions");
        // $actionFile = $actionPath.DIRECTORY_SEPARATOR.str_replace('.',DIRECTORY_SEPARATOR,$filename);
        // if(file_exists($actionFile.".json")) {
        //     $json = file_get_contents($actionFile.".json");
        //     $actions = json_decode($json, true);
        // } else {
        //     $actions = null;
        // }

        // dd($slotFilename);
        // // 슬롯에 지정한 파일이름 존재하는 경우
        // if(view()->exists($slotFilename)) {
        //     return view($slotFilename,[
        //         'actions' => $actions
        //     ]);
        // }

        // // 파일이 존재하지 않고, 폴더명인 경우
        // // 폴더 안에 있는 index로 대체
        // else
        // if(view()->exists($slotFilename.".index")) {
        //     return view($slotFilename.".index",[
        //         'actions' => $actions
        //     ]);
        // }
    }


    /**
     * 슬롯 www에서
     * 마크다운 파일 출력
     */
    private function www_isMarkdown($uri, $slot)
    {
        $prefix_www = "www";
        $filename = str_replace('/', DIRECTORY_SEPARATOR, $uri);
        $filename = ltrim($filename, DIRECTORY_SEPARATOR);

        $path = resource_path($prefix_www.DIRECTORY_SEPARATOR.$slot);

        $filePath = $path.DIRECTORY_SEPARATOR.$filename;

        // 페이지 내부에서 라이브와이어 컴포넌트 출력
        if(file_exists($filePath.".md")) {
            return view("jiny-markdown::layout");

        } else if(is_dir($filePath)) {
            $filePath = $filePath.DIRECTORY_SEPARATOR."index";
            if(file_exists($filePath.".md")) {
                return view("jiny-markdown::layout");
            }
        }

        return false;
    }

    /**
     * 슬롯 www에서
     * html 파일 출력
     */
    private function www_isHtml($uri, $slot)
    {
        $prefix_www = "www";
        $filename = str_replace('/', DIRECTORY_SEPARATOR, $uri);
        $filename = ltrim($filename, DIRECTORY_SEPARATOR);

        $path = resource_path($prefix_www.DIRECTORY_SEPARATOR.$slot);

        $filePath = $path.DIRECTORY_SEPARATOR.$filename;

        // 페이지 내부에서 라이브와이어 컴포넌트 출력
        if(file_exists($filePath.".html")) {
            return view("jiny-site-page::site.html.layout");

        } else if(is_dir($filePath)) {
            $filePath = $filePath.DIRECTORY_SEPARATOR."index";
            if(file_exists($filePath.".html")) {
                return view("jiny-site-page::site.html.layout");
            }
        }

        return false;
    }




    /**
     * 슬롯 www에서
     * 이미지 파일 출력
     */
    private function www_isImage($uri, $slot)
    {
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

        return false;
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

    /**
     * CMS 동적 페이지 체크
     * /admin/cms/pages에서 등록한 페이지들을 처리
     */
    private function route_cms_pages($uri)
    {
        // URI에서 앞뒤 슬래시 제거하여 slug 추출
        $slug = trim($uri, '/');

        // 빈 slug는 처리하지 않음 (홈페이지는 별도 처리)
        if (empty($slug)) {
            return null;
        }

        // DB에서 페이지 존재 여부만 확인 (간단한 검색)
        try {
            $pageExists = DB::table('site_pages')
                ->where('slug', $slug)
                ->where('status', 'published')
                ->where(function($query) {
                    $query->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                })
                ->whereNull('deleted_at')
                ->exists();

            if (!$pageExists) {
                return null;
            }

            // 페이지가 존재하면 PageController에 위임
            $pageController = new \Jiny\Site\Http\Controllers\PageController();
            $request = request();

            return $pageController->show($request, $slug);

        } catch (\Exception $e) {
            // 예외 발생 시 로그 기록 후 null 반환
            \Illuminate\Support\Facades\Log::warning('CMS Page processing error', [
                'uri' => $uri,
                'slug' => $slug,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }


    /**
     * 계시판 slug 체크
     */
    private function route_board_slug($uri) {
        // 계시판은 /board/ prefix를 사용하므로 해당 경우에만 체크
        if (!str_starts_with($uri, '/board/')) {
            return null;
        }

        // /board/ 이후의 slug 추출
        $slug = trim(substr($uri, 7), '/'); // '/board/'를 제거

        // 빈 slug인 경우 처리하지 않음
        if (empty($slug)) {
            return null;
        }

        try {
            // 계시판 slug 체크
            $board = DB::table('site_board')->where('slug', $slug)->first();
            if ($board) {
                $obj = new \Jiny\Site\Board\Http\Controllers\Site\SiteBoardTable();
                return $obj->table($board);
            }
        } catch (\Exception $e) {
            // 테이블이 존재하지 않거나 다른 오류 발생시 null 반환
            \Illuminate\Support\Facades\Log::warning('Board slug check error', [
                'uri' => $uri,
                'slug' => $slug,
                'error' => $e->getMessage()
            ]);
            return null;
        }

        return null;
    }






}
