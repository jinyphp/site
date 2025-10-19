<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Http\Middleware\CheckSiteEnabled;

// 메인 welcome 페이지
Route::get('/', \Jiny\Site\Http\Controllers\Welcome\WelcomeController::class)->name('home');

// 베너 컴포넌트 데모 페이지
Route::get('/banner-demo', function () {
    try {
        $banners = \Jiny\Site\Models\Banner::active()->valid()->ordered()->get();
        return view('banner-component-demo', compact('banners'));
    } catch (\Exception $e) {
        return response("Error: " . $e->getMessage() . " | " . $e->getFile() . ":" . $e->getLine(), 500);
    }
})->name('banner.demo');

// 간단한 테스트 라우트
Route::get('/test-banner', function () {
    return response("Test route works! Banner count: " . \Jiny\Site\Models\Banner::count());
});



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

    // About 페이지 - 주석 처리하여 CMS 페이지가 사용되도록 함
    // Route::get('/about', \Jiny\Site\Http\Controllers\Site\About\IndexController::class)
    //     ->name('about');

    // About 관련 페이지
    Route::prefix('about')->name('about.')->group(function () {
        // 회사 연혁
        Route::get('/history', \Jiny\Site\Http\Controllers\Site\About\History\IndexController::class)
            ->name('history');

        // 위치 정보
        Route::get('/location', \Jiny\Site\Http\Controllers\Site\About\Location\IndexController::class)
            ->name('location');

        // 조직도
        Route::get('/organization', \Jiny\Site\Http\Controllers\Site\About\Organization\IndexController::class)
            ->name('organization');

        // 기타 about 서브페이지들을 동적으로 처리 (fallback)
        Route::get('/{subpage}', [\Jiny\Site\Http\Controllers\PageController::class, 'show'])
            ->name('subpage')
            ->where('subpage', '[a-zA-Z0-9\-_]+');
    });

    // 정적 페이지 라우트
    Route::prefix('pages')->name('pages.')->group(function () {
        // 페이지 목록
        Route::get('/', [\Jiny\Site\Http\Controllers\PageController::class, 'index'])
            ->name('index');

        // 추천 페이지 목록
        Route::get('/featured', [\Jiny\Site\Http\Controllers\PageController::class, 'featured'])
            ->name('featured');

        // 페이지 검색
        Route::get('/search', [\Jiny\Site\Http\Controllers\PageController::class, 'search'])
            ->name('search');
    });

// });

// Event (이벤트) 사용자 페이지
Route::middleware('web')->prefix('event')->name('event.')->group(function () {
    // 이벤트 목록
    Route::get('/', \Jiny\Site\Http\Controllers\Site\Event\IndexController::class)
        ->name('index');

    // 이벤트 참여 신청 폼
    Route::get('/{id}/participate', [\Jiny\Site\Http\Controllers\Site\Event\ParticipateController::class, 'show'])
        ->name('participate')
        ->where('id', '[0-9]+');

    // 이벤트 참여 신청 처리
    Route::post('/{id}/participate', [\Jiny\Site\Http\Controllers\Site\Event\ParticipateController::class, 'store'])
        ->name('participate.store')
        ->where('id', '[0-9]+');

    // 이벤트 참여 취소
    Route::delete('/{id}/cancel-participation', [\Jiny\Site\Http\Controllers\Site\Event\ParticipateController::class, 'cancel'])
        ->name('participate.cancel')
        ->where('id', '[0-9]+');

    // 이벤트 참여 현황 조회 (AJAX)
    Route::get('/{id}/participation-status', [\Jiny\Site\Http\Controllers\Site\Event\ParticipateController::class, 'status'])
        ->name('participate.status')
        ->where('id', '[0-9]+');

    // 이벤트 상세보기 (slug 우선, ID도 지원)
    Route::get('/{identifier}', \Jiny\Site\Http\Controllers\Site\Event\ShowController::class)
        ->name('show')
        ->where('identifier', '[a-zA-Z0-9\-_]+');
});


/*
|--------------------------------------------------------------------------
| Contact Routes (문의하기)
|--------------------------------------------------------------------------
|
| 사용자가 상담 요청을 할 수 있는 기능을 제공합니다.
| Single Action Controller 방식으로 구현됨
|
*/

Route::middleware('web')->prefix('about/contact')->name('contact.')->group(function () {
    // 상담 목록 (로그인 필요)
    Route::get('/', \Jiny\Site\Http\Controllers\Site\Contact\IndexController::class)
        ->name('index');

    // 상담 요청 폼
    Route::get('/create', \Jiny\Site\Http\Controllers\Site\Contact\CreateController::class)
        ->name('create');

    // 상담 요청 저장
    Route::post('/', \Jiny\Site\Http\Controllers\Site\Contact\StoreController::class)
        ->name('store');

    // 상담 검색 (비회원)
    Route::match(['GET', 'POST'], '/search', \Jiny\Site\Http\Controllers\Site\Contact\SearchController::class)
        ->name('search');

    // 상담 상세 조회
    Route::get('/{contactNumber}', \Jiny\Site\Http\Controllers\Site\Contact\ShowController::class)
        ->name('show');

    // 상담 수정 폼
    Route::get('/{contactNumber}/edit', \Jiny\Site\Http\Controllers\Site\Contact\EditController::class)
        ->name('edit');

    // 상담 수정
    Route::put('/{contactNumber}', \Jiny\Site\Http\Controllers\Site\Contact\UpdateController::class)
        ->name('update');

    // 상담 취소
    Route::post('/{contactNumber}/cancel', \Jiny\Site\Http\Controllers\Site\Contact\CancelController::class)
        ->name('cancel');
});

// 이전 /contact 경로에서 /about/contact로 리다이렉트 (하위 호환성)
Route::middleware('web')->prefix('contact')->group(function () {
    Route::get('/', function () {
        return redirect()->route('contact.index');
    });
    Route::get('/create', function () {
        return redirect()->route('contact.create');
    });
    Route::get('/search', function () {
        return redirect()->route('contact.search');
    });
    Route::get('/{contactNumber}', function ($contactNumber) {
        return redirect()->route('contact.show', $contactNumber);
    });
    Route::get('/{contactNumber}/edit', function ($contactNumber) {
        return redirect()->route('contact.edit', $contactNumber);
    });
});

/*
|--------------------------------------------------------------------------
| Product Routes (상품 보기)
|--------------------------------------------------------------------------
|
| Frontend product viewing with priority-based URL routing:
| 1. /product/{category}/{product} - Category-based product URLs
| 2. /product/{product} - Direct product URLs
|
| Supports both slug and ID for categories and products
|
*/

Route::middleware('web')->prefix('product')->name('product.')->group(function () {
    // Product viewing with dynamic routing
    Route::get('/{segment1}/{segment2?}', \Jiny\Store\Http\Controllers\Store\Products\Product::class)
        ->name('show')
        ->where([
            'segment1' => '[a-zA-Z0-9\-_]+',
            'segment2' => '[a-zA-Z0-9\-_]+'
        ]);
});

/*
|--------------------------------------------------------------------------
| Testimonials Routes (고객 후기)
|--------------------------------------------------------------------------
|
| Frontend testimonials functionality including like/unlike features
|
*/

Route::middleware('web')->prefix('testimonials')->name('testimonials.')->group(function () {
    // Create new testimonial
    Route::post('/', \Jiny\Site\Http\Controllers\Site\Testimonials\StoreController::class)
        ->name('store');

    // Like/unlike testimonial
    Route::post('/{id}/like', \Jiny\Site\Http\Controllers\Site\Testimonials\LikeController::class)
        ->name('like')
        ->where('id', '[0-9]+');
});


    // 동적 페이지 (Fallback - 마지막에 위치)
    // cart, product, contact, help, faq, event, testimonials, store 경로는 제외
    // board는 jiny/post 패키지에서 처리됨
    Route::get('/{slug}', [\Jiny\Site\Http\Controllers\PageController::class, 'show'])
        ->name('page.show')
        ->where('slug', '^(?!cart|product|contact|help|faq|event|testimonials|store)([a-zA-Z0-9\-_]+)$');

// Sitemap & RSS
Route::middleware('web')->group(function () {
    // 사이트맵 XML
    Route::get('/sitemap.xml', [\Jiny\Site\Http\Controllers\PageController::class, 'sitemap'])
        ->name('sitemap.xml');

    // RSS 피드
    Route::get('/rss.xml', [\Jiny\Site\Http\Controllers\PageController::class, 'rss'])
        ->name('rss.xml');
});



/*
|--------------------------------------------------------------------------
| Cart Routes (장바구니)
|--------------------------------------------------------------------------
|
| 장바구니 관련 라우트를 정의합니다.
| 로그인한 사용자와 비로그인 사용자 모두 이용 가능합니다.
|
*/
Route::prefix('cart')->name('cart.')->middleware('web')->group(function () {
    // 장바구니 페이지
    Route::get('/', \Jiny\Store\Http\Controllers\Store\Cart\IndexController::class)->name('index');

    // 장바구니에 상품 추가
    Route::post('/add', \Jiny\Store\Http\Controllers\Store\Cart\AddController::class)->name('add');

    // 장바구니 수량 업데이트
    Route::put('/{cartId}', \Jiny\Store\Http\Controllers\Store\Cart\UpdateController::class)
        ->name('update')
        ->where('cartId', '[0-9]+');

    // 장바구니에서 상품 제거
    Route::delete('/{cartId}', \Jiny\Store\Http\Controllers\Store\Cart\RemoveController::class)
        ->name('remove')
        ->where('cartId', '[0-9]+');

    // 장바구니 아이템 개수 조회 (AJAX)
    Route::get('/count', \Jiny\Store\Http\Controllers\Store\Cart\CountController::class)->name('count');
});
