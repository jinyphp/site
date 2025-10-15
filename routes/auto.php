<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

// if(!function_exists("isLivewireUri")) {
//     function isLivewireUri() {
//         if(isset($_SERVER['REQUEST_URI'])) {
//             $uris = explode('/', $_SERVER['REQUEST_URI']);
//             if($uris[1] == "livewire") {
//                 return false;
//             }
//         }
//         return false;
//     }
// }

// 모든 라우트가 매칭되지 않을 때 실행되는 Fallback 라우트
// CMS 동적 페이지, 슬롯 파일, 테마 파일 등을 처리
Route::middleware(['web'])->group(function () {
    Route::fallback([
        \Jiny\Site\Http\Controllers\FallbackController::class,
        'index']);
});
