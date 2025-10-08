# Welcome 페이지 컨트롤러

## 사전 작업: 중복 라우트 제거

패키지의 라우트를 사용하기 전에, 라라벨의 기본 라우트 파일에서 중복되는 루트(`/`) 라우트를 주석 처리해야 합니다.

**파일 위치:** `/routes/web.php`

```php
<?php
use Illuminate\Support\Facades\Route;

// 아래 기본 라우트를 주석 처리해야 합니다
// Route::get('/', function () {
//     return view('welcome');
// })->name('home');
```

> **중요:** 기본 `web.php`의 `/` 라우트와 패키지 라우트가 충돌하면 먼저 정의된 라우트가 우선 실행됩니다.

---

## WelcomeController 개요

`WelcomeController`는 사이트의 메인 페이지(홈페이지)를 출력하는 컨트롤러입니다.

**파일 위치:** `vendor/jiny/site/src/Http/Controllers/Welcome/WelcomeController.php`

**라우트 설정:** `vendor/jiny/site/routes/web.php`

```php
Route::get('/', \Jiny\Site\Http\Controllers\Welcome\WelcomeController::class)->name('home');
```

---

## 주요 기능

### 1. 방문 로그 기록
- `site_log` 테이블에 일별 방문 횟수를 자동으로 기록합니다
- `config('site.log.enabled')` 설정으로 활성화/비활성화 가능합니다

### 2. 뷰 우선순위 시스템
다음 순서로 뷰 파일을 검색하여 존재하는 첫 번째 뷰를 사용합니다:

1. **Slot 기반 뷰**: `www::{slot}.index`
2. **기본 www 뷰**: `www::index`
3. **테마 뷰**: `theme::{theme}.index`
4. **웰컴 뷰**: `welcome`
5. **패키지 기본 뷰**: `jiny-site::site.home.index`

### 3. 설정값 로드
컨트롤러 생성 시 다음 설정값을 자동으로 로드합니다:
- `site.layout`: 레이아웃 설정
- `site.theme`: 테마 이름
- `site.slot`: 슬롯 이름
- `site.log.enabled`: 로그 활성화 여부

---

## 실행 흐름

```
Route::get('/')
    ↓
WelcomeController::__invoke()
    ├─ 1. incrementVisitLog()     ← 방문 로그 증가
    ├─ 2. resolveView()            ← 뷰 우선순위 확인
    └─ 3. renderView()             ← 뷰 렌더링 및 반환
```

---

## 커스터마이징 방법

### 1. 테마 설정으로 뷰 변경

**config/site.php** 또는 **.env** 파일에서 설정:

```php
// config/site.php
return [
    'theme' => 'my-theme',  // theme::my-theme.index 뷰 사용
    'slot' => 'main',       // www::main.index 뷰 사용 (최우선)
];
```

### 2. 커스텀 뷰 파일 생성

**우선순위가 높은 순서:**

#### A. Slot 기반 커스터마이징 (최우선)
```
resources/views/www/{slot}/index.blade.php
```

#### B. 기본 www 뷰
```
resources/views/www/index.blade.php
```

#### C. 테마 뷰
```
resources/views/theme/{theme}/index.blade.php
```

#### D. 라라벨 기본 뷰
```
resources/views/welcome.blade.php
```

### 3. 로그 기능 비활성화

```php
// config/site.php
return [
    'log' => [
        'enabled' => false,
    ],
];
```

---

## 전달되는 데이터

뷰 파일에서 사용 가능한 변수:

```php
$config = [
    'layout' => 'index',
    'theme' => 'my-theme',
    'slot' => 'main',
    'log_enabled' => true,
];
```

**Blade 템플릿에서 사용 예시:**

```blade
@if($config['theme'])
    <div class="theme-{{ $config['theme'] }}">
        테마: {{ $config['theme'] }}
    </div>
@endif
```

---

## 데이터베이스 테이블

### site_log 테이블 구조

방문 로그 기록을 위해 다음 테이블이 필요합니다:

```sql
CREATE TABLE site_log (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    year VARCHAR(4),
    month VARCHAR(2),
    day VARCHAR(2),
    uri VARCHAR(255),
    cnt INTEGER DEFAULT 1,
    created_at DATETIME,
    updated_at DATETIME
);
```

- **year, month, day**: 방문 날짜
- **uri**: 방문한 URL (기본값: `/`)
- **cnt**: 해당 날짜의 방문 횟수

---

## 예제: 커스텀 홈페이지 만들기

### 1단계: 뷰 파일 생성

`resources/views/www/index.blade.php` 파일 생성:

```blade
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>환영합니다</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold">환영합니다!</h1>
        <p class="mt-4">사이트 테마: {{ $config['theme'] ?? '기본' }}</p>
    </div>
</body>
</html>
```

### 2단계: 설정 확인

`config/site.php`에서 설정이 올바른지 확인:

```php
return [
    'layout' => 'index',
    'theme' => null,  // 또는 원하는 테마 이름
    'slot' => null,   // 또는 원하는 슬롯 이름
    'log' => [
        'enabled' => true,
    ],
];
```

### 3단계: 라우트 확인

패키지 라우트가 정상적으로 로드되는지 확인:

```bash
php artisan route:list --name=home
```

예상 출력:
```
GET|HEAD  /  home  Jiny\Site\Http\Controllers\Welcome\WelcomeController
```

---

## 문제 해결

### 404 오류 발생 시

1. **라우트 충돌 확인**
   - `/routes/web.php`에서 `/` 라우트가 주석 처리되었는지 확인

2. **패키지 라우트 로드 확인**
   - 패키지 서비스 프로바이더가 로드되는지 확인
   - `php artisan route:list` 명령으로 라우트 목록 확인

3. **캐시 클리어**
   ```bash
   php artisan route:clear
   php artisan config:clear
   php artisan cache:clear
   ```

### 뷰를 찾을 수 없다는 오류 발생 시

1. **뷰 파일 경로 확인**
   - 우선순위에 맞는 뷰 파일이 존재하는지 확인

2. **패키지 기본 뷰 확인**
   - `vendor/jiny/site/resources/views/site/home/index.blade.php` 존재 확인

3. **뷰 캐시 클리어**
   ```bash
   php artisan view:clear
   ```

---

## 참고사항

- 이 컨트롤러는 **단일 액션 컨트롤러**(Single Action Controller)로 `__invoke()` 메서드를 사용합니다
- `SiteService`는 의존성 주입(Dependency Injection)을 통해 자동으로 주입됩니다
- 방문 로그는 일별로 집계되며, 동일 날짜의 방문은 카운트가 증가합니다
- 뷰 우선순위 시스템을 통해 패키지를 수정하지 않고도 커스터마이징이 가능합니다
