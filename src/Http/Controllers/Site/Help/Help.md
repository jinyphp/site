# Help 시스템 문서

## 개요

Help 시스템은 사용자들에게 종합적인 도움말 서비스를 제공하는 통합 플랫폼입니다. 일반 도움말, FAQ, 가이드, 지원 요청 등 다양한 형태의 고객 지원 기능을 하나의 체계적인 시스템으로 구성하여 사용자가 필요한 정보를 효율적으로 찾을 수 있도록 지원합니다.

## 주요 기능

### 도움말 기능
- ✅ **도움말 목록**: 카테고리별 도움말 목록 조회
- ✅ **도움말 상세**: 개별 도움말 상세 내용 조회
- ✅ **카테고리별 분류**: 체계적인 도움말 분류 시스템
- ✅ **검색 기능**: 키워드 기반 도움말 검색
- ✅ **관련 도움말**: 같은 카테고리 관련 도움말 추천

### 통합 기능
- ✅ **FAQ 연동**: FAQ 시스템과의 완전 통합
- ✅ **가이드 연동**: 가이드 시스템과의 완전 통합
- ✅ **지원 요청 연동**: 지원 요청 시스템과의 완전 통합
- ✅ **통합 네비게이션**: 모든 도움말 기능 통합 접근

### 관리자 기능 (구현 예정)
- 🔄 **도움말 관리**: 도움말 추가, 수정, 삭제
- 🔄 **카테고리 관리**: 도움말 카테고리 관리
- 🔄 **순서 관리**: 도움말 표시 순서 조정
- 🔄 **통계 조회**: 조회수 및 활용도 통계

## 시스템 아키텍처

### 디렉토리 구조

```
vendor/jiny/site/src/Http/Controllers/Site/Help/
├── IndexController.php         # 도움말 메인 페이지
├── CategoryController.php      # 카테고리별 도움말 목록
├── DetailController.php        # 도움말 상세 보기
├── SearchController.php        # 도움말 검색
├── Faq/
│   └── IndexController.php     # FAQ 시스템
├── Guide/
│   ├── IndexController.php     # 가이드 목록
│   ├── ShowController.php      # 가이드 상세
│   └── LikeController.php      # 가이드 평가
└── Support/
    ├── IndexController.php     # 지원 요청 폼
    ├── MyController.php        # 내 지원 요청
    ├── EditController.php      # 지원 요청 수정
    ├── DeleteController.php    # 지원 요청 삭제
    └── SuccessController.php   # 지원 요청 성공
```

### 데이터베이스 스키마

#### site_help 테이블
기본 도움말 데이터를 저장하는 테이블

| 필드명 | 타입 | 설명 |
|--------|------|------|
| id | BIGINT(PK) | 고유 식별자 |
| enable | BOOLEAN | 활성화 상태 |
| category | VARCHAR(50) | 카테고리 코드 |
| title | VARCHAR(255) | 도움말 제목 |
| content | TEXT | 도움말 내용 |
| excerpt | TEXT | 도움말 요약 (nullable) |
| order | INT | 정렬 순서 |
| views | INT | 조회수 |
| meta_title | VARCHAR(255) | SEO 제목 (nullable) |
| meta_description | TEXT | SEO 설명 (nullable) |
| created_at | TIMESTAMP | 생성일시 |
| updated_at | TIMESTAMP | 수정일시 |
| deleted_at | TIMESTAMP | 삭제일시 (Soft Delete) |

#### site_help_cate 테이블
도움말 카테고리 정보를 저장하는 테이블

| 필드명 | 타입 | 설명 |
|--------|------|------|
| id | BIGINT(PK) | 고유 식별자 |
| code | VARCHAR(50) | 카테고리 코드 (고유) |
| title | VARCHAR(100) | 카테고리 제목 |
| description | TEXT | 카테고리 설명 (nullable) |
| icon | VARCHAR(100) | 아이콘 클래스 (nullable) |
| color | VARCHAR(20) | 색상 코드 (nullable) |
| order | INT | 정렬 순서 |
| enable | BOOLEAN | 활성화 상태 |
| created_at | TIMESTAMP | 생성일시 |
| updated_at | TIMESTAMP | 수정일시 |

## 컨트롤러 상세 분석

### Help/IndexController

#### 메소드 호출 트리
```
__invoke(Request $request)
├── DB::table('site_help_cate') - 카테고리 목록 조회
│   ├── where('enable', true) - 활성화된 카테고리만
│   └── orderBy('order') - 정렬 순서대로
├── DB::table('site_help') - 도움말 목록 조회
│   ├── where('enable', true) - 활성화된 도움말만
│   ├── orderBy('order') - 정렬 순서대로
│   └── paginate() - 페이지네이션 적용
└── view() - 도움말 메인 뷰 반환
```

#### 주요 기능
- 도움말 시스템의 메인 랜딩 페이지
- 카테고리별 도움말 개요 제공
- 전체 도움말 목록 표시

### Help/CategoryController

#### 메소드 호출 트리
```
__invoke(Request $request, $code)
├── DB::table('site_help_cate') - 카테고리 정보 조회
│   ├── where('code', $code) - 특정 카테고리
│   └── where('enable', true) - 활성화된 카테고리만
├── abort(404) - 카테고리 없을 경우 404 에러
├── DB::table('site_help') - 카테고리별 도움말 조회
│   ├── where('category', $code) - 해당 카테고리만
│   ├── where('enable', true) - 활성화된 도움말만
│   ├── orderBy('order') - 정렬 순서대로
│   └── paginate() - 페이지네이션 적용
├── DB::table('site_help_cate') - 사이드바용 전체 카테고리
└── view() - 카테고리별 도움말 뷰 반환
```

#### 주요 기능
- 특정 카테고리의 도움말 목록 표시
- 카테고리 정보 및 설명 제공
- 사이드바 네비게이션 지원

### Help/DetailController

#### 메소드 호출 트리
```
__invoke(Request $request, $id)
├── DB::table('site_help') - 도움말 상세 정보 조회
│   ├── where('id', $id) - 특정 도움말
│   └── where('enable', true) - 활성화된 도움말만
├── abort(404) - 도움말 없을 경우 404 에러
├── 관련 도움말 조회 (같은 카테고리, 현재 도움말 제외)
├── 카테고리 정보 조회 (도움말에 카테고리가 있는 경우)
└── view() - 도움말 상세 뷰 반환
```

#### 주요 기능
- 개별 도움말의 상세 내용 표시
- 관련 도움말 추천 (같은 카테고리)
- 카테고리 정보 및 브레드크럼 제공

**관련 도움말 추천 로직**:
```php
if ($help->category) {
    $relatedHelps = DB::table($this->config['table'])
        ->where('category', $help->category)
        ->where('id', '!=', $id)  // 현재 도움말 제외
        ->where('enable', true)
        ->orderBy('order')
        ->limit(5)
        ->get();
}
```

### Help/SearchController

#### 메소드 호출 트리
```
__invoke(Request $request)
├── $request->input('q') - 검색 키워드 조회
├── $request->input('category') - 카테고리 필터 조회
├── DB::table('site_help_cate') - 전체 카테고리 목록 조회
├── 검색 키워드가 있을 경우:
│   ├── DB::table('site_help') - 도움말 검색 쿼리 구성
│   │   ├── where('title', 'like') - 제목에서 검색
│   │   ├── orWhere('content', 'like') - 내용에서 검색
│   │   ├── where('category') - 카테고리 필터 (선택시)
│   │   └── paginate() - 페이지네이션 적용
│   └── $helps->appends() - 페이지네이션 파라미터 유지
└── view() - 검색 결과 뷰 반환
```

#### 주요 기능
- 키워드 기반 도움말 검색
- 제목과 내용에서 동시 검색
- 카테고리별 검색 필터링
- 검색 결과 페이지네이션

**검색 쿼리 로직**:
```php
$helpQuery = DB::table($this->config['table'])
    ->where('enable', true)
    ->where(function ($q) use ($query) {
        $q->where('title', 'like', '%' . $query . '%')
          ->orWhere('content', 'like', '%' . $query . '%');
    });

if (!empty($category)) {
    $helpQuery->where('category', $category);
}
```

## 통합 시스템 구조

### Help 시스템 전체 구성도

```
Help 시스템 (메인 허브)
├── 기본 도움말 (site_help)
│   ├── 카테고리별 분류
│   ├── 검색 기능
│   └── 상세 보기
├── FAQ 시스템 (site_faq)
│   ├── 자주 묻는 질문
│   ├── 카테고리별 분류
│   └── 인기 FAQ
├── Guide 시스템 (site_guide)
│   ├── 단계별 가이드
│   ├── 좋아요/싫어요
│   └── 관련 가이드 추천
└── Support 시스템 (site_support)
    ├── 지원 요청 제출
    ├── 내 요청 관리
    └── 상태 추적
```

### 시스템 간 연동

#### 1. 네비게이션 통합
```php
// 메인 Help 페이지에서 모든 하위 시스템 링크 제공
$helpSections = [
    'general' => [
        'title' => '일반 도움말',
        'description' => '기본적인 사용법과 정보',
        'url' => '/help',
        'icon' => 'help-circle'
    ],
    'faq' => [
        'title' => '자주 묻는 질문',
        'description' => '많이 묻는 질문과 답변',
        'url' => '/help/faq',
        'icon' => 'message-circle'
    ],
    'guide' => [
        'title' => '가이드',
        'description' => '단계별 사용 가이드',
        'url' => '/help/guide',
        'icon' => 'book-open'
    ],
    'support' => [
        'title' => '지원 요청',
        'description' => '직접 지원을 요청하세요',
        'url' => '/help/support',
        'icon' => 'headphones'
    ]
];
```

#### 2. 검색 통합 (구현 예정)
```php
// 통합 검색에서 모든 Help 시스템 검색
public function unifiedSearch($keyword) {
    $results = [
        'help' => $this->searchHelp($keyword),
        'faq' => $this->searchFaq($keyword),
        'guide' => $this->searchGuide($keyword),
    ];
    return $results;
}
```

## 라우팅

### Help 시스템 라우트
```php
// 메인 도움말
Route::get('/help', [Help\IndexController::class, '__invoke'])->name('help.index');
Route::get('/help/search', [Help\SearchController::class, '__invoke'])->name('help.search');
Route::get('/help/category/{code}', [Help\CategoryController::class, '__invoke'])->name('help.category');
Route::get('/help/{id}', [Help\DetailController::class, '__invoke'])->name('help.detail');

// FAQ 시스템
Route::get('/help/faq', [Help\Faq\IndexController::class, '__invoke'])->name('help.faq.index');

// Guide 시스템
Route::get('/help/guide', [Help\Guide\IndexController::class, '__invoke'])->name('help.guide.index');
Route::get('/help/guide/{id}', [Help\Guide\ShowController::class, '__invoke'])->name('help.guide.show');
Route::post('/help/guide/{id}/like', [Help\Guide\LikeController::class, '__invoke'])->name('help.guide.like');

// Support 시스템
Route::get('/help/support', [Help\Support\IndexController::class, '__invoke'])->name('help.support.index');
Route::post('/help/support', [Help\Support\IndexController::class, '__invoke'])->name('help.support.store');
Route::get('/help/support/success', [Help\Support\SuccessController::class, '__invoke'])->name('help.support.success');

// 인증이 필요한 Support 기능
Route::middleware(['auth'])->group(function () {
    Route::get('/help/support/my', [Help\Support\MyController::class, '__invoke'])->name('help.support.my');
    Route::get('/help/support/{id}/edit', [Help\Support\EditController::class, '__invoke'])->name('help.support.edit');
    Route::post('/help/support/{id}/edit', [Help\Support\EditController::class, '__invoke'])->name('help.support.update');
    Route::delete('/help/support/{id}', [Help\Support\DeleteController::class, '__invoke'])->name('help.support.delete');
});
```

## 뷰 템플릿 구조

### Help 시스템 뷰 구조
```
resources/views/www/help/
├── index.blade.php              # Help 메인 페이지
├── category.blade.php           # 카테고리별 도움말 목록
├── detail.blade.php             # 도움말 상세 보기
├── search.blade.php             # 검색 결과 페이지
├── faq/
│   └── index.blade.php          # FAQ 목록
├── guide/
│   ├── index.blade.php          # 가이드 목록
│   └── single.blade.php         # 가이드 상세
├── support/
│   ├── index.blade.php          # 지원 요청 폼
│   ├── my.blade.php             # 내 지원 요청
│   ├── edit.blade.php           # 지원 요청 수정
│   └── success.blade.php        # 지원 요청 성공
└── partials/
    ├── navigation.blade.php     # Help 시스템 네비게이션
    ├── breadcrumb.blade.php     # 브레드크럼
    ├── category-nav.blade.php   # 카테고리 네비게이션
    ├── search-form.blade.php    # 검색 폼
    └── related-items.blade.php  # 관련 항목 목록
```

### 공통 레이아웃 구성요소

#### 1. Help 네비게이션
```blade
{{-- resources/views/www/help/partials/navigation.blade.php --}}
<nav class="help-navigation">
    <ul>
        <li><a href="{{ route('help.index') }}" class="{{ request()->routeIs('help.index') ? 'active' : '' }}">도움말</a></li>
        <li><a href="{{ route('help.faq.index') }}" class="{{ request()->routeIs('help.faq.*') ? 'active' : '' }}">FAQ</a></li>
        <li><a href="{{ route('help.guide.index') }}" class="{{ request()->routeIs('help.guide.*') ? 'active' : '' }}">가이드</a></li>
        <li><a href="{{ route('help.support.index') }}" class="{{ request()->routeIs('help.support.*') ? 'active' : '' }}">지원 요청</a></li>
    </ul>
</nav>
```

#### 2. 통합 검색 폼
```blade
{{-- resources/views/www/help/partials/search-form.blade.php --}}
<form action="{{ route('help.search') }}" method="GET" class="help-search-form">
    <div class="search-input-group">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="도움말 검색..." class="search-input">
        <select name="category" class="search-category">
            <option value="">전체 카테고리</option>
            @foreach($categories as $category)
                <option value="{{ $category->code }}" {{ request('category') == $category->code ? 'selected' : '' }}>
                    {{ $category->title }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="search-button">검색</button>
    </div>
</form>
```

## UI/UX 고려사항

### 사용자 경험 최적화
1. **통합 네비게이션**: 모든 Help 기능에 쉽게 접근
2. **일관된 디자인**: 모든 하위 시스템 통일된 UI/UX
3. **효율적 검색**: 전체 Help 시스템 통합 검색
4. **반응형 디자인**: 모바일 친화적 인터페이스
5. **브레드크럼**: 현재 위치 명확한 표시

### 접근성 고려사항
1. **키보드 네비게이션**: 키보드로 모든 기능 접근 가능
2. **스크린 리더 지원**: 적절한 ARIA 레이블링
3. **시멘틱 HTML**: 의미있는 HTML 구조 사용
4. **색상 대비**: 충분한 색상 대비율 확보

## 성능 최적화

### 데이터베이스 최적화
```sql
-- 추천 인덱스
CREATE INDEX idx_help_enable_category ON site_help(enable, category);
CREATE INDEX idx_help_enable_order ON site_help(enable, `order`);
CREATE INDEX idx_help_title_content ON site_help(title, content);
CREATE INDEX idx_help_cate_enable_order ON site_help_cate(enable, `order`);
```

### 캐싱 전략
1. **카테고리 목록**: 변경 빈도가 낮아 장기간 캐시
2. **인기 도움말**: 시간별 갱신으로 성능 향상
3. **검색 결과**: 자주 검색되는 키워드 결과 캐시

### 검색 성능 최적화
1. **전문 검색 엔진**: Elasticsearch 또는 MySQL Full-Text Search 활용
2. **검색 인덱스**: 제목과 내용에 대한 전문 검색 인덱스
3. **검색 결과 캐싱**: 인기 검색어 결과 캐시

## 보안 고려사항

### 입력 검증
1. **XSS 방지**: 도움말 내용 출력 시 이스케이프 처리
2. **SQL 인젝션 방지**: 검색 쿼리 파라미터 바인딩
3. **CSRF 보호**: 폼 제출 시 토큰 검증

### 접근 제어
1. **관리자 권한**: 도움말 관리 기능 접근 제한
2. **컨텐츠 보안**: 비활성화된 도움말 접근 차단

## 확장 계획

### 단기 계획
1. **통합 검색**: 모든 Help 시스템 통합 검색
2. **태그 시스템**: 도움말 태그 기반 분류
3. **평점 시스템**: 도움말 유용성 평가
4. **북마크 기능**: 사용자별 도움말 북마크

### 중기 계획
1. **관리자 인터페이스**: 통합 Help 관리 도구
2. **다단계 카테고리**: 계층형 카테고리 구조
3. **연관 콘텐츠**: 시스템 간 연관 콘텐츠 추천
4. **사용자 피드백**: 도움말 개선 의견 수집

### 장기 계획
1. **AI 기반 추천**: 사용자 행동 기반 도움말 추천
2. **다국어 지원**: 다양한 언어로 도움말 제공
3. **챗봇 연동**: AI 챗봇을 통한 실시간 도움말
4. **API 생태계**: 외부 시스템과의 Help API 연동

## 테스트 시나리오

### 기능 테스트
1. **도움말 조회**
   - 목록 페이지 정상 표시
   - 카테고리별 필터링 동작
   - 상세 페이지 정상 표시

2. **검색 기능**
   - 키워드 검색 정확성
   - 카테고리 필터 동작
   - 페이지네이션 동작

3. **시스템 간 연동**
   - 네비게이션 링크 동작
   - 관련 콘텐츠 표시

### 성능 테스트
1. **대용량 데이터**: 수천 개 도움말 처리 성능
2. **검색 성능**: 복잡한 검색 쿼리 성능
3. **동시 접속**: 다수 사용자 동시 접근

## 모니터링 및 분석

### 사용자 행동 분석
1. **조회 통계**: 도움말별 조회수 추적
2. **검색 키워드**: 사용자 검색 패턴 분석
3. **이동 경로**: 사용자 Help 시스템 탐색 패턴
4. **이탈률**: 각 페이지 이탈 지점 분석

### 콘텐츠 최적화
1. **인기 도움말**: 자주 조회되는 콘텐츠 식별
2. **검색 실패**: 결과 없는 검색어 분석
3. **사용자 피드백**: 도움말 개선 포인트 식별

## 결론

Help 시스템은 사용자에게 포괄적이고 체계적인 도움말 서비스를 제공하는 통합 플랫폼입니다. 기본 도움말, FAQ, 가이드, 지원 요청 등 다양한 형태의 고객 지원 기능을 하나의 일관된 시스템으로 구성하여, 사용자가 필요한 정보를 효율적으로 찾고 활용할 수 있도록 지원합니다.

각 하위 시스템이 독립적으로 동작하면서도 통합된 사용자 경험을 제공하며, 지속적인 기능 확장과 성능 최적화를 통해 더 나은 고객 지원 서비스를 구축할 수 있습니다.
