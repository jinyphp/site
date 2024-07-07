# SiteController
`SiteController`를 통하여 보다 쉽게 페이지를 구현할 수 있습니다.

## 라우트설정
url 접속에 응답할 수 있는 라우트 경로를 생성합니다.

예시로 `/routes/web.php`에 다음과 같이 라우트를 추가할 수 있습니다.
예시)
```php
// 사이트 접속
Route::middleware(['web'])->group(function () {
    Route::get('/about2', [
        \App\Http\Controllers\SiteAboutPage::class,
        "index"]);
});
```

## 컨트롤러
컨트롤러를 생성하여 페이지를 생성할 수 있습니다.

### 컨트롤러 예시
`SiteController`를 상속하여 페이지를 만들수 있습니다.
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use Jiny\Site\Http\Controllers\SiteController;
class SiteAboutPage extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        // 메인 내용
        $this->actions['view']['main'] = "jiny-site::site.about";

    }

}
```

### main 컨덴츠 설정

생성자 `__construct()`에 출력할 내용의 blade를 지정할 수 있습니다.
```php
$this->actions['view']['main'] = "jiny-site::site.about";
```

배열값을 통하여 section별로 main 내용을 분리하여 출력할 수 있습니다.

```php
// 메인 내용
$this->actions['view']['main'] []= "jiny-site::site.about";
$this->actions['view']['main'] []= "jiny-site::site.about2";
```


## 레이아웃
`SiteController`는 레이아웃을 기본 선택한 후에, `actions` 값을 통하여 페이지의 내용을 변경하는 방식으로 페이지를 출력합니다.

* jiny-site::www.layout
* jiny-site::www.container

### 기본 레이아웃
SiteController는 기본적으로 `jiny-site::www.layout`를 기반으로 화면을 출력합니다. 

그 내용은 다음과 같습니다.
```php
<x-www-layout>
    <main>
        @if(isset($actions['view']['main']))
            @if(is_array($actions['view']['main']))
                @foreach ($actions['view']['main'] as $section)
                <section>
                    @includeIf($section)
                </section>
                @endforeach
            @else
                @includeIf($actions['view']['main'])
            @endif
        @else
        <div class="alert alert-danger" role="alert">
            컨트롤러에서 출력할 main 화면이 지정되어 있지 않습니다.
        </div>
        @endif
    </main>
</x-www-layout>
```

### 커스텀 변경하기
만일 이 스타일의 레이아웃을 변경하고자 하는 경우, 별도의 레이 아웃 파일을 만들고 `actions` 정보에 경로를 재설정하면 됩니다.

```php
// 레이아웃을 변경하고자 할 경우
$this->actions['view']['layout'] = "";
```

또는 `setLayout()` 메소드를 이용하여 변경할 수도 있습니다.

```php
$this->setLayout("jiny-site::www.container");
```

