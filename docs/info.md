# 사이트 정보
사이트 구성에 필요한 정보들을 관리합니다. 지니Site는 사이트의 디자인과 정보를 분리하여 다양한 UI변경하여도 정보 데이터는 그대로 유지할 수 있는 장점이 있습니다.

## json 정보
사이트 정보는 모든 slot에서 공용으로 사용되는 데이터 입니다. 따라서 `resource/www` 위치안에 json 파일로 저장됩니다. 이 파일은 admin/site 페이지에서 관리할 수도 있으며, 콘솔에서 직접 파일을 수정할 수도 있습니다.

* info.json
* setting.json
* header.json
* footer.json

## 헬퍼함수
사이트 정보를 쉽게 페이지에 사용할 수 있도록 각각의 json 파일에 대한 헬퍼함수를 제공합니다. 헬퍼함수는 싱글턴으로 제작된 객체를 관리하고, 싱글턴 객체는 정보파일을 중복 읽기를 하지 않고, 캐시로 필요할때마다 정보를 반환합니다.

### info()
`info.json` 파일을 읽고 관리합니다.

```php
사이트 브렌드 : {{\Jiny\Site\Info('brand')}}
```

### setting()
`setting.json` 파일을 읽고 관리합니다.

```php
사이트 브렌드 : {{\Jiny\Site\Setting('brand')}}
```

### Header()
다음처럼 `header.json` 파일의 정보를 읽어 올 수 있습니다. 
```php
{{ \Jiny\Site\Header('brand') }}
```

### Footer()
다음처럼 `footer.json` 파일의 정보를 읽어 올 수 있습니다. 
```php
{{ \Jiny\Site\Footer('brand') }}
```
