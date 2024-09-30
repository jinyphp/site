# jiny/Site
라라벨 기반의 JinyPHP 환경에서 웹사이트를 구축할 수 있는 확장 페키지 입니다.

## 설치
컴포저를 통하여 의존되는 모든 패키지들을 한번에 설치가 가능합니다.

```bash
composer require jiny/site
```

> `jiny/site`를 설치하는 과정에서 필요로 하는 모든 jinyPHP 패키지를 검색하여 통합 설치가 진행됩니다.

### 데이터베이스
지니Site는 사이트의 컨덴츠를 관계형 데이터베이스와 json 환경설정을 통하여 기능별로 구분하여 관리합니다. `artisan` 명령을 통하여 필요한 테이블을 생성합니다.

```bash
php artisan migrate
```
> `artisan`명령은 라라벨에서 제공되는 콘솔관리 도구 입니다.

### 리소스 복사
빠른 웹사이트 제작을 위하여 기본 데모 사이트를 제공합니다.

```bash
php artisan vendor:publish --tag=site
```

데모 사이트의 컨덴츠가 `resources/www/slot1`으로 복사됩니다. 지니사이트는 가상 view 포인트 기능을 통하여 다양한 slot을 관리할 수 있습니다.

복사된 데모 사이트로 활성 slot을 변경합니다.

```bash
php artisan site:slot slot1
```
> slot 기능에 대한 보다 자세한 부분은 공식 문서를 참고해 주세요

### 관리자 등록
웹사이트 관리를 위하여 admin 페이지를 제공합니다. admin 접속을 하기 위해서는 회원가입과 관리자 등급 변경을 해주어야 합니다. 관리자 설정을 위한 콘솔 명령을 제공합니다.

```bash
php artisan user:admin 이메일 --enable
php artisan user:super 이메일 --enable
```

## 주요기능

### 가상뷰

### 리소스
레이아웃의 리소스들들 `_layouts` 폴더 안에 지정합니다.
> `_`로 시작되는 폴더 또는 파일의 리소스는 시스템과 연관된 파일로 자동 라우팅 처리가 되지 않습니다.

먼저 slot의 리소스를 읽고-> 테마의 리소스를 그 다음으로 읽습니다.
