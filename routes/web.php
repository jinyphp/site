<?php

use Illuminate\Support\Facades\Route;
use Jiny\Site\Http\Middleware\CheckSiteEnabled;

// 메인 welcome 페이지
Route::get('/', \Jiny\Site\Http\Controllers\Welcome\WelcomeController::class)->name('home');



/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| 사이트 관련 라우트를 정의합니다.
| config('site.enable') 설정에 따라 활성화/비활성화 됩니다.
|
*/

// 사이트 라우트 그룹
// Route::middleware(['web', CheckSiteEnabled::class])->group(function () {

    // 홈페이지
    // Route::get('/', \Jiny\Site\Http\Controllers\Site\Home\IndexController::class)
    //     ->name('home');

    // 약관 및 정책
    // Route::prefix('terms')->name('terms.')->group(function () {
    //     Route::get('/{any?}', \Jiny\Site\Http\Controllers\Site\Terms\ShowController::class)
    //         ->name('show')
    //         ->where('any', '.*');
    // });

    // About 페이지
    Route::get('/about', \Jiny\Site\Http\Controllers\Site\About\IndexController::class)
        ->name('about');

    // 동적 페이지 (Fallback - 마지막에 위치)
    // Route::get('/{slug}', \Jiny\Site\Http\Controllers\Site\Page\ShowController::class)
    //     ->name('page.show')
    //     ->where('slug', '.*');
// });

// Sitemap
// Route::middleware('web')->group(function () {
//     Route::get('/sitemap.xml', \Jiny\Site\Http\Controllers\Site\Sitemap\XmlController::class)
//         ->name('sitemap.xml');
// });

// FAQ (site-cms에서 이동)
// Route::middleware('web')->prefix('faq')->name('faq.')->group(function () {
//     Route::get('/', \Jiny\Site\Http\Controllers\Site\Faq\IndexController::class)
//         ->name('index');
    // Route::get('/{code}', \Jiny\Site\Http\Controllers\Site\Faq\CategoryController::class)
    //     ->name('category');
    // Route::get('/{code}/{id}', \Jiny\Site\Http\Controllers\Site\Faq\ShowController::class)
    //     ->name('show');
// });

// Help (site-cms에서 이동)
// Route::middleware('web')->prefix('help')->name('help.')->group(function () {
//     Route::get('/', \Jiny\Site\Http\Controllers\Site\Help\IndexController::class)
//         ->name('index');
    // Route::get('/{code}', \Jiny\Site\Http\Controllers\Site\Help\CategoryController::class)
    //     ->name('category');
    // Route::get('/{code}/{id}', \Jiny\Site\Http\Controllers\Site\Help\ShowController::class)
    //     ->name('show');
// });

/*
|--------------------------------------------------------------------------
| Board Routes (회원용 게시판)
|--------------------------------------------------------------------------
|
| 회원이 접근 가능한 게시판 기능을 제공합니다.
| 게시글 작성/수정/삭제는 로그인한 사용자만 가능하며,
| 자신의 게시글만 수정/삭제할 수 있습니다.
|
*/

Route::middleware('web')->prefix('board')->name('board.')->group(function () {
    // 게시판 대시보드 (메인 페이지)
    Route::get('/', \Jiny\Site\Http\Controllers\Site\Board\DashboardController::class)
        ->name('dashboard');

    // 게시판 목록
    Route::get('/{code}', \Jiny\Site\Http\Controllers\Site\Board\IndexController::class)
        ->name('index');

    // 게시글 상세보기
    Route::get('/{code}/{id}', \Jiny\Site\Http\Controllers\Site\Board\ShowController::class)
        ->name('show')
        ->where('id', '[0-9]+');

    // 새 글 작성
    Route::get('/{code}/create', \Jiny\Site\Http\Controllers\Site\Board\CreateController::class)
        ->name('create');

    Route::post('/{code}', \Jiny\Site\Http\Controllers\Site\Board\StoreController::class)
        ->name('store');

    // 하위글 작성
    Route::get('/{code}/{id}/reply', \Jiny\Site\Http\Controllers\Site\Board\CreateChildController::class)
        ->name('reply')
        ->where('id', '[0-9]+');

    // 글 수정
    Route::get('/{code}/{id}/edit', \Jiny\Site\Http\Controllers\Site\Board\EditController::class)
        ->name('edit')
        ->where('id', '[0-9]+');

    Route::put('/{code}/{id}', \Jiny\Site\Http\Controllers\Site\Board\UpdateController::class)
        ->name('update')
        ->where('id', '[0-9]+');

    // 글 삭제
    Route::delete('/{code}/{id}', \Jiny\Site\Http\Controllers\Site\Board\DestroyController::class)
        ->name('destroy')
        ->where('id', '[0-9]+');

    // 코멘트 저장
    Route::post('/{code}/{id}/comment', \Jiny\Site\Http\Controllers\Site\Board\StoreCommentController::class)
        ->name('comment.store')
        ->where('id', '[0-9]+');

    // 코멘트 수정
    Route::put('/{code}/{id}/comment/{commentId}', \Jiny\Site\Http\Controllers\Site\Board\UpdateCommentController::class)
        ->name('comment.update')
        ->where(['id' => '[0-9]+', 'commentId' => '[0-9]+']);

    // 코멘트 삭제
    Route::delete('/{code}/{id}/comment/{commentId}', \Jiny\Site\Http\Controllers\Site\Board\DestroyCommentController::class)
        ->name('comment.destroy')
        ->where(['id' => '[0-9]+', 'commentId' => '[0-9]+']);

    // 게시글 평가 (좋아요/별점)
    Route::post('/{code}/{id}/rating', \Jiny\Site\Http\Controllers\Site\Board\StoreRatingController::class)
        ->name('rating.store')
        ->where('id', '[0-9]+');

    // UUID 기반 라우트 (샤딩 환경 지원)
    Route::prefix('uuid')->name('uuid.')->group(function () {
        // UUID로 게시글 상세보기
        Route::get('/{code}/{uuid}', \Jiny\Site\Http\Controllers\Site\Board\ShowController::class)
            ->name('show')
            ->where('uuid', '[0-9a-f-]{36}');

        // UUID로 글 수정
        Route::get('/{code}/{uuid}/edit', \Jiny\Site\Http\Controllers\Site\Board\EditController::class)
            ->name('edit')
            ->where('uuid', '[0-9a-f-]{36}');

        Route::put('/{code}/{uuid}', \Jiny\Site\Http\Controllers\Site\Board\UpdateController::class)
            ->name('update')
            ->where('uuid', '[0-9a-f-]{36}');

        // UUID로 글 삭제
        Route::delete('/{code}/{uuid}', \Jiny\Site\Http\Controllers\Site\Board\DestroyController::class)
            ->name('destroy')
            ->where('uuid', '[0-9a-f-]{36}');
    });
});
