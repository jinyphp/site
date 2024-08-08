# Site
`jiny/site`는 사이트 제작 및 컨덴츠 관리를 위한 CMS 페키지 입니다.

## 설치
컴포저를 이용하여 설치합니다.

```bash
composer require jiny/site
```

## 주요특징


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
