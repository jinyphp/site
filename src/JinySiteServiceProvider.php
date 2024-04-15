<?php

namespace Jiny\Site;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;

class JinySiteServiceProvider extends ServiceProvider
{
    private $package = "jiny-site";
    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        $this->resourceSetting();

        Blade::component($this->package.'::components.'.'site_setting', 'site-setting');

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
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {
            Livewire::component('site-session-slot',
                \Jiny\Site\Http\Livewire\SiteSessionSlot::class);
            Livewire::component('site-slot-setting',
                \Jiny\Site\Http\Livewire\SiteSlotSetting::class);
            Livewire::component('site-userslot-setting',
                \Jiny\Site\Http\Livewire\SiteUserSlotSetting::class);
        });
    }
}
