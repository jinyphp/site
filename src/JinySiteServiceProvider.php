<?php
namespace Jiny\Site;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

class JinySiteServiceProvider extends ServiceProvider
{
    private $package = "jiny-site";
    private $components = [];
    private $slot;

    public function boot()
    {
        // 모듈: 라우트 설정
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/admin.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/auto.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', $this->package);

        // 데이터베이스
        $this->loadMigrationsFrom(__DIR__.'/../databases/migrations');

        $this->resourceSetting();

        Blade::component($this->package.'::components.'.'site.setting', 'site-setting');

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
        Blade::component(\Jiny\Site\View\Components\TopMenu::class, "www-topmenu");

        Blade::component(\Jiny\Site\View\Components\Home::class, "www-home");
        Blade::component(\Jiny\Site\View\Components\Page::class, "www-page");
        Blade::component(\Jiny\Site\View\Components\Docs::class, "www-docs");
        Blade::component(\Jiny\Site\View\Components\Markdown::class, "www-markdown");

        // 동적 컴포넌트
        $this->dynamicComponents(); // 공용 _components
        $this->slotDynamicComponents(); // slot _components

        Blade::component(\Jiny\Site\View\Components\Footer::class, "site-footer");
        Blade::component(\Jiny\Site\View\Components\Header::class, "site-header");
        Blade::component(\Jiny\Site\View\Components\Menu::class, "site-menu");

        Blade::component("www::" . www_slot() . "._layouts.preview", "www-preview");
        Blade::component("www::" . www_slot() . "._layouts.sidebarLink", "www-sidebarlink");

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


        // 디렉티브
        Blade::directive('partials', function ($expression) {
            // Parse the expression to extract the view name and variables
            $args = str_getcsv($expression, ',', "'");
            $view = trim($args[0], '\'"');
            $variables = isset($args[1]) ? trim($args[1]) : '[]';

            // Check if the view contains '..' and adjust the path accordingly
            if (strpos($view, '../') === 0) {
                // Remove the leading '..' and any subsequent slashes or dots
                //$view = ltrim($view, '.\\/');
                $view = ltrim($view, './');

                // Adjust the view path to move up one directory level
                $viewPath = "'www::_partials." . $view . "'";
            } else {
                // Add the prefix to the view name
                $slot = www_slot();
                if ($slot) {
                    $viewPath = "'www::" . $slot . "._partials." . $view . "'";
                } else {
                    $viewPath = "'www::_partials." . $view . "'";
                }
            }


            $viewPath = str_replace('/','.',$viewPath);
            //dd($viewPath);

            // Return the directive code to include the view
            return "<?php echo \$__env->make({$viewPath}, {$variables}, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";
        });


        // 디렉티브
        Blade::directive('blocks', function ($expression) {
            // Parse the expression to extract the view name and variables
            $args = str_getcsv($expression, ',', "'");
            $view = trim($args[0], '\'"');
            $variables = isset($args[1]) ? trim($args[1]) : '[]';

            // Check if the view contains '..' and adjust the path accordingly
            if (strpos($view, '../') === 0) {
                $view = ltrim($view, './');
                $viewPath = "'www::_blocks." . $view . "'";
            } else {
                // Add the prefix to the view name
                $slot = www_slot();
                if ($slot) {
                    $viewPath = "'www::" . $slot . "._blocks." . $view . "'";
                } else {
                    $viewPath = "'www::_blocks." . $view . "'";
                }
            }

            $viewPath = str_replace('/','.',$viewPath);
            return "<?php echo \$__env->make({$viewPath}, {$variables}, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>";

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

        $partPath = $path.DIRECTORY_SEPARATOR."_partials";
        if(!is_dir($partPath)) {
            mkdir($partPath,0777,true);
        }

        if(!is_dir($path."/slot1")) {
            mkdir($path."/slot1",0777,true);
        }
        $this->loadViewsFrom($path."/slot1", 'www1');
    }

    // _components 안에 있는 파일들을 동적으로 컴포넌트화 합니다.
    private function dynamicComponents()
    {

        $base = resource_path('www');
        $path = $base.DIRECTORY_SEPARATOR."_components";

        // 디렉터리 생성
        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $dir = scandir($path);
        foreach($dir as $file) {
            if($file == '.' || $file == '..') continue;
            if($file[0] == '.') continue; // 숨김파일

            if(substr($file, -10) === '.blade.php') {
                $name = substr($file, 0, strlen($file)-10);

                if(!in_array($name, $this->components)) {
                    $this->components []= $name;
                    Blade::component("www::_components.".$name, 'www_'.$name);
                }
            }

        }
    }


    private function slotDynamicComponents()
    {
        $base = resource_path('www');
        $base .= DIRECTORY_SEPARATOR;

        $slot = www_slot();
        $this->slot = $slot;

        $path = $base.DIRECTORY_SEPARATOR.$slot;
        //$path .= DIRECTORY_SEPARATOR."_components";

        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // 1. 컴포넌트 폴더 동적로드
        if(!is_dir($path.DIRECTORY_SEPARATOR."_components")) {
            mkdir($path.DIRECTORY_SEPARATOR."_components",0777,true);
        }
        $this->makeRescueComponents($path.DIRECTORY_SEPARATOR."_components",["www_"]);


        /*
        $dir = scandir($path);
        foreach($dir as $file) {
            if($file == '.' || $file == '..') continue;
            if($file[0] == '.') continue; // 숨김파일

            if(substr($file, -10) === '.blade.php') {
                $name = substr($file, 0, strlen($file)-10);

                if(!in_array($name, $this->components)) {
                    $this->components []= $name;
                    Blade::component("www::".$slot.'._components.'.$name, 'www_'.$name);
                }
            }

        }
        */
    }


    private function makeRescueComponents($path, $prefix=null)
    {
        // $prefix = trim($prefix, '-'); // 앞에 -로 시작하는 것 제외

        // 테마에서 파일을 읽기
        $dir = scandir($path);
        //dump($path);
        //dd($dir);
        foreach($dir as $file) {
            if($file == '.' || $file == '..') continue;
            if($file[0] == '.') continue; // 숨김파일

            if(is_dir($path.DIRECTORY_SEPARATOR.$file)) {
                // dd($prefix);
                $temp = $prefix;
                $temp []= $file;
                $this->makeRescueComponents($path.DIRECTORY_SEPARATOR.$file, $temp);
                continue;
            }

            // blade 파일인지 검사
            if(substr($file, -10) === '.blade.php') {
                $name = substr($file, 0, strlen($file)-10);

                $temp = $prefix;
                $temp []= $name;
                if(count($temp)>0) {
                    $comName = $temp[0];
                    $comName .= implode('-',array_slice($temp,1));
                    //dump($comName);
                    //$comName .= "-".$name;
                } else {
                    //$comName = "";
                    $comName = implode('-',array_slice($temp,1));
                    //$comName .= "-".$name;
                }
                //dump($comName);


                if(!in_array($comName, $this->components)) {
                    $this->components []= $comName;

                    $comPath = "www::".$this->slot."._components.";
                    if(count($temp)>0) {
                        $comPath .= implode('.',array_slice($temp,1));
                    } else {

                    }
                    //$comPath .= ".".$name;
                    //dd($comPath);
                    //dump($comPath);
                    Blade::component($comPath,$comName);
                }
            }

        }
    }




    public function register()
    {
        /* 라이브와이어 컴포넌트 등록 */
        $this->app->afterResolving(BladeCompiler::class, function () {
            Livewire::component('site-setting',
                \Jiny\Site\Http\Livewire\SiteSetting::class);

            Livewire::component('site-session-slot',
                \Jiny\Site\Http\Livewire\SiteSessionSlot::class);
            Livewire::component('site-slot-setting',
                \Jiny\Site\Http\Livewire\SiteSlotSetting::class);
            Livewire::component('site-userslot-setting',
                \Jiny\Site\Http\Livewire\SiteUserSlotSetting::class);

            Livewire::component('site-menu-code',
                \Jiny\Site\Http\Livewire\SiteMenuCode::class);
            Livewire::component('site-menu-item',
                \Jiny\Site\Http\Livewire\SiteMenuItem::class);

        });
    }
}
