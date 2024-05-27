<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;


/**
 *  자동 URL 라우팅
 */
if(!function_exists("isLivewireUri")) {
    function isLivewireUri() {
        if(isset($_SERVER['REQUEST_URI'])) {
            $uris = explode('/', $_SERVER['REQUEST_URI']);
            if($uris[1] == "livewire") {
                return false;
                //dd($uris);
                //return true;
            }
        }

        return false;
    }
}



if(!function_exists("route_dynamic")) {

    // 인증된 사용자를 처리하는 라우트 그룹
    Route::middleware(['web'])->group(function () {

        // 인증된 사용자에 대한 fallback 설정
        Route::fallback(function () {

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
                if(count($slots)>0) {
                    foreach($slots as $slot => $item) {
                        if($item['active']) {
                            $activeSlot = $slot;
                        }
                    }
                }
            }

            //dd($activeSlot);

            $path = resource_path('www');
            $slotPath = $path."/".$activeSlot;
            if(!is_dir($slotPath)) {
                return "슬롯 ".$activeSlot." 폴더가 존재하지 않습니다.";
            }

            if(isset($_SERVER['REQUEST_URI'])) {
                if($res = route_dynamic($_SERVER['REQUEST_URI'], $activeSlot)) {
                    return $res;
                }
            }

            // www 리소스에서
            // 404 오류 페이지 출력
            if(view()->exists("www.".$activeSlot."::404")) {
                return view("www.".$activeSlot."::404");
            }

            // fallback 리소스에서
            //return view("fallback::404");
            if($activeSlot) {
                return $activeSlot."에서 ".$_SERVER['REQUEST_URI']."의 리소스를 찾을 수 없습니다.";
            }

            return $_SERVER['REQUEST_URI']."의 리소스를 찾을 수 없습니다.";

        });
    });


    // 미인증된 사용자를 처리하는 라우트 그룹
    /*
    Route::middleware(['web'])->group(function () {
        // 미인증된 사용자에 대한 fallback 설정
        Route::fallback(function () {
            // 여기에 미인증된 사용자에 대한 처리를 추가합니다.
            // 설정파일에서 active slot을 읽어옴
            $slots = config("jiny.site.slot");
            $activeSlot = "";
            foreach($slots as $slot => $item) {
                if($item['active']) {
                    $activeSlot = $slot;
                }
            }

            $path = resource_path('www');
            $slotPath = $path."/".$activeSlot;
            if(!is_dir($slotPath)) {
                return "슬롯 ".$activeSlot." 폴더가 존재하지 않습니다.";
            }

            if(isset($_SERVER['REQUEST_URI'])) {
                if($res = route_dynamic($_SERVER['REQUEST_URI'], $activeSlot)) {
                    return $res;
                }
            }

            // www 리소스에서
            // 404 오류 페이지 출력
            if(view()->exists("www.".$activeSlot."::404")) {
                return view("www.".$activeSlot."::404");
            }

            // fallback 리소스에서
            //return view("fallback::404");
            return $activeSlot."에서 ".$_SERVER['REQUEST_URI']."의 리소스를 찾을 수 없습니다.";

        });
    });
    */




    // livewire 경로는 제외
    if(!isLivewireUri()) {

        // active 슬롯 찾기
        // 설정파일에서 active slot을 읽어옴
        /*
        $slots = config("jiny.site.slot");
        $activeSlot = "";
        foreach($slots as $slot => $item) {
            if($item['active']) {
                $activeSlot = $slot;
            }
        }
        */

        // Fallack 사이트 오토라우팅
        /*
        Route::fallback(function () use ($activeSlot) {

            $path = resource_path('www');
            $slotPath = $path."/".$activeSlot;
            if(!is_dir($slotPath)) {
                return "슬롯 ".$activeSlot." 폴더가 존재하지 않습니다.";
            }

            if(isset($_SERVER['REQUEST_URI'])) {
                if($res = route_dynamic($_SERVER['REQUEST_URI'], $activeSlot)) {
                    return $res;
                }
            }

            // shop 리소스에서
            // 404 오류 페이지 출력
            if(view()->exists("www-".$activeSlot."::404")) {
                return view("www-".$activeSlot."::404");
            }

            // fallback 리소스에서
            //return view("fallback::404");
            return $activeSlot."에서 ".$_SERVER['REQUEST_URI']."의 리소스를 찾을 수 없습니다.";

        })->middleware('web');
        */

    }




    function route_dynamic($uri, $slot) {
        //1. blade.php 파일이 있는 경우 찾아서 출력함
        if($res = www_isBlade($uri, $slot)) {
            return $res;
        }

        //2. Markown 파일이 있는 경우 찾아서 출력함
        if($res = www_isMarkdown($uri, $slot)) {
            return $res;
        }

        //9. 리소스가
        if($res = route_isBladeResource($uri)) {
            return $res;
        }

    }

    // shop 폴더에서 검색
    function www_isBlade($uri, $slot) {
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

        // 슬롯에 지정한 파일이름 존재하는 경우
        if(view()->exists($slotFilename)) {
            return view($slotFilename);
        }

        // 파일이 존재하지 않고, 폴더명인 경우
        // 폴더 안에 있는 index로 대체
        else
        if(view()->exists($slotFilename.".index")) {
            return view($slotFilename.".index");
        }
    }


    // 마크다운 파일인
if(!function_exists("www_isMarkdown")) {
    function www_isMarkdown($uri, $slot) {
        $prefix_www = "www";
        $filename = str_replace('/', DIRECTORY_SEPARATOR, $uri);
        $filename = ltrim($filename, DIRECTORY_SEPARATOR);
        if(!$filename) {
            $filename = "index";
        }

        // slot path
        $slotKey = $prefix_www.DIRECTORY_SEPARATOR.$slot;
        $path = resource_path($slotKey);

        // 마크다운 변환
        $mk = Jiny\Markdown\MarkdownPage::instance();
        $txt = $mk->load($path.DIRECTORY_SEPARATOR.$filename);
        if($txt) {
            $mk->parser($txt); //->render();
            return $mk->view($prefix_www."::".$slot."._layouts.");
        }
    }
}

    // 라라벨 기본 resources 에서 검색
    function route_isBladeResource($uri) {
        $filename = str_replace('/','.',$uri);
        $filename = ltrim($filename,".");

        // 리소스폴더에 파일명과 동일한 blade 파일이 있는지 확인
        if (view()->exists($filename))
        {
            // 리소스 뷰를 바로 출력합니다.
            return view($filename);
        }
        // 혹시 폴더명이 존재하는 경우, $filename/index.blade.php를
        // 출력합니다.
        else if (view()->exists($filename.".index"))
        {
            return view($filename.".index");
        }

    }



}


/**
 * Admin Site Router
 */
if(function_exists('admin_prefix')) {
    $prefix = admin_prefix();

    Route::middleware(['web','auth', 'admin'])
    ->name('admin.site')
    ->prefix($prefix.'/site')->group(function () {

        ## 설정
        Route::get('slot', [
            \Jiny\Site\Http\Controllers\Admin\SlotSettingController::class,
            "index"
        ]);
        Route::get('userslot', [
            \Jiny\Site\Http\Controllers\Admin\UserSlotSettingController::class,
            "index"
        ]);

        // 사이트 데쉬보드
        Route::get('/', [
            \Jiny\Site\Http\Controllers\Admin\AdminSiteDashboard::class,
            "index"]);

    });
}


