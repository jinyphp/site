<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


//include(__DIR__.DIRECTORY_SEPARATOR."auto.php");


/**
 * Admin Site Router
 */
if(function_exists('admin_prefix')) {
    $prefix = admin_prefix();

    Route::middleware(['web','auth', 'admin'])
    ->name('admin.site')
    ->prefix($prefix.'/site')->group(function () {

        Route::get('/menu', [\Jiny\Site\Http\Controllers\Admin\AdminSiteMenuCode::class,
            "index"]);

        Route::get('/menu/item/{code}', [\Jiny\Site\Http\Controllers\Admin\AdminSiteMenuItem::class,
            "index"]);

        Route::get('sitemap', [\Jiny\Site\Http\Controllers\Admin\AdminSitemap::class,
            "index"]);

        Route::get('layout', [\Jiny\Site\Http\Controllers\Admin\AdminSiteLayout::class,
            "index"]);

        Route::get('log', [\Jiny\Site\Http\Controllers\Admin\AdminSiteLog::class,
            "index"]);

        Route::get('seo', [\Jiny\Site\Http\Controllers\Admin\AdminSiteSeo::class,
            "index"]);

        Route::get('actions', [\Jiny\Site\Http\Controllers\Admin\AdminSiteActions::class,
            "index"]);

        Route::get('images', [\Jiny\Site\Http\Controllers\Admin\AdminSiteImages::class,
            "index"]);

        ## 상단설정 정보
        Route::get('header', [\Jiny\Site\Http\Controllers\Admin\AdminHeader::class,
            "index"]);

        ## 하단설정 정보
        Route::get('footer', [\Jiny\Site\Http\Controllers\Admin\AdminFooters::class,
            "index"]);

        ## 사이트 정보설정
        Route::get('info', [
            \Jiny\Site\Http\Controllers\Admin\AdminSiteInfomation::class,
            "index"]);

        ## 설정
        Route::get('setting', [
            \Jiny\Site\Http\Controllers\Admin\AdminSiteSetting::class,
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
