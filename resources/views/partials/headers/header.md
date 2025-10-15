# headers
사이트에 적용되는 헤더의 종류

## 사용 가능한 헤더 타입

### 1. 기본 헤더
- **header.blade.php** - 표준 사이트 헤더 (기본값)
- **header-default.blade.php** - 기본 네비게이션과 쇼핑카트, 로그인 버튼이 있는 헤더

### 2. 레이아웃별 헤더
- **header-classic.blade.php** - 클래식한 디자인의 헤더
- **header-simple.blade.php** - 간소한 네비게이션 헤더
- **header-second.blade.php** - 보조 페이지용 헤더
- **header-horizontal.blade.php** - 가로형 메뉴 레이아웃 헤더

### 3. 수직 메뉴 헤더
- **header-vertical.blade.php** - 세로형 메뉴가 있는 헤더
- **header-vertical-compact.blade.php** - 컴팩트한 세로형 메뉴 헤더

### 4. 특수 목적 헤더
- **header-login.blade.php** - 로그인 페이지 전용 헤더 (테마 토글 포함)
- **header-job.blade.php** - 채용/구인 페이지용 헤더
- **header-doc.blade.php** - 문서/도움말 페이지용 헤더
- **header-help-center.blade.php** - 고객 지원 센터용 헤더

### 5. 사용자 역할별 헤더
- **header-student.blade.php** - 학생 전용 헤더
- **header-instructor.blade.php** - 강사 전용 헤더
- **header-mentor.blade.php** - 멘토 전용 헤더

## 주요 특징

### 공통 기능
- 반응형 디자인 (모바일/데스크톱 지원)
- Bootstrap 기반 네비게이션
- 브랜드 로고 표시

### 특별 기능별 분류
- **쇼핑 기능**: header-default.blade.php (장바구니 아이콘)
- **테마 토글**: header-login.blade.php, header-job.blade.php (다크/라이트 모드)
- **언어 선택**: header-default.blade.php (다국어 지원)
- **검색 기능**: 일부 헤더에 검색 폼 포함
- **알림 기능**: 사용자별 헤더에 알림 드롭다운

## 사용 방법

```blade
{{-- 기본 헤더 사용 --}}
@include('partials.headers.header')

{{-- 특정 헤더 사용 --}}
@include('partials.headers.header-login')

{{-- 조건부 헤더 사용 --}}
@include('partials.headers.header-' . (auth()->check() ? 'student' : 'default'))
```

## 파일 구조
```
partials/headers/
├── header.blade.php (기본)
├── header-default.blade.php
├── header-classic.blade.php
├── header-simple.blade.php
├── header-login.blade.php
├── header-job.blade.php
├── header-student.blade.php
├── header-instructor.blade.php
├── header-mentor.blade.php
├── header-doc.blade.php
├── header-help-center.blade.php
├── header-horizontal.blade.php
├── header-vertical.blade.php
├── header-vertical-compact.blade.php
├── header-second.blade.php
├── header.md (이 파일)
└── README.md (상세 문서)
```
