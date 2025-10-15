# Help Support 시스템 문서

## 개요

Help Support 시스템은 사용자가 기술 지원, 문의사항, 버그 신고 등의 요청을 제출하고 관리할 수 있는 종합적인 고객 지원 플랫폼입니다. Laravel 프레임워크 기반으로 구축되었으며, Single Action Controller 패턴을 사용하여 명확하고 유지보수 가능한 코드 구조를 제공합니다.

## 주요 기능

### 사용자 기능
- ✅ **지원 요청 제출**: 다양한 유형의 지원 요청 제출 (첨부파일 지원)
- ✅ **내 요청 관리**: 개인이 제출한 요청 목록 조회 및 관리
- ✅ **요청 수정**: 대기중(pending) 상태의 요청 수정
- ✅ **요청 삭제**: 대기중(pending) 상태의 요청 삭제
- ✅ **상태 추적**: 요청 처리 과정 실시간 추적
- ✅ **검색 및 필터**: 상태별, 유형별 필터링 및 키워드 검색

### 관리자 기능
- ✅ **통계 대시보드**: 요청 상태별 통계 정보 제공
- 🔄 **요청 관리**: 요청 상태 변경 및 처리 (구현 예정)
- 🔄 **데이터 내보내기**: CSV, Excel 형태로 데이터 내보내기 (구현 예정)
- 🔄 **답변 관리**: 요청에 대한 답변 작성 및 관리 (구현 예정)

## 시스템 아키텍처

### 디렉토리 구조

```
vendor/jiny/site/
├── src/Http/Controllers/Site/Help/Support/
│   ├── IndexController.php        # 지원 요청 폼 및 제출 처리
│   ├── MyController.php          # 내 지원 요청 목록
│   ├── EditController.php        # 지원 요청 수정
│   ├── DeleteController.php      # 지원 요청 삭제
│   └── SuccessController.php     # 제출 성공 페이지
├── src/Http/Controllers/Admin/Support/
│   ├── StatisticsController.php  # 관리자 통계
│   └── ExportController.php      # 데이터 내보내기
├── src/Models/
│   └── SiteSupport.php          # 지원 요청 모델
├── databases/migrations/
│   └── 2024_10_09_120000_create_site_support_table.php
└── resources/views/www/help/support/
    ├── index.blade.php          # 지원 요청 폼
    ├── my.blade.php            # 내 요청 목록
    ├── edit.blade.php          # 요청 수정 폼
    └── success.blade.php       # 제출 성공 페이지
```

### 데이터베이스 스키마

#### site_support 테이블

| 필드명 | 타입 | 설명 |
|--------|------|------|
| id | BIGINT(PK) | 고유 식별자 |
| enable | BOOLEAN | 활성화 상태 |
| user_id | BIGINT(FK) | 사용자 ID (nullable) |
| name | VARCHAR(255) | 신청자 이름 |
| email | VARCHAR(255) | 신청자 이메일 |
| phone | VARCHAR(20) | 전화번호 (nullable) |
| company | VARCHAR(255) | 회사명 (nullable) |
| type | ENUM | 지원 유형 |
| subject | VARCHAR(255) | 제목 |
| content | TEXT | 내용 |
| priority | ENUM | 우선순위 |
| status | ENUM | 처리 상태 |
| attachments | JSON | 첨부파일 정보 (nullable) |
| admin_notes | TEXT | 관리자 메모 (nullable) |
| resolved_at | TIMESTAMP | 해결 일시 (nullable) |
| ip_address | VARCHAR(45) | 요청자 IP |
| user_agent | TEXT | 브라우저 정보 (nullable) |
| referrer | TEXT | 리퍼러 URL (nullable) |
| created_at | TIMESTAMP | 생성일시 |
| updated_at | TIMESTAMP | 수정일시 |

#### ENUM 값 정의

**type (지원 유형)**
- `technical`: 기술 지원
- `inquiry`: 일반 문의
- `bug_report`: 버그 신고
- `feature_request`: 기능 요청
- `account`: 계정 관련
- `other`: 기타

**priority (우선순위)**
- `urgent`: 긴급
- `high`: 높음
- `normal`: 보통 (기본값)
- `low`: 낮음

**status (처리 상태)**
- `pending`: 대기중 (기본값)
- `in_progress`: 처리중
- `resolved`: 해결됨
- `closed`: 종료됨

## 컨트롤러 상세 분석

### Frontend Controllers

#### 1. IndexController
**역할**: 지원 요청 폼 표시 및 제출 처리

**메소드 호출 트리**:
```
__invoke(Request $request)
├── GET 요청 시: showForm(Request $request)
│   ├── Auth::user() - 현재 사용자 정보 조회
│   └── view() - 지원 요청 폼 뷰 반환
└── POST 요청 시: handleSubmit(Request $request)
    ├── validateRequest(Request $request)
    │   └── Validator::make() - 입력 데이터 유효성 검증
    ├── createSupportRequest(Request $request)
    │   ├── Auth::user() - 사용자 정보 조회
    │   ├── 파일 업로드 처리 (첨부파일이 있는 경우)
    │   │   └── $file->storeAs() - 파일 저장
    │   └── SiteSupport::create() - 지원 요청 데이터베이스 저장
    └── redirect() - 성공 페이지로 리다이렉트
```

**주요 기능**:
- 로그인/비로그인 사용자 모두 지원 요청 가능
- 파일 첨부 기능 (최대 10MB)
- 유효성 검증 및 에러 처리
- 세션을 통한 성공 페이지 데이터 전달

#### 2. MyController
**역할**: 사용자의 지원 요청 목록 조회

**메소드 호출 트리**:
```
__invoke(Request $request)
├── Auth::user() - 현재 사용자 정보 조회
├── 인증 확인 (비로그인 시 로그인 페이지로 리다이렉트)
├── SiteSupport 쿼리 빌더 생성
│   ├── where('user_id', $user->id) - 사용자별 필터링
│   └── orderBy('created_at', 'desc') - 최신순 정렬
├── 요청 파라미터에 따른 필터링
│   ├── status 필터 (요청 시)
│   ├── type 필터 (요청 시)
│   └── search() - 검색 기능 (요청 시)
├── paginate() - 페이지네이션 적용
├── 상태별 카운트 조회
└── view() - 목록 뷰 반환
```

**주요 기능**:
- 로그인 필수
- 상태별/유형별 필터링
- 키워드 검색
- 페이지네이션
- 상태별 통계 제공

#### 3. EditController
**역할**: 지원 요청 수정

**메소드 호출 트리**:
```
__invoke(Request $request, $id)
├── Auth::user() - 현재 사용자 정보 조회
├── 인증 확인 (비로그인 시 로그인 페이지로 리다이렉트)
├── SiteSupport::where() - 해당 ID와 사용자 ID로 지원 요청 조회
├── isEditable() - 수정 가능 상태 확인
├── GET 요청 시: showEditForm($support)
│   └── view() - 수정 폼 뷰 반환
└── POST 요청 시: handleUpdate(Request $request, $support)
    ├── validateRequest(Request $request)
    │   └── Validator::make() - 입력 데이터 유효성 검증
    ├── updateSupport(Request $request, $support)
    │   └── $support->update() - 지원 요청 데이터 업데이트
    └── redirect() - 내 지원 요청 목록으로 리다이렉트
```

**비즈니스 규칙**:
- 본인이 작성한 요청만 수정 가능
- pending 상태의 요청만 수정 가능
- 첨부파일은 수정 불가 (보안상 이유)

#### 4. DeleteController
**역할**: 지원 요청 삭제

**메소드 호출 트리**:
```
__invoke(Request $request, $id)
├── Auth::user() - 현재 사용자 정보 조회
├── 인증 확인 (비로그인 시 로그인 페이지로 리다이렉트)
├── SiteSupport::where() - 해당 ID와 사용자 ID로 지원 요청 조회
├── isDeletable() - 삭제 가능 상태 확인
├── $support->delete() - 지원 요청 삭제 실행
└── 응답 형태에 따른 결과 반환
    ├── JSON 응답 (AJAX 요청)
    └── 리다이렉트 응답 (일반 요청)
```

**특징**:
- AJAX 및 일반 요청 모두 지원
- JSON과 HTML 응답 자동 선택

#### 5. SuccessController
**역할**: 지원 요청 제출 성공 페이지

**메소드 호출 트리**:
```
__invoke(Request $request)
├── session('support_id') - 세션에서 지원 요청 ID 조회
├── session('success') - 세션에서 성공 메시지 조회
└── view() - 성공 페이지 뷰 반환
```

### Admin Controllers

#### 1. StatisticsController
**역할**: 관리자 통계 정보 제공

**메소드 호출 트리**:
```
__invoke(Request $request)
├── SiteSupport::count() - 전체 지원 요청 수 조회
├── SiteSupport::where('status', 'pending')->count() - 대기중 요청 수
├── SiteSupport::where('status', 'in_progress')->count() - 처리중 요청 수
├── SiteSupport::where('status', 'resolved')->count() - 해결됨 요청 수
├── SiteSupport::where('status', 'closed')->count() - 종료됨 요청 수
└── view() - 통계 페이지 뷰 반환
```

#### 2. ExportController
**역할**: 데이터 내보내기 (구현 예정)

**구현 예정 기능**:
- CSV 형태로 지원 요청 데이터 내보내기
- Excel 형태 내보내기
- 날짜 범위별 필터링
- 상태별 필터링

## 모델 분석

### SiteSupport 모델

#### 주요 메소드

**관계 정의**:
```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

**헬퍼 메소드**:
```php
// 수정 가능 상태 확인
public function isEditable(): bool
{
    return $this->status === 'pending';
}

// 삭제 가능 상태 확인
public function isDeletable(): bool
{
    return $this->status === 'pending';
}

// 상태 변경
public function markAsInProgress(): bool
public function markAsResolved(): bool
public function markAsClosed(): bool
```

**스코프**:
```php
// 키워드 검색
public function scopeSearch($query, $keyword)
{
    return $query->where(function ($q) use ($keyword) {
        $q->where('subject', 'like', '%' . $keyword . '%')
          ->orWhere('content', 'like', '%' . $keyword . '%');
    });
}

// 상태별 필터
public function scopeByStatus($query, $status)
public function scopeByType($query, $type)
public function scopeByPriority($query, $priority)
```

**액세서**:
```php
// 우선순위 라벨
public function getPriorityLabelAttribute(): string

// 상태 라벨
public function getStatusLabelAttribute(): string

// 유형 라벨
public function getTypeLabelAttribute(): string

// 첨부파일 개수
public function getAttachmentsCountAttribute(): int
```

## 라우팅

### Frontend Routes
```php
// 지원 요청 제출
Route::get('/help/support', [IndexController::class, '__invoke'])->name('help.support.index');
Route::post('/help/support', [IndexController::class, '__invoke'])->name('help.support.store');

// 성공 페이지
Route::get('/help/support/success', [SuccessController::class, '__invoke'])->name('help.support.success');

// 내 요청 관리 (로그인 필요)
Route::middleware(['auth'])->group(function () {
    Route::get('/help/support/my', [MyController::class, '__invoke'])->name('help.support.my');
    Route::get('/help/support/{id}/edit', [EditController::class, '__invoke'])->name('help.support.edit');
    Route::post('/help/support/{id}/edit', [EditController::class, '__invoke'])->name('help.support.update');
    Route::delete('/help/support/{id}', [DeleteController::class, '__invoke'])->name('help.support.delete');
});
```

### Admin Routes
```php
// 관리자 기능 (admin 미들웨어 적용)
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/support/statistics', [StatisticsController::class, '__invoke'])->name('admin.support.statistics');
    Route::get('/support/export', [ExportController::class, '__invoke'])->name('admin.support.export');
});
```

## 보안 고려사항

### 인증 및 권한
- **Frontend**: 로그인 없이도 지원 요청 제출 가능
- **내 요청 관리**: `auth` 미들웨어로 로그인 사용자만 접근
- **Admin 기능**: `admin` 미들웨어로 관리자만 접근

### 데이터 보호
- **본인 요청만 접근**: 사용자 ID 기반 필터링
- **상태 검증**: 수정/삭제 전 상태 확인
- **파일 업로드 보안**:
  - 파일 크기 제한 (10MB)
  - 저장 경로 보안 (public/support/attachments)
  - 고유한 파일명 생성

### 입력 검증
- **서버사이드 검증**: Laravel Validator 사용
- **필수 필드 검증**: 이름, 이메일, 유형, 제목, 내용
- **형식 검증**: 이메일 형식, 선택 값 검증

## 성능 최적화

### 데이터베이스 최적화
- **인덱스**: user_id, status, type, created_at 컬럼
- **페이지네이션**: 대용량 데이터 처리
- **선택적 로딩**: 필요한 관계만 로드

### 파일 관리
- **저장소 분리**: public 디스크 사용
- **파일명 중복 방지**: 타임스탬프 기반 고유명 생성

## 확장 계획

### 단기 계획
1. **관리자 요청 관리 기능**
   - 요청 상태 변경
   - 답변 작성 및 관리
   - 요청 배정 시스템

2. **데이터 내보내기 기능**
   - CSV/Excel 내보내기
   - 필터링 옵션 확장

3. **알림 시스템**
   - 이메일 알림
   - 상태 변경 알림

### 장기 계획
1. **실시간 채팅 지원**
2. **파일 미리보기 기능**
3. **자동 분류 시스템**
4. **FAQ 연동**
5. **다국어 지원**

## 문제 해결 가이드

### 자주 발생하는 문제

#### 1. 미들웨어 오류
**문제**: `Call to undefined method middleware()`

**해결방법**: Single Action Controller에서는 생성자에서 미들웨어를 설정하지 않고 라우트에서 설정

#### 2. 파일 업로드 실패
**확인사항**:
- `storage/app/public` 디렉토리 권한
- `storage` 링크 생성 여부: `php artisan storage:link`
- 파일 크기 제한 설정

#### 3. 검색 기능 동작 안함
**확인사항**:
- SiteSupport 모델의 `search` 스코프 구현
- 데이터베이스 인덱스 설정

## 테스트 가이드

### 기능 테스트 시나리오

#### 사용자 기능 테스트
1. **지원 요청 제출**
   - 필수 필드 입력 후 제출
   - 첨부파일과 함께 제출
   - 유효성 검증 오류 확인

2. **내 요청 관리**
   - 목록 조회
   - 상태별 필터링
   - 키워드 검색
   - 요청 수정/삭제

#### 관리자 기능 테스트
1. **통계 조회**
   - 상태별 통계 정확성 확인

### 성능 테스트
- 대용량 데이터 페이지네이션 테스트
- 파일 업로드 성능 테스트
- 동시 접속 테스트

## API 문서

### JSON 응답 형식

#### 성공 응답
```json
{
    "success": true,
    "message": "지원 요청이 성공적으로 삭제되었습니다.",
    "data": {}
}
```

#### 오류 응답
```json
{
    "success": false,
    "message": "이미 처리 중이거나 완료된 요청은 삭제할 수 없습니다.",
    "errors": {}
}
```

## 결론

Help Support 시스템은 사용자와 관리자 모두를 위한 포괄적인 고객 지원 솔루션을 제공합니다. Single Action Controller 패턴을 통해 명확한 코드 구조를 유지하며, 확장 가능한 아키텍처로 설계되었습니다. 지속적인 개발을 통해 더 많은 기능과 개선사항이 추가될 예정입니다.