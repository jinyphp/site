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

// 인증된 사용자를 처리하는 라우트 그룹
Route::middleware(['web'])->group(function () {
    Route::fallback([
        \Jiny\Site\Http\Controllers\FallbackController::class,
        'index']);
});
