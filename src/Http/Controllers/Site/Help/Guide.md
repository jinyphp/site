# Guide 시스템 문서

## 개요

Guide 시스템은 사용자들에게 단계별 가이드 문서를 제공하는 포괄적인 도움말 시스템입니다. 카테고리별 분류, 상세 보기, 좋아요/싫어요 기능, 관련 가이드 추천 등의 기능을 통해 효과적인 사용자 지원을 제공합니다.

## 주요 기능

### 사용자 기능
- ✅ **가이드 목록 조회**: 카테고리별 가이드 목록 표시
- ✅ **카테고리별 분류**: 체계적인 가이드 분류 시스템
- ✅ **가이드 상세 보기**: 개별 가이드 상세 내용 조회
- ✅ **조회수 추적**: 가이드 조회수 자동 증가
- ✅ **좋아요/싫어요**: 사용자 피드백 시스템
- ✅ **관련 가이드**: 같은 카테고리 관련 가이드 추천
- ✅ **이전/다음 네비게이션**: 가이드 간 순차 이동
- ✅ **인기 가이드**: 조회수 기준 인기 가이드 표시

### 관리자 기능 (구현 예정)
- 🔄 **가이드 관리**: 가이드 추가, 수정, 삭제
- 🔄 **카테고리 관리**: 가이드 카테고리 관리
- 🔄 **순서 관리**: 가이드 표시 순서 조정
- 🔄 **통계 조회**: 조회수 및 평가 통계

## 시스템 아키텍처

### 디렉토리 구조

```
vendor/jiny/site/src/Http/Controllers/Site/Help/Guide/
├── IndexController.php          # 가이드 목록 표시
├── ShowController.php          # 가이드 상세 보기
└── LikeController.php          # 좋아요/싫어요 처리
```

### 데이터베이스 스키마

#### site_guide 테이블
주요 가이드 데이터를 저장하는 테이블

| 필드명 | 타입 | 설명 |
|--------|------|------|
| id | BIGINT(PK) | 고유 식별자 |
| enable | BOOLEAN | 활성화 상태 |
| category | VARCHAR(50) | 카테고리 코드 |
| title | VARCHAR(255) | 가이드 제목 |
| content | TEXT | 가이드 내용 |
| excerpt | TEXT | 가이드 요약 (nullable) |
| order | INT | 정렬 순서 |
| views | INT | 조회수 |
| likes | INT | 좋아요 수 |
| dislikes | INT | 싫어요 수 |
| meta_title | VARCHAR(255) | SEO 제목 (nullable) |
| meta_description | TEXT | SEO 설명 (nullable) |
| created_at | TIMESTAMP | 생성일시 |
| updated_at | TIMESTAMP | 수정일시 |
| deleted_at | TIMESTAMP | 삭제일시 (Soft Delete) |

#### site_guide_cate 테이블
가이드 카테고리 정보를 저장하는 테이블

| 필드명 | 타입 | 설명 |
|--------|------|------|
| id | BIGINT(PK) | 고유 식별자 |
| code | VARCHAR(50) | 카테고리 코드 (고유) |
| title | VARCHAR(100) | 카테고리 제목 |
| description | TEXT | 카테고리 설명 (nullable) |
| icon | VARCHAR(100) | 아이콘 클래스 (nullable) |
| color | VARCHAR(20) | 색상 코드 (nullable) |
| pos | INT | 정렬 순서 |
| enable | BOOLEAN | 활성화 상태 |
| created_at | TIMESTAMP | 생성일시 |
| updated_at | TIMESTAMP | 수정일시 |

#### site_guide_likes 테이블
가이드 좋아요/싫어요 정보를 저장하는 테이블

| 필드명 | 타입 | 설명 |
|--------|------|------|
| id | BIGINT(PK) | 고유 식별자 |
| guide_id | BIGINT(FK) | 가이드 ID |
| user_id | BIGINT(FK) | 사용자 ID (nullable) |
| user_ip | VARCHAR(45) | 사용자 IP 주소 |
| type | ENUM('like', 'dislike') | 평가 유형 |
| created_at | TIMESTAMP | 생성일시 |
| updated_at | TIMESTAMP | 수정일시 |

## 컨트롤러 상세 분석

### Guide/IndexController

#### 메소드 호출 트리
```
__invoke(Request $request)
├── $request->input('category', '') - 카테고리 파라미터 조회
├── DB::table('site_guide_cate') - 카테고리 목록 조회
│   ├── where('enable', true) - 활성화된 카테고리만
│   └── orderBy('pos') - 정렬 순서대로
├── 카테고리별 가이드 개수 및 최근 가이드 조회
│   ├── count() - 각 카테고리별 가이드 개수
│   ├── limit(5) - 최근 가이드 5개만
│   └── orderBy('order', 'created_at') - 순서/생성일 기준 정렬
├── DB::table('site_guide') - 인기 가이드 조회
│   ├── orderBy('views', 'desc') - 조회수 기준 내림차순
│   └── limit(6) - 상위 6개만
└── view() - 가이드 목록 뷰 반환
```

#### 주요 기능 상세

**1. 카테고리별 가이드 통계**
```php
// 각 카테고리별 가이드 개수 계산
$guideCount = DB::table($this->config['table'])
    ->where('category', $category->code)
    ->where('enable', true)
    ->whereNull('deleted_at')
    ->count();

// 카테고리별 최근 가이드 조회
$category->guides = DB::table($this->config['table'])
    ->where('category', $category->code)
    ->where('enable', true)
    ->whereNull('deleted_at')
    ->orderBy('order')
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();
```

### Guide/ShowController

#### 메소드 호출 트리
```
__invoke(Request $request, $id)
├── DB::table('site_guide') - 가이드 상세 정보 조회
│   ├── leftJoin('site_guide_cate') - 카테고리 정보 조인
│   ├── where('id', $id) - 특정 가이드 조회
│   └── first() - 단일 결과 반환
├── abort(404) - 가이드 없을 경우 404 에러
├── DB::table('site_guide')->increment('views') - 조회수 증가
├── 관련 가이드 조회 (같은 카테고리, 현재 가이드 제외)
├── 이전/다음 가이드 조회 (order 기준)
├── 사용자 좋아요 상태 확인 (IP 기준)
└── view() - 가이드 상세 뷰 반환
```

#### 주요 기능 상세

**1. 가이드 상세 정보 조회**
```php
// 가이드와 카테고리 정보를 조인하여 조회
$guide = DB::table($this->config['table'])
    ->leftJoin($this->config['category_table'], 'site_guide.category', '=', 'site_guide_cate.code')
    ->select(
        'site_guide.*',
        'site_guide_cate.title as category_title'
    )
    ->where('site_guide.id', $id)
    ->where('site_guide.enable', true)
    ->whereNull('site_guide.deleted_at')
    ->first();
```

**2. 조회수 자동 증가**
```php
// 가이드 조회 시 조회수 자동 증가
DB::table($this->config['table'])
    ->where('id', $id)
    ->increment('views');
```

**3. 관련 가이드 추천**
```php
// 같은 카테고리의 다른 가이드들
$relatedGuides = DB::table($this->config['table'])
    ->where('category', $guide->category)
    ->where('id', '!=', $id)
    ->where('enable', true)
    ->whereNull('deleted_at')
    ->orderBy('order')
    ->orderBy('created_at', 'desc')
    ->limit(5)
    ->get();
```

**4. 이전/다음 가이드 네비게이션**
```php
// 이전 가이드 (order 기준)
$previousGuide = DB::table($this->config['table'])
    ->where('category', $guide->category)
    ->where('order', '<', $guide->order ?: 999999)
    ->where('enable', true)
    ->whereNull('deleted_at')
    ->orderBy('order', 'desc')
    ->first();

// 다음 가이드 (order 기준)
$nextGuide = DB::table($this->config['table'])
    ->where('category', $guide->category)
    ->where('order', '>', $guide->order ?: 0)
    ->where('enable', true)
    ->whereNull('deleted_at')
    ->orderBy('order', 'asc')
    ->first();
```

### Guide/LikeController

#### 메소드 호출 트리
```
__invoke(Request $request, $id)
├── $request->validate() - 입력 데이터 검증
├── DB::table('site_guide') - 가이드 존재 확인
├── DB::beginTransaction() - 트랜잭션 시작
├── 기존 좋아요/싫어요 상태 확인 (IP 기준)
├── 좋아요/싫어요 처리 로직
│   ├── 같은 타입: 취소 (삭제)
│   ├── 다른 타입: 변경 (업데이트)
│   └── 새로운 평가: 추가 (생성)
├── 가이드 카운트 업데이트 (likes/dislikes)
├── DB::commit() - 트랜잭션 커밋
└── JSON 응답 반환
```

#### 주요 기능 상세

**1. 중복 평가 방지**
```php
// IP 기준으로 기존 평가 확인
$existingLike = DB::table($this->config['likes_table'])
    ->where('guide_id', $id)
    ->where('user_ip', $userIp)
    ->first();
```

**2. 평가 상태 처리**
```php
if ($existingLike) {
    if ($existingLike->type === $type) {
        // 같은 타입이면 취소 (삭제)
        DB::table($this->config['likes_table'])
            ->where('id', $existingLike->id)
            ->delete();
    } else {
        // 다른 타입이면 변경 (좋아요 ↔ 싫어요)
        DB::table($this->config['likes_table'])
            ->where('id', $existingLike->id)
            ->update(['type' => $type]);
    }
} else {
    // 새로운 평가 추가
    DB::table($this->config['likes_table'])->insert([...]);
}
```

**3. 실시간 카운트 업데이트**
```php
// 좋아요/싫어요 카운트 실시간 업데이트
$column = $type === 'like' ? 'likes' : 'dislikes';
DB::table($this->config['guide_table'])
    ->where('id', $id)
    ->increment($column);  // 또는 decrement()
```

## 라우팅

### Frontend Routes
```php
// 가이드 목록
Route::get('/help/guide', [Guide\IndexController::class, '__invoke'])->name('help.guide.index');

// 가이드 상세 보기
Route::get('/help/guide/{id}', [Guide\ShowController::class, '__invoke'])->name('help.guide.show');

// 좋아요/싫어요 처리 (AJAX)
Route::post('/help/guide/{id}/like', [Guide\LikeController::class, '__invoke'])->name('help.guide.like');
```

## 뷰 템플릿 구조

### 예상 뷰 파일 구조
```
resources/views/www/help/guide/
├── index.blade.php          # 가이드 목록 메인 페이지
├── single.blade.php         # 가이드 상세 보기 페이지
└── partials/
    ├── category-grid.blade.php      # 카테고리 그리드 컴포넌트
    ├── guide-card.blade.php         # 가이드 카드 컴포넌트
    ├── popular-guides.blade.php     # 인기 가이드 컴포넌트
    ├── related-guides.blade.php     # 관련 가이드 컴포넌트
    ├── guide-navigation.blade.php   # 이전/다음 네비게이션
    └── like-buttons.blade.php       # 좋아요/싫어요 버튼
```

### 뷰 데이터 구조

#### IndexController에서 전달되는 데이터
```php
return view($this->config['view'], [
    'categories' => $categoriesWithCounts,    // 카테고리 목록 (가이드 수 포함)
    'popularGuides' => $popularGuides,        // 인기 가이드 목록
    'config' => $this->config,                // 설정 정보
]);
```

#### ShowController에서 전달되는 데이터
```php
return view($this->config['view'], [
    'guide' => $guide,                        // 가이드 상세 정보
    'relatedGuides' => $relatedGuides,        // 관련 가이드 목록
    'previousGuide' => $previousGuide,        // 이전 가이드
    'nextGuide' => $nextGuide,                // 다음 가이드
    'userLike' => $userLike,                  // 사용자 좋아요 상태
    'config' => $this->config,                // 설정 정보
]);
```

## JavaScript 기능

### 좋아요/싫어요 AJAX 처리
```javascript
function toggleLike(guideId, type) {
    fetch(`/help/guide/${guideId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ type: type })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // UI 업데이트
            updateLikeButtons(data);
        }
    });
}
```

## UI/UX 고려사항

### 사용자 경험 최적화
1. **카테고리 기반 탐색**: 직관적인 카테고리 구조
2. **시각적 피드백**: 좋아요/싫어요 상태 명확 표시
3. **연관 콘텐츠**: 관련 가이드 자동 추천
4. **순차 탐색**: 이전/다음 가이드 네비게이션
5. **반응형 디자인**: 모바일 친화적 인터페이스

### 성능 고려사항
1. **이미지 최적화**: 가이드 내 이미지 레이지 로딩
2. **캐싱 전략**: 자주 조회되는 가이드 캐시
3. **페이지네이션**: 대용량 가이드 목록 처리

## 성능 최적화

### 데이터베이스 최적화
```sql
-- 추천 인덱스
CREATE INDEX idx_guide_enable_deleted ON site_guide(enable, deleted_at);
CREATE INDEX idx_guide_category_order ON site_guide(category, `order`);
CREATE INDEX idx_guide_views ON site_guide(views DESC);
CREATE INDEX idx_guide_cate_enable_pos ON site_guide_cate(enable, pos);
CREATE INDEX idx_guide_likes_guide_ip ON site_guide_likes(guide_id, user_ip);
```

### 캐싱 전략
1. **카테고리 목록**: 변경 빈도가 낮아 장기간 캐시
2. **인기 가이드**: 시간별 갱신으로 성능 향상
3. **가이드 내용**: 개별 가이드별 캐시 적용

## 보안 고려사항

### 입력 검증
1. **XSS 방지**: 가이드 내용 출력 시 이스케이프 처리
2. **CSRF 보호**: 좋아요/싫어요 요청 토큰 검증
3. **Rate Limiting**: 좋아요/싫어요 남용 방지

### 접근 제어
1. **IP 기반 제한**: 동일 IP에서 중복 평가 방지
2. **유효성 검증**: 존재하지 않는 가이드 접근 차단

## API 설계 (구현 예정)

### RESTful API 엔드포인트
```
GET    /api/guide                 # 가이드 목록 조회
GET    /api/guide/{id}           # 가이드 상세 조회
GET    /api/guide/categories     # 카테고리 목록 조회
GET    /api/guide/popular        # 인기 가이드 조회
POST   /api/guide/{id}/like      # 좋아요/싫어요 처리
POST   /api/guide/{id}/view      # 조회수 증가
```

### JSON 응답 형식
```json
{
    "success": true,
    "data": {
        "guide": {
            "id": 1,
            "title": "시작하기 가이드",
            "content": "이 가이드는...",
            "category": "beginner",
            "views": 250,
            "likes": 45,
            "dislikes": 3,
            "created_at": "2024-01-01T00:00:00Z"
        },
        "related_guides": [...],
        "navigation": {
            "previous": {...},
            "next": {...}
        }
    }
}
```

## 확장 계획

### 단기 계획
1. **검색 기능**: 가이드 내용 전문 검색
2. **북마크 기능**: 사용자별 가이드 북마크
3. **댓글 시스템**: 가이드별 사용자 댓글
4. **평점 시스템**: 5점 척도 평가 시스템

### 중기 계획
1. **관리자 인터페이스**: 가이드 관리 도구
2. **다단계 카테고리**: 계층형 카테고리 구조
3. **가이드 시리즈**: 연관된 가이드 묶음
4. **진행률 추적**: 사용자별 가이드 읽기 진행률

### 장기 계획
1. **AI 기반 추천**: 사용자 행동 기반 가이드 추천
2. **다국어 지원**: 다양한 언어로 가이드 제공
3. **인터랙티브 가이드**: 단계별 실습 가이드
4. **비디오 가이드**: 동영상 기반 가이드 지원

## 테스트 시나리오

### 기능 테스트
1. **가이드 목록 조회**
   - 카테고리별 가이드 표시 확인
   - 인기 가이드 정렬 확인
   - 빈 카테고리 처리 확인

2. **가이드 상세 보기**
   - 조회수 증가 확인
   - 관련 가이드 표시 확인
   - 이전/다음 네비게이션 동작 확인

3. **좋아요/싫어요 기능**
   - 평가 추가/변경/취소 확인
   - 카운트 실시간 업데이트 확인
   - 중복 평가 방지 확인

### 성능 테스트
1. **대용량 데이터**: 수천 개 가이드 처리 성능
2. **동시 접속**: 다수 사용자 동시 접근
3. **좋아요 처리**: 대량 좋아요 요청 처리

## 결론

Guide 시스템은 사용자에게 체계적이고 효과적인 가이드 경험을 제공하는 포괄적인 도움말 플랫폼입니다. 카테고리 기반 분류, 사용자 피드백 시스템, 관련 콘텐츠 추천 등을 통해 사용자가 필요한 정보를 쉽게 찾고 활용할 수 있도록 지원합니다.

현재 구현된 기능들을 바탕으로 검색, 북마크, 댓글 등의 추가 기능을 단계적으로 확장하여 더욱 완성도 높은 가이드 시스템을 구축할 수 있습니다.
