<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Jiny\Site\Http\Middleware\CheckSiteEnabled;

// 메인 welcome 페이지
Route::get('/', \Jiny\Site\Http\Controllers\Welcome\WelcomeController::class)->name('home');

// 베너 컴포넌트 데모 페이지
Route::get('/banner-demo', function () {
    try {
        $banners = \App\Models\Banner::active()->valid()->ordered()->get();
        return view('banner-component-demo', compact('banners'));
    } catch (\Exception $e) {
        return response("Error: " . $e->getMessage() . " | " . $e->getFile() . ":" . $e->getLine(), 500);
    }
})->name('banner.demo');

// 간단한 테스트 라우트
Route::get('/test-banner', function () {
    return response("Test route works! Banner count: " . \App\Models\Banner::count());
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

// FAQ (site-cms에서 이동)
Route::middleware('web')->prefix('faq')->name('faq.')->group(function () {
    // FAQ 메인 페이지
    Route::get('/', \Jiny\Site\Http\Controllers\Site\Faq\IndexController::class)
        ->name('index');

    // FAQ 검색
    Route::get('/search', \Jiny\Site\Http\Controllers\Site\Faq\SearchController::class)
        ->name('search');

    // FAQ 카테고리별 목록
    Route::get('/category/{code}', \Jiny\Site\Http\Controllers\Site\Faq\CategoryController::class)
        ->name('category');
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
    Route::get('/{segment1}/{segment2?}', \Jiny\Site\Http\Controllers\Site\Product::class)
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
    // cart, product, contact, help, faq, event, board, testimonials 경로는 제외
    Route::get('/{slug}', [\Jiny\Site\Http\Controllers\PageController::class, 'show'])
        ->name('page.show')
        ->where('slug', '^(?!cart|product|contact|help|faq|event|board|testimonials)([a-zA-Z0-9\-_]+)$');

// Sitemap & RSS
Route::middleware('web')->group(function () {
    // 사이트맵 XML
    Route::get('/sitemap.xml', [\Jiny\Site\Http\Controllers\PageController::class, 'sitemap'])
        ->name('sitemap.xml');

    // RSS 피드
    Route::get('/rss.xml', [\Jiny\Site\Http\Controllers\PageController::class, 'rss'])
        ->name('rss.xml');
});

// Help (site-cms에서 이동)
Route::middleware('web')->prefix('help')->name('help.')->group(function () {
    // Help 메인 페이지
    Route::get('/', \Jiny\Site\Http\Controllers\Site\Help\IndexController::class)
        ->name('index');

    // Help 검색
    Route::get('/search', \Jiny\Site\Http\Controllers\Site\Help\SearchController::class)
        ->name('search');

    // Help FAQ
    Route::get('/faq', \Jiny\Site\Http\Controllers\Site\Help\Faq\IndexController::class)
        ->name('faq');

    // Help 가이드
    Route::get('/guide', \Jiny\Site\Http\Controllers\Site\Help\Guide\IndexController::class)
        ->name('guide');

    // Help 가이드 상세
    Route::get('/guide/{id}', \Jiny\Site\Http\Controllers\Site\Help\Guide\ShowController::class)
        ->name('guide.single')
        ->where('id', '[0-9]+');

    // Help 가이드 좋아요
    Route::post('/guide/{id}/like', \Jiny\Site\Http\Controllers\Site\Help\Guide\LikeController::class)
        ->name('guide.like')
        ->where('id', '[0-9]+');

    // Help 고객지원
    Route::match(['GET', 'POST'], '/support', \Jiny\Site\Http\Controllers\Site\Help\Support\IndexController::class)
        ->name('support');

    // 지원 요청 성공 페이지
    Route::get('/support/success', \Jiny\Site\Http\Controllers\Site\Help\Support\SuccessController::class)
        ->name('support.success');

    // 내 지원 요청 목록 (로그인 필요)
    Route::get('/support/my', \Jiny\Site\Http\Controllers\Site\Help\Support\MyController::class)
        ->name('support.my')
        ->middleware('auth');

    // 내 지원 요청 상세 보기 (로그인 필요)
    Route::get('/support/my/{id}', \Jiny\Site\Http\Controllers\Site\Help\Support\ShowController::class)
        ->name('support.show')
        ->middleware('auth')
        ->where('id', '[0-9]+');

    // 지원 요청 평가 제출 (로그인 필요)
    Route::post('/support/{id}/evaluate', \Jiny\Site\Http\Controllers\Site\Help\Support\EvaluationController::class)
        ->name('support.evaluate')
        ->middleware('auth')
        ->where('id', '[0-9]+');

    // 사용자 직접 지원 요청 종료 (로그인 필요)
    Route::post('/support/{id}/close', \Jiny\Site\Http\Controllers\Site\Help\Support\CloseController::class)
        ->name('support.close')
        ->where('id', '[0-9]+');

    // 고객 추가 문의 제출 (로그인 필요)
    Route::post('/support/{id}/reply', \Jiny\Site\Http\Controllers\Site\Help\Support\CustomerReplyController::class)
        ->name('support.customer.reply')
        ->middleware('auth')
        ->where('id', '[0-9]+');

    // 지원 요청 수정 (로그인 필요)
    Route::match(['GET', 'POST'], '/support/{id}/edit', \Jiny\Site\Http\Controllers\Site\Help\Support\EditController::class)
        ->name('support.edit')
        ->middleware('auth')
        ->where('id', '[0-9]+');

    // 지원 요청 삭제 (로그인 필요)
    Route::delete('/support/{id}/delete', \Jiny\Site\Http\Controllers\Site\Help\Support\DeleteController::class)
        ->name('support.delete')
        ->middleware('auth')
        ->where('id', '[0-9]+');

    // Help 카테고리별 목록
    Route::get('/category/{code}', \Jiny\Site\Http\Controllers\Site\Help\CategoryController::class)
        ->name('category');

    // Help 상세 페이지
    Route::get('/{id}', \Jiny\Site\Http\Controllers\Site\Help\DetailController::class)
        ->name('detail')
        ->where('id', '[0-9]+');

    // Help 좋아요 기능
    Route::post('/{id}/like', function($id) {
        // 좋아요 처리 로직
        DB::table('site_help')->where('id', $id)->increment('like');
        return response()->json(['success' => true]);
    })->name('like')
      ->where('id', '[0-9]+');
});

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
    Route::get('/', \Jiny\Site\Http\Controllers\Site\Cart\IndexController::class)->name('index');

    // 장바구니에 상품 추가
    Route::post('/add', \Jiny\Site\Http\Controllers\Site\Cart\AddController::class)->name('add');

    // 장바구니 수량 업데이트
    Route::put('/{cartId}', \Jiny\Site\Http\Controllers\Site\Cart\UpdateController::class)
        ->name('update')
        ->where('cartId', '[0-9]+');

    // 장바구니에서 상품 제거
    Route::delete('/{cartId}', \Jiny\Site\Http\Controllers\Site\Cart\RemoveController::class)
        ->name('remove')
        ->where('cartId', '[0-9]+');

    // 장바구니 아이템 개수 조회 (AJAX)
    Route::get('/count', \Jiny\Site\Http\Controllers\Site\Cart\CountController::class)->name('count');
});
