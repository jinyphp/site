<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


if(!function_exists("isLivewireUri")) {
    function isLivewireUri() {
        if(isset($_SERVER['REQUEST_URI'])) {
            $uris = explode('/', $_SERVER['REQUEST_URI']);
            if($uris[1] == "livewire") {
                return false;
            }
        }
        return false;
    }
}


/**
 *  자동 URL 라우팅
 */
if(!function_exists("route_dynamic")) {




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

}



// 인증된 사용자를 처리하는 라우트 그룹
Route::middleware(['web'])->group(function () {
    Route::fallback([
        \Jiny\Site\Http\Controllers\FallbackController::class,
        'index']);
});
