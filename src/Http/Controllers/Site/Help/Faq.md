# FAQ 시스템 문서

## 개요

FAQ(Frequently Asked Questions) 시스템은 사용자들이 자주 묻는 질문과 답변을 체계적으로 관리하고 제공하는 시스템입니다. 카테고리별 분류, 검색 기능, 조회수 추적 등의 기능을 제공하여 효율적인 고객 지원을 가능하게 합니다.

## 주요 기능

### 사용자 기능
- ✅ **FAQ 목록 조회**: 카테고리별 FAQ 목록 표시
- ✅ **카테고리 필터링**: 특정 카테고리의 FAQ만 조회
- ✅ **인기 FAQ**: 조회수 기준 인기 FAQ 표시
- ✅ **페이지네이션**: 대용량 FAQ 목록 효율적 표시
- 🔄 **검색 기능**: 키워드 기반 FAQ 검색 (구현 예정)
- 🔄 **FAQ 상세 보기**: 개별 FAQ 내용 상세 조회 (구현 예정)

### 관리자 기능 (구현 예정)
- 🔄 **FAQ 관리**: FAQ 추가, 수정, 삭제
- 🔄 **카테고리 관리**: FAQ 카테고리 관리
- 🔄 **순서 관리**: FAQ 표시 순서 조정
- 🔄 **통계 조회**: 조회수 및 활용도 통계

## 시스템 아키텍처

### 디렉토리 구조

```
vendor/jiny/site/src/Http/Controllers/Site/Help/Faq/
├── IndexController.php          # FAQ 목록 표시
└── (구현 예정)
    ├── ShowController.php       # FAQ 상세 보기
    └── SearchController.php     # FAQ 검색
```

### 데이터베이스 스키마

#### site_faq 테이블
주요 FAQ 데이터를 저장하는 테이블

| 필드명 | 타입 | 설명 |
|--------|------|------|
| id | BIGINT(PK) | 고유 식별자 |
| enable | BOOLEAN | 활성화 상태 |
| category | VARCHAR(50) | 카테고리 코드 |
| question | TEXT | 질문 내용 |
| answer | TEXT | 답변 내용 |
| order | INT | 정렬 순서 |
| views | INT | 조회수 |
| tags | JSON | 태그 정보 (nullable) |
| meta_title | VARCHAR(255) | SEO 제목 (nullable) |
| meta_description | TEXT | SEO 설명 (nullable) |
| created_at | TIMESTAMP | 생성일시 |
| updated_at | TIMESTAMP | 수정일시 |
| deleted_at | TIMESTAMP | 삭제일시 (Soft Delete) |

#### site_faq_cate 테이블
FAQ 카테고리 정보를 저장하는 테이블

| 필드명 | 타입 | 설명 |
|--------|------|------|
| id | BIGINT(PK) | 고유 식별자 |
| code | VARCHAR(50) | 카테고리 코드 (고유) |
| name | VARCHAR(100) | 카테고리 명 |
| description | TEXT | 카테고리 설명 (nullable) |
| icon | VARCHAR(100) | 아이콘 클래스 (nullable) |
| color | VARCHAR(20) | 색상 코드 (nullable) |
| pos | INT | 정렬 순서 |
| enable | BOOLEAN | 활성화 상태 |
| created_at | TIMESTAMP | 생성일시 |
| updated_at | TIMESTAMP | 수정일시 |

## 컨트롤러 상세 분석

### FAQ/IndexController

#### 메소드 호출 트리
```
__invoke(Request $request)
├── $request->input('category', '') - 카테고리 파라미터 조회
├── DB::table('site_faq_cate') - 카테고리 목록 조회
│   ├── where('enable', true) - 활성화된 카테고리만
│   └── orderBy('pos') - 정렬 순서대로
├── DB::table('site_faq') - FAQ 목록 조회
│   ├── where('enable', true) - 활성화된 FAQ만
│   ├── whereNull('deleted_at') - 삭제되지 않은 FAQ만
│   ├── where('category', $category) - 카테고리 필터 (선택시)
│   ├── orderBy('order') - 우선 정렬 순서
│   ├── orderBy('created_at', 'desc') - 2차 정렬 (최신순)
│   └── paginate() - 페이지네이션 적용
├── 선택된 카테고리 정보 조회 (카테고리 선택시)
├── DB::table('site_faq') - 인기 FAQ 조회
│   ├── orderBy('views', 'desc') - 조회수 기준 내림차순
│   └── limit(5) - 상위 5개만
└── view() - FAQ 목록 뷰 반환
```

## 라우팅

### Frontend Routes
```php
// FAQ 목록
Route::get('/help/faq', [Faq\IndexController::class, '__invoke'])->name('help.faq.index');

// 카테고리별 FAQ 목록
Route::get('/help/faq', [Faq\IndexController::class, '__invoke'])
    ->name('help.faq.category'); // ?category=카테고리코드
```

## 결론

FAQ 시스템은 효율적인 고객 지원을 위한 핵심 구성 요소입니다. 현재 구현된 기본 기능을 바탕으로 검색, 상세 보기, 관리자 기능 등을 단계적으로 확장하여 완성도 높은 FAQ 시스템을 구축할 수 있습니다.
