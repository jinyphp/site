<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * Admin Site Router
 */
if(function_exists('admin_prefix')) {
    $prefix = admin_prefix();

    Route::middleware(['web','auth', 'admin'])
    ->name('admin.site')
    ->prefix($prefix.'/site')->group(function () {

        Route::get('/terms', [\Jiny\Site\Http\Controllers\Admin\AdminSiteTerms::class,
            "index"]);

        Route::get('/language', [\Jiny\Site\Http\Controllers\Admin\AdminSiteLanguage::class,
                "index"]);

        Route::get('/screen', [\Jiny\Site\Http\Controllers\Admin\AdminSiteScreen::class,
            "index"]);

        Route::get('/country', [\Jiny\Site\Http\Controllers\Admin\AdminSiteCountry::class,
            "index"]);

        Route::get('/location', [\Jiny\Site\Http\Controllers\Admin\AdminSiteLocation::class,
            "index"]);

        Route::get('/menu', [\Jiny\Site\Http\Controllers\Admin\AdminSiteMenuCode::class,
            "index"]);

        Route::get('/menu/item/{code}', [\Jiny\Site\Http\Controllers\Admin\AdminSiteMenuItem::class,
            "index"]);

        Route::get('sitemap', [\Jiny\Site\Http\Controllers\Admin\AdminSitemap::class,
            "index"]);

        Route::get('layout', [\Jiny\Site\Http\Controllers\Admin\AdminSiteLayout::class,
            "index"]);

        Route::get('layout/tag', [
            \Jiny\Site\Http\Controllers\Admin\AdminSiteLayoutTag::class,
            "index"]);

        Route::get('log', [\Jiny\Site\Http\Controllers\Admin\AdminSiteLog::class,
            "index"]);

        Route::get('seo', [\Jiny\Site\Http\Controllers\Admin\AdminSiteSeo::class,
            "index"]);


        Route::get('actions/{path?}', [
            \Jiny\Site\Http\Controllers\Admin\AdminSiteActions::class,
            "index"])
            ->name('.actions.index')
            ->where('path', '.*');


        // 이미지 리소스 폴더
        // public/images/
        Route::post('images/delete', [
            \Jiny\Site\Http\Controllers\Admin\AdminSiteImages::class,
            "delete"])
            ->name('.images.delete');
        // 와일드카드 라우트를 마지막에 정의
        Route::get('images/{path?}', [
            \Jiny\Site\Http\Controllers\Admin\AdminSiteImages::class,
            "index"])
            ->name('.images.index')
            ->where('path', '.*');


        ## 상단설정 정보
        Route::get('header', [\Jiny\Site\Http\Controllers\Admin\AdminHeader::class,
            "index"]);

        ## 하단설정 정보
        Route::get('footer', [\Jiny\Site\Http\Controllers\Admin\AdminFooters::class,
            "index"]);

        ## 사이트 정보를 관리합니다.
        ## 위치: www 리소스 폴더 안에 위치합니다.
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

        ## 역할관리
        Route::get('roles', [
            \Jiny\Site\Http\Controllers\Admin\AdminSiteRoles::class,
            "index"
        ]);

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


/**
 * api 동작
 */
Route::middleware(['web'])
->group(function(){
    // 업로드: 지정한 경로
    Route::post('/api/upload/images', [
        Jiny\Site\API\Controllers\UploadImages::class,
        "dropzone"
    ]);

    // 계시판 클립보드 이미지 업로드
    Route::post('/api/upload/clip', [
        \Jiny\Site\API\Controllers\UploadClip::class,
        "store"]);
});
