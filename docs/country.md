# 국가설정
다양한 지역을 지원해야 하는 웹사이트의 경우, 국가를 선택하여 사이트의 동작을 변경할 수 있습니다.

## 국가 목록
다음과 같이 라이브컴포넌트를 삽입하게 되면, 국가를 선택할 수 있습니다.

```php
@livewire('site-country')
```

> 관리자페이지 : admin/site/country

## location
국가별로 세부 지역을 선택할 수 있는 계층형 컴포넌트 입니다. 선택한 국가에 의존한 지역목록을 출력합니다.

```php
@livewire('site-location')
```
