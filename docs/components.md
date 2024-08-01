# 동적 컴포넌트
동적 컴포넌트는 크게 2종류를 지원합니다. `slot`에서 정의한 동적 컴포넌트와 `www`리소스안에 있는 공용 동적 컴포넌트 입니다.

* 공용 컴포넌트
* 슬롯 컴포넌트

## 공용 동적 컴포넌트
모든 `slot`에서 공용으로 사용되어야 하는 동적 컴포넌트를 의미합니다. 동적 컴포넌트는 `resources/www/_components` 폴더 `blade`를 생성하면 됩니다.


## Slot 동적 컴포넌트
슬롯 동적 컴포넌트는 slot별로 적용되는 컴포넌트를 의미합니다. 각각의 slot마다 다르게 처리해야 되는 컴포넌트가 있을 경우 매우 유용합니다.

### 동적 컴포넌트
siteSlot은 `_components`폴더안에 있는 blade를 동적 컴포넌트로 변환하여 slot내에서 재사용 가능하도록 합니다.

예를들어 다음과 같이 `navbar-brand.blade.php`파일을 생성합니다.
```php
<a class="navbar-brand fs-2 py-0 m-0 me-auto me-sm-n5"
  href="/">
  {{$slot}}
</a>
```

`_components` 폴더안에 있는 blade는 동일한 이름으로 `x-www_파일명`형태로 컴포넌트화 할 수 있습니다.
```php
<x-www_navbar-brand>
    JinyShop
</x-www_navbar-brand>
```

> 즉, `x-www_`로 시작하면 slot내의 동적 컴포넌트라고 생각하시면 됩니다.

