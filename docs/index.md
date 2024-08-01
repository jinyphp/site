# Site

## slot
지니Site는 slot과 컴포넌트, 조각파일을 이용하여 다체로운 화면을 구현할 수 있습니다.

### slot이란?
지니Site만의 고유한 UI 리소스처리 기술입니다. 웹사이트는 지속적으로 UI유지보수의 디자인 변화를 추구합니다. 하지만, 기존 라라벨은 `resources/views` 하나로 Blade 파일 경로가 고정되어 있습니다.

반면에 지니Site는 `resources/www`를 추가로 생성하고, 서브로 다수의 `slot`폴더를 만들어서 UI의 진입점을 실시간으로 변경을 할 수 있습니다. 이는 MVC패턴에서 View를 좀더 동적으로 다양하게 진입 포인트를 관리합니다. 

### 동적 컴포넌트

```php
<x-www_컴포넌트>
</x-www_컴포넌트>
```

### 조각파일

```php
@partials()
```

## Controllers
지니Site는 `www`의 slot 리소스를 통하여 Site를 보다 쉽게 구현할 할 수 있는 컨트롤러를 제공합니다.

### SiteController 
`SiteController`는 `Actions`값을 기반으로 페이지를 구현할 수 있는 컨트롤러 입니다.

컨트롤러의 기능을 모두 사용하기 위해서는 먼저 생성자를 통하여 상위 초기화를 진행합니다.
```php
public function __construct()
{
    parent::__construct();
    $this->setVisit($this);

    // 추가코드
}
```
