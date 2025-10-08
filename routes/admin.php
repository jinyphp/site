<?php

use Illuminate\Support\Facades\Route;

/**
 * CMS 대시보드 라우트
 *
 * @description
 * 콘텐츠 관리 시스템(CMS) 관련 관리 페이지 라우트입니다.
 * 게시판, 마케팅, 고객지원, 분석 등의 기능을 제공합니다.
 */
Route::get('/admin/cms', \Jiny\Site\Http\Controllers\Admin\Dashboard\DashboardController::class)
    ->name('admin.cms.dashboard');

/**
 * Contact (문의) 관리 라우트
 *
 * @description
 * 고객 문의 내역을 관리하는 라우트입니다.
 */
Route::prefix('admin/site/contact')->name('admin.site.contact.')->group(function () {
    // 목록
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Contact\IndexController::class)
        ->name('index');

    // 상세 보기 (추후 구현)
    Route::get('/{id}', function ($id) {
        return redirect()->route('admin.site.contact.index');
    })->name('show');

    // 수정 (추후 구현)
    Route::get('/{id}/edit', function ($id) {
        return redirect()->route('admin.site.contact.index');
    })->name('edit');
});

/**
 * FAQ 관리 라우트
 *
 * @description
 * 자주 묻는 질문(FAQ)을 관리하는 라우트입니다.
 */
Route::prefix('admin/site/faq')->name('admin.site.faq.')->group(function () {
    // 목록
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Faq\IndexController::class)
        ->name('index');

    // 생성 (추후 구현)
    Route::get('/create', function () {
        return redirect()->route('admin.site.faq.index');
    })->name('create');

    // 상세 보기 (추후 구현)
    Route::get('/{id}', function ($id) {
        return redirect()->route('admin.site.faq.index');
    })->name('show');

    // 수정 (추후 구현)
    Route::get('/{id}/edit', function ($id) {
        return redirect()->route('admin.site.faq.index');
    })->name('edit');
});

// Help 관리
Route::prefix('admin/site/help')->name('admin.site.help.')->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Help\IndexController::class)->name('index');
    Route::get('/create', function () { return redirect()->route('admin.site.help.index'); })->name('create');
    Route::get('/{id}/edit', function ($id) { return redirect()->route('admin.site.help.index'); })->name('edit');
});

// Sliders 관리
Route::prefix('admin/site/sliders')->name('admin.site.sliders.')->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Sliders\IndexController::class)->name('index');
    Route::get('/create', function () { return redirect()->route('admin.site.sliders.index'); })->name('create');
    Route::get('/{id}/edit', function ($id) { return redirect()->route('admin.site.sliders.index'); })->name('edit');
});

// Banner 관리
Route::prefix('admin/site/banner')->name('admin.site.banner.')->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Banners\IndexController::class)->name('index');
    Route::get('/create', function () { return redirect()->route('admin.site.banner.index'); })->name('create');
    Route::get('/{id}/edit', function ($id) { return redirect()->route('admin.site.banner.index'); })->name('edit');
});

// Event 관리
Route::prefix('admin/site/event')->name('admin.site.event.')->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Events\IndexController::class)->name('index');
    Route::get('/create', function () { return redirect()->route('admin.site.event.index'); })->name('create');
    Route::get('/{id}/edit', function ($id) { return redirect()->route('admin.site.event.index'); })->name('edit');
});

// Notification 관리
Route::prefix('admin/site/notification')->name('admin.site.notification.')->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Notifications\IndexController::class)->name('index');
    Route::get('/create', function () { return redirect()->route('admin.site.notification.index'); })->name('create');
    Route::get('/{id}/edit', function ($id) { return redirect()->route('admin.site.notification.index'); })->name('edit');
});

// SEO 분석
Route::get('/admin/site/seo', \Jiny\Site\Http\Controllers\Admin\Seo\IndexController::class)->name('admin.site.seo.index');

// Log 분석
Route::get('/admin/site/log', \Jiny\Site\Http\Controllers\Admin\Log\IndexController::class)->name('admin.site.log.index');

/**
 * Board (게시판) 관리 라우트
 *
 * @description
 * 게시판 시스템을 관리하는 라우트입니다.
 * 게시판 설정, 게시글, 관련글, 트렌드글 등을 관리합니다.
 */
Route::prefix('admin/cms/board')->name('admin.cms.board.')->group(function () {
    // 대시보드
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Board\AdminSiteBoardDashboard::class)
        ->name('dashboard');

    // 게시판 목록 - RESTful 라우트
    Route::get('/list', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoard::class, 'index'])
        ->name('list');
    Route::get('/list/create', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoard::class, 'create'])
        ->name('list.create');
    Route::post('/list', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoard::class, 'store'])
        ->name('list.store');
    Route::get('/list/{id}/edit', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoard::class, 'edit'])
        ->name('list.edit');
    Route::put('/list/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoard::class, 'update'])
        ->name('list.update');
    Route::delete('/list/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoard::class, 'destroy'])
        ->name('list.destroy');

    // 게시글 관리 - RESTful 라우트
    Route::get('/table', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTable::class, 'index'])
        ->name('table');
    Route::get('/table/create', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTable::class, 'create'])
        ->name('table.create');
    Route::post('/table', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTable::class, 'store'])
        ->name('table.store');
    Route::get('/table/{id}/edit', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTable::class, 'edit'])
        ->name('table.edit');
    Route::put('/table/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTable::class, 'update'])
        ->name('table.update');
    Route::delete('/table/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTable::class, 'destroy'])
        ->name('table.destroy');

    // 관련글 관리 - RESTful 라우트
    Route::get('/related', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardRelated::class, 'index'])
        ->name('related');
    Route::get('/related/create', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardRelated::class, 'create'])
        ->name('related.create');
    Route::post('/related', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardRelated::class, 'store'])
        ->name('related.store');
    Route::get('/related/{id}/edit', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardRelated::class, 'edit'])
        ->name('related.edit');
    Route::put('/related/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardRelated::class, 'update'])
        ->name('related.update');
    Route::delete('/related/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardRelated::class, 'destroy'])
        ->name('related.destroy');

    // 트렌드글 관리 - RESTful 라우트
    Route::get('/trend', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTrend::class, 'index'])
        ->name('trend');
    Route::get('/trend/create', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTrend::class, 'create'])
        ->name('trend.create');
    Route::post('/trend', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTrend::class, 'store'])
        ->name('trend.store');
    Route::get('/trend/{id}/edit', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTrend::class, 'edit'])
        ->name('trend.edit');
    Route::put('/trend/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTrend::class, 'update'])
        ->name('trend.update');
    Route::delete('/trend/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardTrend::class, 'destroy'])
        ->name('trend.destroy');

    // 게시판별 게시글 관리 - RESTful 라우트
    Route::get('/posts/{code}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardPost::class, 'index'])
        ->name('posts');
    Route::get('/posts/{code}/create', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardPost::class, 'create'])
        ->name('posts.create');
    Route::post('/posts/{code}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardPost::class, 'store'])
        ->name('posts.store');
    Route::get('/posts/{code}/{id}/edit', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardPost::class, 'edit'])
        ->name('posts.edit');
    Route::put('/posts/{code}/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardPost::class, 'update'])
        ->name('posts.update');
    Route::delete('/posts/{code}/{id}', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardPost::class, 'destroy'])
        ->name('posts.destroy');
    // 하위 글 작성
    Route::get('/posts/{code}/{id}/child/create', [\Jiny\Site\Http\Controllers\Admin\Board\AdminBoardPost::class, 'createChild'])
        ->name('posts.child.create');

    // 평가 테이블 마이그레이션
    Route::post('/migrate-rating-tables', \Jiny\Site\Http\Controllers\Admin\Board\MigrateRatingTableController::class)
        ->name('migrate.rating.tables');
});

