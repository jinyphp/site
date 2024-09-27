<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class SiteMenu extends Component
{
    //public $menu=[];
    public $code;
    public $viewFile;

    public function mount()
    {
        if($this->viewFile) {
            $this->viewFile = $this->checkViewFile($this->viewFile);
        } else {
            $this->viewFile = "jiny-site::site.menu";
        }
    }

    private function checkViewFile($viewFile)
    {
        if (strpos($viewFile, '::') !== false) {
            if (View::exists($viewFile)) {
                return $viewFile;
            }
        }

        if($viewFile = $this->inSlotView($viewFile)) {
            return $viewFile;
        }

        return false;
    }

    // 슬롯안에 뷰가 있는지 검사
    private function inSlotView($viewFile)
    {
        $prefix = "www";
        $slot = $slot = www_slot();

        // 페키지 경로가 없는 겨우에는 slot에서 검색
        // 먼저 슬롯 안에 있는지 검사
        if($slot) {
            if(View::exists($prefix."::".$slot.".".$viewFile)) {
                return $prefix."::".$slot.".".$viewFile;
            }
        }
        // slot에 없는 경우 상위 www 공용안에 있는지 검사
        else {
            if(View::exists($prefix."::".$viewFile)) {
                return $prefix."::".$viewFile;
            }
        }

        return false;
    }


    public function render()
    {
        $menu = \Jiny\Site\MenuItems($this->code);

        return view($this->viewFile,[
            'menu' => $menu
        ]);
    }


}
