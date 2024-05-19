<?php

namespace Jiny\Site;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\Facades\File;
use Livewire\Livewire;

class JinySiteServiceProvider extends ServiceProvider
{
    private $package = "jiny-site";
    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // 데이터베이스
        $this->loadMigrationsFrom(__DIR__.'/../databases/migrations');

        $this->resourceSetting();

        Blade::component($this->package.'::components.'.'easy_setting', 'easy-setting');

        /* 컴포넌트 */
        Blade::component(\Jiny\Site\View\Components\App::class, "www-app");
        Blade::component(\Jiny\Site\View\Components\Layout::class, "www-layout");

        Blade::component(\Jiny\Site\View\Components\Header::class, "www-header");
        Blade::component(\Jiny\Site\View\Components\Brand::class, "www-brand");
        Blade::component(\Jiny\Site\View\Components\Navbar::class, "www-nav");
        Blade::component(\Jiny\Site\View\Components\Footer::class, "www-footer");

        Blade::component(\Jiny\Site\View\Components\Main::class, "www-main");
        Blade::component(\Jiny\Site\View\Components\Content::class, "www-content");
        Blade::component(\Jiny\Site\View\Components\Sidebar::class, "www-sidebar");
        Blade::component(\Jiny\Site\View\Components\Rightbar::class, "www-rightbar");

        Blade::component(\Jiny\Site\View\Components\Menu::class, "www-menu");

        Blade::component(\Jiny\Site\View\Components\Home::class, "www-home");
        Blade::component(\Jiny\Site\View\Components\Page::class, "www-page");
        Blade::component(\Jiny\Site\View\Components\Docs::class, "www-docs");
        Blade::component(\Jiny\Site\View\Components\Markdown::class, "www-markdown");

        $this->dynamicComponents();


        // 디렉티브
        Blade::directive('www_slot_include', function ($expression) {
            $args = str_getcsv($expression);
            $themeFile = trim($args[0], '\'"');
            $themeVariables = isset($args[1]) ? trim($args[1], '\'"') : '';

            $base = resource_path('www');
            $base .= DIRECTORY_SEPARATOR;
            $slot = www_slot();

            $themePath = DIRECTORY_SEPARATOR.$slot.DIRECTORY_SEPARATOR."_includes".DIRECTORY_SEPARATOR.$themeFile;
            if(file_exists($base.$themePath.".blade.php")) {
                $themeContent = File::get($base.$themePath.".blade.php");
            } else
            if(file_exists($base.$themePath.".html")) {
                $themeContent = File::get($base.$themePath.".html");
            } else {
                $themeContent = "can't read ".$themePath;
            }

            // 변수를 템플릿에 전달하고 컴파일된 결과를 반환합니다.
            return Blade::compileString($themeContent, $themeVariables);
        });

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

    // _components 안에 있는 파일들을 동적으로 컴포넌트화 합니다.
    private function dynamicComponents()
    {

        $base = resource_path('www');
        $base .= DIRECTORY_SEPARATOR;
        $slot = www_slot();

        $path = $base.DIRECTORY_SEPARATOR.$slot;
        $path .= DIRECTORY_SEPARATOR."_components";

        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $dir = scandir($path);
        foreach($dir as $file) {
            if($file == '.' || $file == '..') continue;
            if($file[0] == '.') continue; // 숨김파일

            if(substr($file, -10) === '.blade.php') {
                $name = substr($file, 0, strlen($file)-10);
                //dump($name);
                Blade::component("www::".$slot.'._components.'.$name, 'www-'.$name);
            }

        }

        //dd($dir);






    //     private function scanComponents($path, $except=[])
    // {
    //     foreach($except as $i => $name) {
    //         $except[$i] .= ".blade.php";
    //     }

    //
    //     $names = [];
    //     foreach($dir as $file) {
    //         if($file == '.' || $file == '..') continue;
    //         if($file[0] == '.') continue;
    //         if(in_array($file,$except)) continue;

    //         if(is_dir($path.DIRECTORY_SEPARATOR.$file)) {
    //             $sub = $this->scanComponents($path.DIRECTORY_SEPARATOR.$file);
    //             foreach($sub as $name) {
    //                 $component = str_replace(".blade.php","",$file.".".$name);
    //                 Blade::component(\Jiny\Theme\View\Components\ThemeComponent::class, "theme-".$component);
    //                 $names []= $component;
    //             }
    //         } else {
    //             $component = str_replace(".blade.php","",$file);
    //             Blade::component(\Jiny\Theme\View\Components\ThemeComponent::class, "theme-".$component);
    //             $names []= $component;
    //         }
    //     }

    //     return $names;
    // }

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
