# Jiny Site Board System Documentation

## 개요
Jiny Site 게시판 시스템은 Single Action Controller 패턴을 기반으로 구현된 현대적인 게시판 솔루션입니다. JWT 인증, 샤딩 지원, 계층형 댓글 시스템을 포함한 완전한 기능을 제공합니다.

## 시스템 아키텍처

### Controller 구조 (Single Action Controllers)
```
/Site/Board/
├── IndexController.php         # 게시판 목록
├── ShowController.php          # 게시글 상세보기
├── CreateController.php        # 글 작성 폼
├── StoreController.php         # 글 저장
├── EditController.php          # 글 수정 폼
├── UpdateController.php        # 글 수정 저장
├── CreateChildController.php   # 답글 작성 폼
├── DestroyController.php       # 글 삭제
├── StoreCommentController.php  # 코멘트 저장
├── UpdateCommentController.php # 코멘트 수정
├── DestroyCommentController.php# 코멘트 삭제
├── StoreRatingController.php   # 평가(좋아요/별점) 저장
└── BoardPermissions.php        # 권한 관리 트레이트
```

### 데이터베이스 구조
- **site_board**: 게시판 설정 테이블
- **site_board_{code}**: 동적 생성되는 개별 게시판 테이블
- **site_board_{code}_comments**: 게시판별 코멘트 테이블
- **site_board_{code}_ratings**: 게시판별 평가(좋아요/별점) 테이블

## 주요 기능

### 1. 게시판 관리 (IndexController)
**파일**: `IndexController.php`
**기능**:
- 게시판 목록 표시 (계층적 트리 구조 지원)
- 검색 기능 (제목, 내용, 작성자)
- 페이지네이션 (5/10/20/50/100 선택 가능)
- 답글 개수 표시 (childCounts)
- 코멘트 개수 표시 (commentCounts)
- 평가 데이터 표시 (좋아요 수, 별점 평균/개수)
- 검색 시 평탄한 목록 표시

**특징**:
- 계층적 구조와 검색 결과 구분 처리
- 원본 게시글(level 0)에만 하위글/코멘트 개수 계산
- JWT 및 세션 기반 인증 지원
- 실시간 평가 통계 계산

```php
// 원본 게시글만 조회
protected function buildMainPostsOnly($table)
{
    return DB::table($table)
        ->whereNull('parent_id')
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();
}
```

### 2. 게시글 상세보기 (ShowController)
**파일**: `ShowController.php`
**기능**:
- 게시글 내용 표시
- 자동 조회수 증가
- 부모글 정보 표시 (답글인 경우)
- 하위글(답글) 목록 표시
- 코멘트 목록 표시
- 평가 데이터 표시 (좋아요/별점 통계)
- 사용자별 평가 상태 확인 (로그인/비회원 구분)
- 수정/삭제 권한 확인
- ID 및 UUID 기반 접근 지원

**특징**:
- 샤딩 환경 지원 (ID/UUID 동시 지원)
- 실시간 권한 확인
- 회원/비회원 평가 상태 관리 (IP 기반)
- 평가 통계 실시간 계산

### 3. 글 작성 시스템

#### 3.1 새 글 작성 (CreateController, StoreController)
**파일**: `CreateController.php`, `StoreController.php`
**기능**:
- 글 작성 폼 제공
- 사용자 정보 표시
- 글 저장 및 검증
- JWT/세션 인증 지원

**StoreController 특징**:
- 샤딩 지원 (UUID, shard_id, user_uuid)
- 계층형 구조 지원 (parent_id, level)
- 권한 기반 접근 제어

```php
// 샤드 ID 계산
private function getShardId($code, $user = null)
{
    if ($user && $user->id) {
        return $user->id % 10; // 사용자 ID 기반
    }
    return abs(crc32($code)) % 10; // 게시판 코드 기반
}
```

#### 3.2 답글 작성 (CreateChildController)
**파일**: `CreateChildController.php`
**기능**:
- 원본 게시글에 대한 답글 작성
- 부모 게시글 정보 확인
- 계층형 구조 지원 (parent_id, level)

#### 3.3 코멘트 작성 (StoreCommentController)
**파일**: `StoreCommentController.php`
**기능**:
- 게시글에 대한 코멘트 저장
- 회원/비회원 코멘트 지원
- 코멘트 내용 검증 (최대 1000자)
- 샤딩 지원 (user_uuid, post_uuid, shard_id)

**특징**:
- 별도 코멘트 테이블 사용 (`{table}_comments`)
- 비회원 코멘트 시 패스워드 암호화
- UUID 및 샤드 ID 지원
- 에러 처리 및 로깅

```php
// 코멘트 샤드 ID 계산
private function getShardId($code, $user = null)
{
    if ($user && $user->id) {
        return $user->id % 10; // 사용자 ID 기반
    }
    return abs(crc32($code)) % 10; // 게시판 코드 기반
}
```

### 4. 평가 시스템 (StoreRatingController)
**파일**: `StoreRatingController.php`
**기능**:
- 좋아요/별점 평가 저장
- 회원/비회원 평가 지원 (IP 기반)
- 평가 중복 방지 및 토글 기능
- 평가 통계 실시간 업데이트

**평가 타입**:
- **like**: 좋아요 (토글 방식)
- **rating**: 별점 (1-5점, 수정 가능)

**특징**:
- JSON 응답으로 AJAX 지원
- 기존 평가 확인 및 업데이트
- 실시간 통계 계산
- 회원/비회원 구분 처리

```php
// 평가 통계 계산
private function updatePostStats($ratingTable, $postId)
{
    // 좋아요 수
    $likeCount = DB::table($ratingTable)
        ->where('post_id', $postId)
        ->where('type', 'like')
        ->where('is_like', true)
        ->count();

    // 별점 통계
    $ratingStats = DB::table($ratingTable)
        ->where('post_id', $postId)
        ->where('type', 'rating')
        ->whereNotNull('rating')
        ->selectRaw('COUNT(*) as count, AVG(rating) as average')
        ->first();

    return [
        'like_count' => $likeCount,
        'rating_count' => $ratingStats->count ?? 0,
        'rating_average' => round($ratingStats->average ?? 0, 1),
    ];
}
```

### 5. 글 수정/삭제 시스템

#### 5.1 글 수정 (EditController, UpdateController)
**파일**: `EditController.php`, `UpdateController.php`
**기능**:
- 소유자/권한 확인
- 수정 폼 제공
- 글 업데이트
- 디버깅 로그 (UpdateController)

#### 5.2 글 삭제 (DestroyController)
**파일**: `DestroyController.php`
**기능**:
- 삭제 권한 확인
- 하위글 존재 확인 (답글이 있으면 삭제 불가)
- 안전한 삭제 처리

#### 5.3 코멘트 관리
**파일**: `UpdateCommentController.php`, `DestroyCommentController.php`
**기능**:
- 코멘트 수정 및 삭제
- 작성자 확인
- 비회원 코멘트 패스워드 검증

### 6. 권한 관리 시스템 (BoardPermissions)
**파일**: `BoardPermissions.php`
**트레이트 기능**:

#### 6.1 인증 시스템
- JWT 토큰 인증
- 세션 기반 인증
- Fallback 인증 (refresh token 지원)

```php
protected function setupAuth($request)
{
    $jwtUser = $this->tryJwtAuth($request);
    if ($jwtUser) {
        Auth::setUser($jwtUser);
    }
    return Auth::user();
}
```

#### 6.2 권한 확인
- **읽기 권한**: public, member, grade, admin, none
- **작성 권한**: public, member, grade, admin, none
- **수정 권한**: owner, member, grade, admin
- **삭제 권한**: owner, member, grade, admin

```php
protected function hasPermission($board, $action)
{
    $user = Auth::user();
    $permission = $board->{"permit_$action"} ?? 'public';

    // Admin/Super 회원은 모든 권한 허용
    if ($user && in_array($user->utype, ['admin', 'super'])) {
        return true;
    }

    // 권한별 처리...
}
```

#### 6.3 소유자 확인
```php
protected function isOwner($post)
{
    if (!Auth::check()) {
        return false;
    }

    $user = Auth::user();
    return $post->user_id == Auth::id() || ($user && $post->email == $user->email);
}
```

#### 6.4 조회수 관리
```php
protected function incrementViews($code, $id)
{
    // 게시글 조회수 증가
    DB::table("site_board_" . $code)
        ->where('id', $id)
        ->increment('click');

    // 게시판 총 조회수 증가
    DB::table('site_board')
        ->where('code', $code)
        ->increment('total_views');
}
```

### 7. 샤딩 지원

#### 7.1 컬럼 구조
- **uuid**: 게시글 고유 식별자
- **user_uuid**: 사용자 고유 식별자
- **shard_id**: 샤드 번호

#### 7.2 UUID 기반 조회
```php
protected function findPostByUuid($table, $uuid, $shardId = null)
{
    $query = DB::table($table)->where('uuid', $uuid);

    if ($shardId !== null && Schema::hasColumn($table, 'shard_id')) {
        $query->where('shard_id', $shardId);
    }

    return $query->first();
}
```

### 8. 라우팅 구조

#### 8.1 기본 라우트
```php
Route::middleware('web')->prefix('board')->name('board.')->group(function () {
    Route::get('/{code}', IndexController::class)->name('index');
    Route::get('/{code}/{id}', ShowController::class)->name('show');
    Route::get('/{code}/create', CreateController::class)->name('create');
    Route::post('/{code}', StoreController::class)->name('store');
    Route::get('/{code}/{id}/edit', EditController::class)->name('edit');
    Route::put('/{code}/{id}', UpdateController::class)->name('update');
    Route::delete('/{code}/{id}', DestroyController::class)->name('destroy');
    Route::get('/{code}/{id}/reply', CreateChildController::class)->name('reply');
});
```

#### 8.2 추가 라우트 (코멘트 및 평가)
```php
// 코멘트 관련 라우트
Route::post('/{code}/{postId}/comments', StoreCommentController::class)->name('comments.store');
Route::put('/{code}/comments/{commentId}', UpdateCommentController::class)->name('comments.update');
Route::delete('/{code}/comments/{commentId}', DestroyCommentController::class)->name('comments.destroy');

// 평가 관련 라우트 (AJAX)
Route::post('/{code}/{postId}/rating', StoreRatingController::class)->name('rating.store');
```

#### 8.3 UUID 기반 라우트 (샤딩 지원)
```php
Route::prefix('uuid')->name('uuid.')->group(function () {
    Route::get('/{code}/{uuid}', ShowController::class)->name('show');
    Route::get('/{code}/{uuid}/edit', EditController::class)->name('edit');
    Route::put('/{code}/{uuid}', UpdateController::class)->name('update');
    Route::delete('/{code}/{uuid}', DestroyController::class)->name('destroy');
});
```

## 관리자 기능

### 1. 게시판 통계
- **게시글 수**: 각 게시판별 총 게시글 수
- **총 조회수**: 게시판별 누적 조회수
- **코멘트 수**: 게시판별 총 코멘트 수
- **평가 통계**: 좋아요 수, 별점 평균
- **실시간 업데이트**: 글 조회 시 자동 증가

### 2. 게시판 설정
- 권한 관리 (읽기/쓰기/수정/삭제)
- 페이지당 게시물 수 설정
- 게시판별 레이아웃 설정

## 보안 기능

### 1. CSRF 보호
- 모든 POST/PUT/DELETE 요청에 CSRF 토큰 적용

### 2. XSS 방지
- 사용자 입력 내용 자동 이스케이프
- HTML 태그 필터링

### 3. 권한 검증
- 모든 액션에서 실시간 권한 확인
- JWT 토큰 검증
- 소유자 확인

## 성능 최적화

### 1. 데이터베이스 최적화
- 적절한 인덱스 설정
- 샤딩을 통한 분산 처리
- 조회수 증분 업데이트

### 2. 캐싱 전략
- 게시판 설정 정보 캐싱 가능
- 권한 정보 캐싱 가능

### 3. 페이지네이션
- 효율적인 페이징 처리
- 사용자 선택 가능한 페이지 크기

## 확장성

### 1. 플러그인 아키텍처
- 트레이트 기반 기능 확장
- Single Action Controller로 기능 추가 용이

### 2. 다중 게시판 지원
- 코드 기반 동적 테이블 생성
- 게시판별 독립적인 설정

### 3. 국제화 지원
- 다국어 인터페이스 준비
- 날짜/시간 로케일 지원

## 개발 가이드

### 1. 새 기능 추가
1. Single Action Controller 생성
2. BoardPermissions 트레이트 활용
3. 적절한 라우트 추가
4. 뷰 템플릿 작성

### 2. 권한 커스터마이징
- `BoardPermissions::hasPermission()` 메서드 확장
- 새로운 권한 레벨 추가 가능

### 3. 테스트
- 각 Controller별 단위 테스트
- 권한 시나리오 테스트
- JWT 인증 테스트

## 버전 정보
- **현재 버전**: 2.0
- **라라벨 호환성**: Laravel 12+
- **PHP 요구사항**: PHP 8.2+
- **JWT 지원**: Lcobucci/JWT 기반

## 변경 이력

### v2.0 (2025-10-08)
- Single Action Controller 패턴 적용
- JWT 인증 시스템 통합
- 샤딩 지원 추가 (UUID, user_uuid, shard_id)
- 계층형 답글 시스템 구현
- 독립적인 코멘트 시스템 추가
- 평가 시스템 구현 (좋아요/별점)
- 회원/비회원 평가 지원 (IP 기반)
- 실시간 통계 계산 기능
- 권한 시스템 고도화
- 관리자 통계 기능 추가
- AJAX 기반 평가 시스템

### v1.0 (이전)
- 기본 게시판 기능
- 세션 기반 인증
- 단일 컨트롤러 구조