<?php

namespace Jiny\Site;

use Illuminate\Support\ServiceProvider;

class JinySiteServiceProvider extends ServiceProvider
{
    private $package = "jiny-site";
    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        $this->resourceSetting();

    }

    private function resourceSetting()
    {
        // Custom Site Resources
        $path = resource_path('www');
        if(!is_dir($path)) {
            mkdir($path,0777,true);
        }
        $this->loadViewsFrom($path, 'www');

        if(!is_dir($path."/slot1")) {
            mkdir($path."/slot1",0777,true);
        }
        $this->loadViewsFrom($path."/slot1", 'www1');
    }

    public function register()
    {

    }
}
