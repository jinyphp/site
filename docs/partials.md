# partials
지니Site는 화면단위 작은 블럭으로 조각내여 결합을 할 수 있습니다.

## _partials 디렉터리
조각된 UI는 `_partials` 폴더안에 모아놓을 수 있습니다. 조각 파일은 `@partials()` 디렉티브를 통하여
blade에서 사용할 수 있습니다.

```php
@partials("hero_slider")
```
> 지정된 `slot` 안에 있는 `_partials` 폴더안에 있는 `hero_slider` 블레이더를 삽입합니다.

