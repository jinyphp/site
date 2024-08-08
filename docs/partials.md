# partials
jinySite는 다양한 화면을 구성하기 위하여 작은 단위의 블럭 조각을 활용하여 큰 화면을 구현할 수 있는 기능을 제공합니다.


## `@partials` 디렉티브

`@partials`는 라라벨의 `@include`와 비슷한 동작을 하지만, Slot을 자동으로 분석하여 외부 blade 파일을 삽입할 수 있는 장점이 있습니다.

### 인자 전달

```php
@partials("hero_slider",['rows'=>getSlider(5))
```

## _partials 디렉터리
작은 조각들은 www 안에 특수한 `_partials` 폴더로 관리합니다. `_partials`는 크게 공용 파트와 slot 파트로 구분됩니다.

### slot 파트
각각의 슬롯 안에 존재하는 `_partials` 폴더를 의미합니다. 이 파일은 `@partials()` 디렉티브를 이용하여 쉽게 호출할 수 있습니다.

```php
@partials("hero_slider")
```
> 지정된 `slot` 안에 있는 `_partials` 폴더안에 있는 `hero_slider` 블레이더를 삽입합니다.

### 공용 파트
www 리소스 안에 존재하는 `_partials` 폴더를 의미합니다. 공용 파트를 호출할때에는 상위 루트를 의미하는 `..`기호를 붙여서 호출합니다.

```php
@partials("..login.form")
```
> 공용 `_partials` 위치에서 `login`폴더 안에 있는 `form.blade.php`를 읽어 오게 됩니다.





