<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



include(__DIR__.DIRECTORY_SEPARATOR."auto.php");


/**
 * Admin Site Router
 */
if(function_exists('admin_prefix')) {
    $prefix = admin_prefix();

    Route::middleware(['web','auth', 'admin'])
    ->name('admin.site')
    ->prefix($prefix.'/site')->group(function () {

        ## 상단설정 정보
        Route::get('header', [\Jiny\Site\Http\Controllers\Admin\AdminHeader::class,
            "index"]);

        ## 하단설정 정보
        Route::get('footer', [\Jiny\Site\Http\Controllers\Admin\AdminFooters::class,
            "index"]);

        ## 사이트 정보설정
        Route::get('info', [\Jiny\Site\Http\Controllers\Admin\InfomationController::class,
            "index"]);

        ## 설정
        Route::get('setting', [\Jiny\Site\Http\Controllers\Admin\SettingController::class,
            "index"]);


        Route::get('/routes',[\Jiny\Site\Http\Controllers\Admin\AdminRouteController::class,
            "index"]);

        // 마크다운 파일 관리
        Route::get('/resources', [\Jiny\Site\Http\Controllers\Admin\AdminResourceFiles::class,
            "index"]);



        ## 사이트 관리 담당자
        Route::get('manager', [
            \Jiny\Site\Http\Controllers\Admin\AdminSiteManager::class,
            "index"]);

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
