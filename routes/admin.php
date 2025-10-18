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
 * About (회사 소개) 관리 라우트
 *
 * @description
 * 회사 소개 관련 콘텐츠를 관리하는 라우트입니다.
 * 회사 연혁, 소개 등의 기능을 제공합니다.
 */
Route::prefix('admin/cms/about')->middleware(['web', 'admin'])->name('admin.cms.about.')->group(function () {
    // 회사 연혁 관리
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\About\History\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Site\Http\Controllers\Admin\About\History\CreateController::class)->name('create');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\About\History\StoreController::class)->name('store');
        Route::get('/{id}', \Jiny\Site\Http\Controllers\Admin\About\History\ShowController::class)->name('show')->where('id', '[0-9]+');
        Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\About\History\EditController::class)->name('edit')->where('id', '[0-9]+');
        Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\About\History\UpdateController::class)->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\About\History\DestroyController::class)->name('destroy')->where('id', '[0-9]+');
        Route::post('/{id}/toggle', \Jiny\Site\Http\Controllers\Admin\About\History\ToggleController::class)->name('toggle')->where('id', '[0-9]+');
    });

    // 위치 정보 관리
    Route::prefix('location')->name('location.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\About\Location\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Site\Http\Controllers\Admin\About\Location\CreateController::class)->name('create');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\About\Location\StoreController::class)->name('store');
        Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\About\Location\EditController::class)->name('edit')->where('id', '[0-9]+');
        Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\About\Location\UpdateController::class)->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\About\Location\DestroyController::class)->name('destroy')->where('id', '[0-9]+');
        Route::post('/update-order', \Jiny\Site\Http\Controllers\Admin\About\Location\UpdateOrderController::class)->name('updateOrder');
    });

    // 조직 정보 관리
    Route::prefix('organization')->name('organization.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\About\Organization\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Site\Http\Controllers\Admin\About\Organization\CreateController::class)->name('create');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\About\Organization\StoreController::class)->name('store');
        Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\About\Organization\EditController::class)->name('edit')->where('id', '[0-9]+');
        Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\About\Organization\UpdateController::class)->name('update')->where('id', '[0-9]+');
        Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\About\Organization\DestroyController::class)->name('destroy')->where('id', '[0-9]+');
        Route::post('/update-order', \Jiny\Site\Http\Controllers\Admin\About\Organization\UpdateOrderController::class)->name('update-order');

        // 조직 팀원 관리
        Route::prefix('{organization_id}/members')->name('members.')->group(function () {
            Route::get('/', \Jiny\Site\Http\Controllers\Admin\About\Organization\Members\IndexController::class)->name('index')->where('organization_id', '[0-9]+');
            Route::get('/create', \Jiny\Site\Http\Controllers\Admin\About\Organization\Members\CreateController::class)->name('create')->where('organization_id', '[0-9]+');
            Route::post('/', \Jiny\Site\Http\Controllers\Admin\About\Organization\Members\StoreController::class)->name('store')->where('organization_id', '[0-9]+');
            Route::get('/{id}', \Jiny\Site\Http\Controllers\Admin\About\Organization\Members\ShowController::class)->name('show')->where(['organization_id' => '[0-9]+', 'id' => '[0-9]+']);
            Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\About\Organization\Members\EditController::class)->name('edit')->where(['organization_id' => '[0-9]+', 'id' => '[0-9]+']);
            Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\About\Organization\Members\UpdateController::class)->name('update')->where(['organization_id' => '[0-9]+', 'id' => '[0-9]+']);
            Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\About\Organization\Members\DestroyController::class)->name('destroy')->where(['organization_id' => '[0-9]+', 'id' => '[0-9]+']);
            Route::post('/{id}/toggle', \Jiny\Site\Http\Controllers\Admin\About\Organization\Members\ToggleController::class)->name('toggle')->where(['organization_id' => '[0-9]+', 'id' => '[0-9]+']);
            Route::post('/bulk-action', \Jiny\Site\Http\Controllers\Admin\About\Organization\Members\BulkActionController::class)->name('bulkAction')->where('organization_id', '[0-9]+');
        });
    });
});






/**
 * Contact (문의) 관리 라우트
 *
 * @description
 * 고객 문의 내역을 관리하는 라우트입니다.
 * Single Action Controllers 방식으로 구현됨
 */
Route::prefix('admin/cms/contact')->name('admin.cms.contact.')->middleware(['web', 'admin'])->group(function () {
    // 기본 라우트 - 상담 목록
    Route::get('/', [\Jiny\Site\Http\Controllers\Admin\Contact\ContactController::class, 'index'])->name('index');

    // Contact Type 관리 (Single Action Controllers) - 먼저 정의
    Route::prefix('types')->name('types.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\Contact\ContactType\IndexController::class)->name('index');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\Contact\ContactType\StoreController::class)->name('store');
        Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\Contact\ContactType\UpdateController::class)->name('update');
        Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\Contact\ContactType\DestroyController::class)->name('destroy');
        Route::post('/{id}/toggle', \Jiny\Site\Http\Controllers\Admin\Contact\ContactType\ToggleController::class)->name('toggle');
        Route::post('/update-order', \Jiny\Site\Http\Controllers\Admin\Contact\ContactType\UpdateOrderController::class)->name('updateOrder');
        Route::post('/bulk-action', \Jiny\Site\Http\Controllers\Admin\Contact\ContactType\BulkActionController::class)->name('bulkAction');
    });

    // 일반 상담 라우트 (나중에 정의)
    Route::get('/{id}', [\Jiny\Site\Http\Controllers\Admin\Contact\ContactController::class, 'show'])->name('show');
    Route::post('/{id}/status', [\Jiny\Site\Http\Controllers\Admin\Contact\ContactController::class, 'updateStatus'])->name('status');
    Route::post('/{id}/assign', [\Jiny\Site\Http\Controllers\Admin\Contact\ContactController::class, 'assign'])->name('assign');
    Route::post('/{id}/comment', [\Jiny\Site\Http\Controllers\Admin\Contact\ContactController::class, 'addComment'])->name('comment');
    Route::post('/bulk', [\Jiny\Site\Http\Controllers\Admin\Contact\ContactController::class, 'bulk'])->name('bulk');
    Route::delete('/{id}', [\Jiny\Site\Http\Controllers\Admin\Contact\ContactController::class, 'destroy'])->name('destroy');
});

/**
 * Cart (장바구니) 관리 라우트
 *
 * @description
 * 고객 장바구니 내역을 관리하는 라우트입니다.
 * Single Action Controllers 방식으로 구현됨
 */
Route::prefix('admin/cms/cart')->name('admin.cms.cart.')->middleware(['web', 'admin'])->group(function () {
    // 장바구니 목록
    Route::get('/', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Cart\IndexController::class)->name('index');

    // 장바구니 아이템 삭제
    Route::delete('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Cart\DestroyController::class)->name('destroy')->where(['id' => '[0-9]+']);

    // 일괄 작업 (대량 삭제 등)
    Route::post('/bulk-action', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Cart\BulkActionController::class)->name('bulkAction');

    // 장바구니 통계 (AJAX) - 추후 구현 예정
    // Route::get('/stats', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Cart\StatsController::class)->name('stats');
});

// Sliders 관리
Route::prefix('admin/site/sliders')->name('admin.site.sliders.')->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Sliders\IndexController::class)->name('index');
    Route::get('/create', function () { return redirect()->route('admin.site.sliders.index'); })->name('create');
    Route::get('/{id}/edit', function ($id) { return redirect()->route('admin.site.sliders.index'); })->name('edit');
});

/**
 * Banner (베너) 관리 라우트
 *
 * @description
 * 사이트 상단에 표시되는 알림 베너를 관리하는 라우트입니다.
 * Single Action Controllers 방식으로 구현됨
 */
Route::prefix('admin/site/banner')->name('admin.site.banner.')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Banners\IndexController::class)->name('index');
    Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Banners\CreateController::class)->name('create');
    Route::post('/', \Jiny\Site\Http\Controllers\Admin\Banners\StoreController::class)->name('store');
    Route::get('/{id}', \Jiny\Site\Http\Controllers\Admin\Banners\ShowController::class)->name('show');
    Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\Banners\EditController::class)->name('edit');
    Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\Banners\UpdateController::class)->name('update');
    Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\Banners\DestroyController::class)->name('destroy');

    // AJAX 기능들
    Route::post('/{id}/toggle', \Jiny\Site\Http\Controllers\Admin\Banners\ToggleController::class)->name('toggle');
    Route::post('/bulk-action', \Jiny\Site\Http\Controllers\Admin\Banners\BulkActionController::class)->name('bulkAction');
    Route::post('/update-order', \Jiny\Site\Http\Controllers\Admin\Banners\UpdateOrderController::class)->name('updateOrder');
});

/**
 * Event (이벤트) 관리 라우트
 *
 * @description
 * 사이트 이벤트를 관리하는 라우트입니다.
 * Single Action Controllers 방식으로 구현됨
 */
Route::prefix('admin/site/event')->name('admin.site.event.')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Events\IndexController::class)->name('index');
    Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Events\CreateController::class)->name('create');
    Route::post('/', \Jiny\Site\Http\Controllers\Admin\Events\StoreController::class)->name('store');
    Route::get('/{id}', \Jiny\Site\Http\Controllers\Admin\Events\ShowController::class)->name('show');
    Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\Events\EditController::class)->name('edit');
    Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\Events\UpdateController::class)->name('update');
    Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\Events\DeleteController::class)->name('destroy');

    // AJAX 기능들
    Route::patch('/{id}/toggle', \Jiny\Site\Http\Controllers\Admin\Events\ToggleController::class)->name('toggle');
    Route::post('/bulk', \Jiny\Site\Http\Controllers\Admin\Events\BulkActionController::class)->name('bulkAction');

    // 참여자 관리 라우트
    Route::prefix('{id}/participants')->name('participants.')->group(function () {
        Route::get('/', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'index'])->name('index');
        Route::get('/create', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'create'])->name('create');
        Route::post('/', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'store'])->name('store');
        Route::get('/{participantId}', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'show'])->name('show');
        Route::get('/{participantId}/edit', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'edit'])->name('edit');
        Route::put('/{participantId}', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'update'])->name('update');
        Route::delete('/{participantId}', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'destroy'])->name('destroy');

        // AJAX 상태 변경 API
        Route::patch('/{participantId}/approve', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'approve'])->name('approve');
        Route::patch('/{participantId}/reject', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'reject'])->name('reject');
        Route::patch('/{participantId}/cancel', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'cancel'])->name('cancel');

        // 대량 작업 API
        Route::post('/bulk', [\Jiny\Site\Http\Controllers\Admin\Events\ParticipantsController::class, 'bulk'])->name('bulk');
    });
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
Route::get('/admin/site/log', [\Jiny\Site\Http\Controllers\Admin\Log\IndexController::class, 'index'])
    ->middleware(['web', 'admin'])->name('admin.site.log.index');

/**
 * Language (언어) 관리 라우트
 *
 * @description
 * 사이트에서 제공 가능한 언어 목록을 관리하는 라우트입니다.
 * Single Action Controllers 방식으로 구현됨
 */
Route::prefix('admin/cms/language')->name('admin.cms.language.')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Languages\IndexController::class)->name('index');
    Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Languages\CreateController::class)->name('create');
    Route::post('/', \Jiny\Site\Http\Controllers\Admin\Languages\StoreController::class)->name('store');
    Route::get('/{id}', \Jiny\Site\Http\Controllers\Admin\Languages\ShowController::class)->name('show');
    Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\Languages\EditController::class)->name('edit');
    Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\Languages\UpdateController::class)->name('update');
    Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\Languages\DeleteController::class)->name('destroy');

    // AJAX 기능들
    Route::post('/{id}/toggle', \Jiny\Site\Http\Controllers\Admin\Languages\ToggleController::class)->name('toggle');
    Route::post('/{id}/set-default', \Jiny\Site\Http\Controllers\Admin\Languages\SetDefaultController::class)->name('setDefault');
    Route::post('/bulk-action', \Jiny\Site\Http\Controllers\Admin\Languages\BulkActionController::class)->name('bulkAction');
    Route::post('/update-order', \Jiny\Site\Http\Controllers\Admin\Languages\UpdateOrderController::class)->name('updateOrder');
});

/**
 * Country (국가) 관리 라우트
 *
 * @description
 * 사이트에서 제공 가능한 국가 목록을 관리하는 라우트입니다.
 * Single Action Controllers 방식으로 구현됨
 */
Route::prefix('admin/cms/country')->name('admin.cms.country.')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Countries\IndexController::class)->name('index');
    Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Countries\CreateController::class)->name('create');
    Route::post('/', \Jiny\Site\Http\Controllers\Admin\Countries\StoreController::class)->name('store');
    Route::get('/{id}', \Jiny\Site\Http\Controllers\Admin\Countries\ShowController::class)->name('show');
    Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\Countries\EditController::class)->name('edit');
    Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\Countries\UpdateController::class)->name('update');
    Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\Countries\DeleteController::class)->name('destroy');

    // AJAX 기능들
    Route::post('/{id}/toggle', \Jiny\Site\Http\Controllers\Admin\Countries\ToggleController::class)->name('toggle');
    Route::post('/{id}/set-default', \Jiny\Site\Http\Controllers\Admin\Countries\SetDefaultController::class)->name('setDefault');
    Route::post('/bulk-action', \Jiny\Site\Http\Controllers\Admin\Countries\BulkActionController::class)->name('bulkAction');
    Route::post('/update-order', \Jiny\Site\Http\Controllers\Admin\Countries\UpdateOrderController::class)->name('updateOrder');
});

/**
 * Currencies (통화) 관리 라우트
 *
 * @description
 * 다중 통화 시스템을 관리하는 라우트입니다.
 */
Route::prefix('admin/cms/currencies')->name('admin.cms.currencies.')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Currencies\IndexController::class)->name('index');
});

/**
 * Exchange Rates (환율) 관리 라우트
 *
 * @description
 * 실시간 환율 정보를 관리하는 라우트입니다.
 */
Route::prefix('admin/cms/exchange-rates')->name('admin.cms.exchange-rates.')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\ExchangeRates\IndexController::class)->name('index');
    Route::post('/update', [\Jiny\Site\Http\Controllers\Admin\ExchangeRates\IndexController::class, 'updateRates'])->name('update');
    Route::post('/check-expired', [\Jiny\Site\Http\Controllers\Admin\ExchangeRates\IndexController::class, 'checkExpired'])->name('checkExpired');
});

/**
 * Tax (세율) 관리 라우트 - TEMPORARILY DISABLED
 *
 * @description
 * 국가별 세율 정보를 관리하는 라우트입니다.
 */
// Route::prefix('admin/cms/tax')->name('admin.cms.tax.')->middleware(['web', 'admin'])->group(function () {
//     Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Tax\IndexController::class)->name('index');
//     Route::post('/{id}/update', [\Jiny\Site\Http\Controllers\Ecommerce\Tax\IndexController::class, 'updateTaxRate'])->name('update')->where(['id' => '[0-9]+']);
//     Route::post('/bulk-update', [\Jiny\Site\Http\Controllers\Ecommerce\Tax\IndexController::class, 'bulkUpdateTaxRate'])->name('bulkUpdate');
// });

/**
 * Ecommerce (이커머스) 관리 라우트 - TEMPORARILY DISABLED
 *
 * @description
 * 이커머스 시스템 전체를 관리하는 라우트입니다.
 * Single Action Controllers 방식으로 구현됨
 */
// Route::prefix('admin/cms/ecommerce')->name('admin.cms.ecommerce.')->middleware(['web', 'admin'])->group(function () {
//     // 이커머스 대시보드
//     Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Dashboard\IndexController::class)->name('dashboard');

//     // 주문 관리
//     Route::prefix('orders')->name('orders.')->group(function () {
//         Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Orders\IndexController::class)->name('index');
//         Route::get('/create', \Jiny\Site\Http\Controllers\Ecommerce\Orders\CreateController::class)->name('create');
//         Route::post('/', \Jiny\Site\Http\Controllers\Ecommerce\Orders\StoreController::class)->name('store');
//         Route::get('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Orders\ShowController::class)->name('show')->where('id', '[0-9]+');
//         Route::post('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Orders\ShowController::class)->name('update_status')->where('id', '[0-9]+');

//         // 단계별 주문 생성
//         Route::get('/step/{step?}', \Jiny\Site\Http\Controllers\Ecommerce\Orders\StepController::class)->name('step')->where('step', '[1-4]');
//         Route::post('/step/{step}', \Jiny\Site\Http\Controllers\Ecommerce\Orders\StepController::class)->name('step.submit')->where('step', '[1-4]');
//         Route::get('/reset', [\Jiny\Site\Http\Controllers\Ecommerce\Orders\StepController::class, 'reset'])->name('reset');
//     });

//     // 프로모션 관리
//     Route::prefix('promotions')->name('promotions.')->group(function () {
//         Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Promotions\IndexController::class)->name('index');
//         Route::get('/create', \Jiny\Site\Http\Controllers\Ecommerce\Promotions\CreateController::class)->name('create');
//         Route::post('/', \Jiny\Site\Http\Controllers\Ecommerce\Promotions\StoreController::class)->name('store');
//         Route::get('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Promotions\ShowController::class)->name('show')->where('id', '[0-9]+');
//         Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Ecommerce\Promotions\EditController::class)->name('edit')->where('id', '[0-9]+');
//         Route::put('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Promotions\UpdateController::class)->name('update')->where('id', '[0-9]+');
//         Route::delete('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Promotions\DestroyController::class)->name('destroy')->where('id', '[0-9]+');
//     });

//     // 쿠폰 관리
//     Route::prefix('coupons')->name('coupons.')->group(function () {
//         Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Coupons\IndexController::class)->name('index');
//         Route::get('/create', \Jiny\Site\Http\Controllers\Ecommerce\Coupons\CreateController::class)->name('create');
//         Route::post('/', \Jiny\Site\Http\Controllers\Ecommerce\Coupons\StoreController::class)->name('store');
//         Route::get('/{coupon}', \Jiny\Site\Http\Controllers\Ecommerce\Coupons\ShowController::class)->name('show')->where('coupon', '[0-9]+');
//         Route::get('/{coupon}/edit', \Jiny\Site\Http\Controllers\Ecommerce\Coupons\EditController::class)->name('edit')->where('coupon', '[0-9]+');
//         Route::put('/{coupon}', \Jiny\Site\Http\Controllers\Ecommerce\Coupons\UpdateController::class)->name('update')->where('coupon', '[0-9]+');
//         Route::delete('/{coupon}', \Jiny\Site\Http\Controllers\Ecommerce\Coupons\DestroyController::class)->name('destroy')->where('coupon', '[0-9]+');
//     });

//     // 재고 관리
//     Route::prefix('inventory')->name('inventory.')->group(function () {
//         // 재고 대시보드 (누락된 라우트 추가)
//         Route::get('/dashboard', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\IndexController::class)->name('dashboard');

//         // 재고 입고 관리
//         Route::get('/stock-in', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\StockInController::class)->name('stock-in');
//         Route::post('/stock-in/process', [\Jiny\Site\Http\Controllers\Ecommerce\Inventory\StockInController::class, 'process'])->name('stock-in.process');

//         // 재고 출고 관리
//         Route::get('/stock-out', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\StockOutController::class)->name('stock-out');
//         Route::post('/stock-out/process', [\Jiny\Site\Http\Controllers\Ecommerce\Inventory\StockOutController::class, 'process'])->name('stock-out.process');

//         // 재고 알림 관리
//         Route::get('/alerts', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\AlertsController::class)->name('alerts');
//         Route::post('/alerts/update-threshold', [\Jiny\Site\Http\Controllers\Ecommerce\Inventory\AlertsController::class, 'updateThreshold'])->name('alerts.update-threshold');
//         Route::post('/alerts/update-settings', [\Jiny\Site\Http\Controllers\Ecommerce\Inventory\AlertsController::class, 'updateSettings'])->name('alerts.update-settings');

//         // 재고 CRUD
//         Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\IndexController::class)->name('index');
//         Route::get('/create', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\CreateController::class)->name('create');
//         Route::post('/', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\StoreController::class)->name('store');
//         Route::get('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\ShowController::class)->name('show')->where(['id' => '[0-9]+']);
//         Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\EditController::class)->name('edit')->where(['id' => '[0-9]+']);
//         Route::put('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\UpdateController::class)->name('update')->where(['id' => '[0-9]+']);
//         Route::delete('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\DestroyController::class)->name('destroy')->where(['id' => '[0-9]+']);
//     });

//     // 이벤트 관리
//     Route::prefix('events')->name('events.')->group(function () {
//         Route::get('/', function() {
//             return view('jiny-site::admin.ecommerce.events.index');
//         })->name('index');
//     });

//     // 배송 관리
//     Route::prefix('shipping')->name('shipping.')->group(function () {
//         // 배송 대시보드
//         Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Shipping\IndexController::class)->name('index');

//         // 배송 지역 관리
//         Route::prefix('zones')->name('zones.')->group(function () {
//             Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Shipping\Zones\IndexController::class)->name('index');
//             Route::get('/create', \Jiny\Site\Http\Controllers\Ecommerce\Shipping\Zones\CreateController::class)->name('create');
//         });

//         // 배송 방식 관리
//         Route::prefix('methods')->name('methods.')->group(function () {
//             Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Shipping\Methods\IndexController::class)->name('index');
//         });

//         // 배송 요금 관리
//         Route::prefix('rates')->name('rates.')->group(function () {
//             Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Shipping\Rates\IndexController::class)->name('index');
//         });

//         // 배송비 계산기
//         Route::prefix('calculator')->name('calculator.')->group(function () {
//             Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Shipping\Calculator\IndexController::class)->name('index');
//             Route::post('/', \Jiny\Site\Http\Controllers\Ecommerce\Shipping\Calculator\IndexController::class)->name('calculate');
//         });
//     });

//     // 이커머스 설정
//     Route::prefix('settings')->name('settings.')->group(function () {
//         Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Settings\IndexController::class)->name('index');
//     });
// });

/**
 * Templates 관리 라우트
 *
 * @description
 * 사이트 템플릿 컴포넌트를 관리하는 라우트입니다.
 * Layout, Header, Footer, Sidebar, Nav 관리 기능을 제공합니다.
 * Single Action Controllers 방식으로 구현됨
 */
Route::prefix('admin/cms/templates')->name('admin.cms.templates.')->middleware(['web', 'admin'])->group(function () {
    // Layout 관리
    Route::prefix('layout')->name('layout.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\Templates\Layout\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Templates\Layout\CreateController::class)->name('create');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\Templates\Layout\StoreController::class)->name('store');
        Route::get('/{layout}', \Jiny\Site\Http\Controllers\Admin\Templates\Layout\ShowController::class)->name('show');
        Route::get('/{layout}/edit', \Jiny\Site\Http\Controllers\Admin\Templates\Layout\EditController::class)->name('edit');
        Route::put('/{layout}', \Jiny\Site\Http\Controllers\Admin\Templates\Layout\UpdateController::class)->name('update');
        Route::delete('/{layout}', \Jiny\Site\Http\Controllers\Admin\Templates\Layout\DestroyController::class)->name('destroy');
        Route::post('/bulk-action', \Jiny\Site\Http\Controllers\Admin\Templates\Layout\BulkActionController::class)->name('bulkAction');
        Route::post('/update-order', \Jiny\Site\Http\Controllers\Admin\Templates\Layout\UpdateOrderController::class)->name('updateOrder');
    });

    // Header 관리
    Route::prefix('header')->name('header.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\Templates\Header\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Templates\Header\CreateController::class)->name('create');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\Templates\Header\StoreController::class)->name('store');

        // Header 설정 관리 (구체적인 라우트를 먼저 정의)
        Route::get('/config', [\Jiny\Site\Http\Controllers\Admin\Templates\Header\ConfigController::class, 'index'])->name('config');
        Route::post('/config/basic', [\Jiny\Site\Http\Controllers\Admin\Templates\Header\ConfigController::class, 'updateBasic'])->name('config.basic');
        Route::post('/config/navigation', [\Jiny\Site\Http\Controllers\Admin\Templates\Header\ConfigController::class, 'updateNavigation'])->name('config.navigation');
        Route::post('/config/settings', [\Jiny\Site\Http\Controllers\Admin\Templates\Header\ConfigController::class, 'updateSettings'])->name('config.settings');

        // JSON 직접 편집
        Route::get('/config/edit-json', [\Jiny\Site\Http\Controllers\Admin\Templates\Header\ConfigController::class, 'editJson'])->name('config.edit-json');
        Route::get('/config/current-json', [\Jiny\Site\Http\Controllers\Admin\Templates\Header\ConfigController::class, 'getCurrentJson'])->name('config.current-json');
        Route::post('/config/update-json', [\Jiny\Site\Http\Controllers\Admin\Templates\Header\ConfigController::class, 'updateJson'])->name('config.update-json');
        Route::post('/config/validate-json', [\Jiny\Site\Http\Controllers\Admin\Templates\Header\ConfigController::class, 'validateJson'])->name('config.validate-json');

        // 동적 라우트 (가장 마지막에 정의)
        Route::get('/{header}', \Jiny\Site\Http\Controllers\Admin\Templates\Header\ShowController::class)->name('show');
        Route::get('/{header}/edit', \Jiny\Site\Http\Controllers\Admin\Templates\Header\EditController::class)->name('edit');
        Route::put('/{header}', \Jiny\Site\Http\Controllers\Admin\Templates\Header\UpdateController::class)->name('update');
        Route::delete('/{header}', \Jiny\Site\Http\Controllers\Admin\Templates\Header\DestroyController::class)->name('destroy');
    });

    // Footer 관리
    Route::prefix('footer')->name('footer.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\Templates\Footer\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Templates\Footer\CreateController::class)->name('create');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\Templates\Footer\StoreController::class)->name('store');

        // Footer 설정 관리 (구체적인 라우트를 먼저 정의)
        Route::get('/config', [\Jiny\Site\Http\Controllers\Admin\Templates\Footer\ConfigController::class, 'index'])->name('config');
        Route::post('/config/basic', [\Jiny\Site\Http\Controllers\Admin\Templates\Footer\ConfigController::class, 'updateBasic'])->name('config.basic');
        Route::post('/config/company', [\Jiny\Site\Http\Controllers\Admin\Templates\Footer\ConfigController::class, 'updateCompany'])->name('config.company');
        Route::post('/config/social', [\Jiny\Site\Http\Controllers\Admin\Templates\Footer\ConfigController::class, 'updateSocial'])->name('config.social');
        Route::post('/config/menu-sections', [\Jiny\Site\Http\Controllers\Admin\Templates\Footer\ConfigController::class, 'updateMenuSections'])->name('config.menu-sections');

        // JSON 직접 편집
        Route::get('/config/edit-json', [\Jiny\Site\Http\Controllers\Admin\Templates\Footer\ConfigController::class, 'editJson'])->name('config.edit-json');
        Route::get('/config/current-json', [\Jiny\Site\Http\Controllers\Admin\Templates\Footer\ConfigController::class, 'getCurrentJson'])->name('config.current-json');
        Route::post('/config/update-json', [\Jiny\Site\Http\Controllers\Admin\Templates\Footer\ConfigController::class, 'updateJson'])->name('config.update-json');
        Route::post('/config/validate-json', [\Jiny\Site\Http\Controllers\Admin\Templates\Footer\ConfigController::class, 'validateJson'])->name('config.validate-json');

        // 동적 라우트 (가장 마지막에 정의)
        Route::get('/{footer}', \Jiny\Site\Http\Controllers\Admin\Templates\Footer\ShowController::class)->name('show');
        Route::get('/{footer}/edit', \Jiny\Site\Http\Controllers\Admin\Templates\Footer\EditController::class)->name('edit');
        Route::put('/{footer}', \Jiny\Site\Http\Controllers\Admin\Templates\Footer\UpdateController::class)->name('update');
        Route::delete('/{footer}', \Jiny\Site\Http\Controllers\Admin\Templates\Footer\DestroyController::class)->name('destroy');
    });

    // Sidebar 관리
    Route::prefix('sidebar')->name('sidebar.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\Templates\Sidebar\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Templates\Sidebar\CreateController::class)->name('create');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\Templates\Sidebar\StoreController::class)->name('store');
        Route::get('/{sidebar}', \Jiny\Site\Http\Controllers\Admin\Templates\Sidebar\ShowController::class)->name('show');
        Route::get('/{sidebar}/edit', \Jiny\Site\Http\Controllers\Admin\Templates\Sidebar\EditController::class)->name('edit');
        Route::put('/{sidebar}', \Jiny\Site\Http\Controllers\Admin\Templates\Sidebar\UpdateController::class)->name('update');
        Route::delete('/{sidebar}', \Jiny\Site\Http\Controllers\Admin\Templates\Sidebar\DestroyController::class)->name('destroy');
    });

    // Navigation 관리
    Route::prefix('nav')->name('nav.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\Templates\Nav\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Templates\Nav\CreateController::class)->name('create');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\Templates\Nav\StoreController::class)->name('store');
        Route::get('/{nav}', \Jiny\Site\Http\Controllers\Admin\Templates\Nav\ShowController::class)->name('show');
        Route::get('/{nav}/edit', \Jiny\Site\Http\Controllers\Admin\Templates\Nav\EditController::class)->name('edit');
        Route::put('/{nav}', \Jiny\Site\Http\Controllers\Admin\Templates\Nav\UpdateController::class)->name('update');
        Route::delete('/{nav}', \Jiny\Site\Http\Controllers\Admin\Templates\Nav\DestroyController::class)->name('destroy');
    });
});

/**
 * Pages (정적 페이지) 관리 라우트
 *
 * @description
 * 사이트의 정적 페이지를 관리하는 라우트입니다.
 * Single Action Controllers 방식으로 구현됨
 */
Route::prefix('admin/cms/pages')->name('admin.cms.pages.')->middleware(['web', 'admin'])->group(function () {
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Pages\IndexController::class)->name('index');
    Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Pages\CreateController::class)->name('create');
    Route::post('/', \Jiny\Site\Http\Controllers\Admin\Pages\StoreController::class)->name('store');
    Route::get('/{id}', \Jiny\Site\Http\Controllers\Admin\Pages\ShowController::class)->name('show');
    Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\Pages\EditController::class)->name('edit');
    Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\Pages\UpdateController::class)->name('update');
    Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\Pages\DestroyController::class)->name('destroy');
    Route::post('/bulk-action', \Jiny\Site\Http\Controllers\Admin\Pages\BulkActionController::class)->name('bulkAction');
    Route::post('/update-order', \Jiny\Site\Http\Controllers\Admin\Pages\UpdateOrderController::class)->name('updateOrder');

    // 페이지 블럭 관리
    Route::prefix('{pageId}/content')->name('content.')->group(function () {
        Route::get('/', \Jiny\Site\Http\Controllers\Admin\PageContent\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Site\Http\Controllers\Admin\PageContent\CreateController::class)->name('create');
        Route::post('/', \Jiny\Site\Http\Controllers\Admin\PageContent\StoreController::class)->name('store');
        Route::get('/{contentId}', \Jiny\Site\Http\Controllers\Admin\PageContent\ShowController::class)->name('show');
        Route::get('/{contentId}/edit', \Jiny\Site\Http\Controllers\Admin\PageContent\EditController::class)->name('edit');
        Route::put('/{contentId}', \Jiny\Site\Http\Controllers\Admin\PageContent\UpdateController::class)->name('update');
        Route::delete('/{contentId}', \Jiny\Site\Http\Controllers\Admin\PageContent\DestroyController::class)->name('destroy');
        Route::post('/update-order', \Jiny\Site\Http\Controllers\Admin\PageContent\UpdateOrderController::class)->name('updateOrder');
    });
});



/**
 * Products 관리 라우트
 *
 * @description
 * 상품 관리 시스템을 위한 라우트입니다.
 * 상품 CRUD 기능을 제공합니다.
 */
Route::prefix('admin/site/products')->middleware(['web', 'admin'])->name('admin.site.products.')->group(function () {
    Route::get('/', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\IndexController::class)->name('index');
    Route::get('/create', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\CreateController::class)->name('create');
    Route::post('/', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\StoreController::class)->name('store');
    Route::get('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\ShowController::class)->name('show')->where(['id' => '[0-9]+']);
    Route::get('/{id}/edit', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\EditController::class)->name('edit')->where(['id' => '[0-9]+']);
    Route::put('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\UpdateController::class)->name('update')->where(['id' => '[0-9]+']);
    Route::delete('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\DestroyController::class)->name('destroy')->where(['id' => '[0-9]+']);

    // Product Categories 관리
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Categories\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Categories\CreateController::class)->name('create');
        Route::post('/', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Categories\StoreController::class)->name('store');
        Route::get('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Categories\ShowController::class)->name('show')->where(['id' => '[0-9]+']);
        Route::get('/{id}/edit', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Categories\EditController::class)->name('edit')->where(['id' => '[0-9]+']);
        Route::put('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Categories\UpdateController::class)->name('update')->where(['id' => '[0-9]+']);
        Route::delete('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Categories\DestroyController::class)->name('destroy')->where(['id' => '[0-9]+']);
    });

    // Product Images 관리
    Route::prefix('{productId}/images')->name('images.')->where(['productId' => '[0-9]+'])->group(function () {
        Route::get('/', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Images\IndexController::class)->name('index');
        Route::post('/', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Images\StoreController::class)->name('store');
        Route::get('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Images\ShowController::class)->name('show')->where(['id' => '[0-9]+']);
        Route::put('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Images\UpdateController::class)->name('update')->where(['id' => '[0-9]+']);
        Route::delete('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Images\DestroyController::class)->name('destroy')->where(['id' => '[0-9]+']);
        Route::post('/reorder', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Images\ReorderController::class)->name('reorder');
        Route::post('/{id}/toggle-featured', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Images\ToggleFeaturedController::class)->name('toggle-featured')->where(['id' => '[0-9]+']);
        Route::post('/{id}/toggle-enable', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Images\ToggleEnableController::class)->name('toggle-enable')->where(['id' => '[0-9]+']);
    });

    // Product Pricing 관리
    Route::prefix('{productId}/pricing')->name('pricing.')->where(['productId' => '[0-9]+'])->group(function () {
        Route::get('/', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Pricing\IndexController::class)->name('index');
        Route::get('/create', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Pricing\CreateController::class)->name('create');
        Route::post('/', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Pricing\StoreController::class)->name('store');
        Route::get('/{id}/edit', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Pricing\EditController::class)->name('edit')->where(['id' => '[0-9]+']);
        Route::put('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Pricing\UpdateController::class)->name('update')->where(['id' => '[0-9]+']);
        Route::delete('/{id}', \Jiny\Store\Http\Controllers\Admin\Ecommerce\Products\Pricing\DestroyController::class)->name('destroy')->where(['id' => '[0-9]+']);
    });
});


/**
 * Testimonials 관리 라우트
 *
 * @description
 * 고객 후기와 평가 관리 시스템을 위한 라우트입니다.
 * Products와 Services에 대한 Testimonials CRUD 기능을 제공합니다.
 */
Route::prefix('admin/site/testimonials')->middleware(['web', 'admin'])->name('admin.site.testimonials.')->group(function () {
    // 전체 Testimonials 관리
    Route::get('/', \Jiny\Site\Http\Controllers\Admin\Testimonials\IndexController::class)->name('index');
    Route::get('/create', \Jiny\Site\Http\Controllers\Admin\Testimonials\CreateController::class)->name('create');
    Route::post('/', \Jiny\Site\Http\Controllers\Admin\Testimonials\StoreController::class)->name('store');
    Route::get('/{id}', \Jiny\Site\Http\Controllers\Admin\Testimonials\ShowController::class)->name('show')->where(['id' => '[0-9]+']);
    Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Admin\Testimonials\EditController::class)->name('edit')->where(['id' => '[0-9]+']);
    Route::put('/{id}', \Jiny\Site\Http\Controllers\Admin\Testimonials\UpdateController::class)->name('update')->where(['id' => '[0-9]+']);
    Route::delete('/{id}', \Jiny\Site\Http\Controllers\Admin\Testimonials\DestroyController::class)->name('destroy')->where(['id' => '[0-9]+']);

    // 특정 Product/Service용 Testimonials 관리
    Route::get('/{type}/{itemId}', \Jiny\Site\Http\Controllers\Admin\Testimonials\IndexController::class)->name('item')->where(['type' => 'product|service', 'itemId' => '[0-9]+']);
    Route::get('/{type}/{itemId}/create', \Jiny\Site\Http\Controllers\Admin\Testimonials\CreateController::class)->name('item.create')->where(['type' => 'product|service', 'itemId' => '[0-9]+']);
});

/**
 * Menu 관리 라우트
 *
 * @description
 * 사이트 메뉴 시스템을 관리하는 라우트입니다.
 * 트리 구조 메뉴 생성, 수정, 삭제 및 드래그 앤 드롭 기능을 제공합니다.
 */
Route::prefix('admin/cms/menu')->middleware(['web', 'admin'])->name('admin.cms.menu.')->group(function () {
    // 메뉴 목록
    Route::get('/', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'index'])->name('index');

    // 메뉴 관리 (생성, 수정, 삭제)
    Route::post('/create', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'createMenu'])->name('create');
    Route::put('/{menuId}', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'updateMenu'])->name('update')->where(['menuId' => '[0-9]+']);
    Route::delete('/{menuId}', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'deleteMenu'])->name('delete')->where(['menuId' => '[0-9]+']);

    // 특정 메뉴 보기 및 메뉴 아이템 관리
    Route::get('/{menuId}', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'show'])->name('show')->where(['menuId' => '[0-9]+']);

    // 메뉴 아이템 관리
    Route::post('/item/create', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'createMenuItem'])->name('item.create');
    Route::put('/item/{itemId}', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'updateMenuItem'])->name('item.update')->where(['itemId' => '[0-9]+']);
    Route::delete('/item/{itemId}', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'deleteMenuItem'])->name('item.delete')->where(['itemId' => '[0-9]+']);

    // 드래그 앤 드롭을 위한 메뉴 구조 업데이트
    Route::post('/structure/update', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'updateMenuStructure'])->name('structure.update');

    // AJAX용 메뉴 트리 데이터
    Route::get('/{menuId}/tree', [\Jiny\Site\Http\Controllers\Admin\Menus\MenuController::class, 'getMenuTree'])->name('tree')->where(['menuId' => '[0-9]+']);
});

/**
 * Site Ecommerce Inventory 관리 라우트 - TEMPORARILY DISABLED
 *
 * @description
 * 사이트 이커머스 재고 관리 시스템을 위한 라우트입니다.
 * admin.site.ecommerce.inventory 네임스페이스로 접근 가능합니다.
 */
// Route::prefix('admin/site/ecommerce')->middleware(['web', 'admin'])->name('admin.site.ecommerce.')->group(function () {
//     // 재고 관리
//     Route::prefix('inventory')->name('inventory.')->group(function () {
//         Route::get('/', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\IndexController::class)->name('index');
//         Route::get('/create', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\CreateController::class)->name('create');
//         Route::post('/', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\StoreController::class)->name('store');
//         Route::get('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\ShowController::class)->name('show')->where(['id' => '[0-9]+']);
//         Route::get('/{id}/edit', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\EditController::class)->name('edit')->where(['id' => '[0-9]+']);
//         Route::put('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\UpdateController::class)->name('update')->where(['id' => '[0-9]+']);
//         Route::delete('/{id}', \Jiny\Site\Http\Controllers\Ecommerce\Inventory\DestroyController::class)->name('destroy')->where(['id' => '[0-9]+']);
//     });
// });

// // Admin Routes
// Route::middleware(['admin'])->group(function () {
//     // CMS Dashboard (Override vendor route)
//     Route::get('/admin/cms', [\App\Http\Controllers\Admin\Dashboard\DashboardController::class, '__invoke'])
//         ->name('admin.cms.dashboard');

//     // Site Log Management
//     Route::get('/admin/site/log', [\App\Http\Controllers\Admin\Site\SiteLogController::class, 'index'])
//         ->name('admin.site.log.index');

//     // API: Chart data for dashboard
//     Route::get('/api/admin/site/log/chart-data', [\App\Http\Controllers\Admin\Site\SiteLogController::class, 'chartData'])
//         ->name('admin.site.log.chart-data');
// });
