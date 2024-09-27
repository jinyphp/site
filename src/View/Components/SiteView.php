<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class SiteView extends Component
{
    private $layout_path = "_layouts";

    public function render()
    {
        // 해더를 읽어 옵니다.
        // 우선순위1. 사이트 slot에서 header 읽기
        if($result = $this->wwwView($this->name)) {
            return $result;
        }

        // 우선순위2. 테마에서 header 읽기
        if($result = $this->themeView($this->name)) {
            return $result;
        }

        $msg = $this->name."의 layout 디자인 리소스를 읽어 올 수 없습니다.";
        return $this->errorView($msg);
    }

    private function wwwView($name)
    {
        $slot = www_slot();
        //dd($slot);
        if($slot) {
            // slot의 레이아웃 리소스는 _layouts 안에 지정됨
            $viewFile = "www::".$slot.".".$this->layout_path.".".$name;
            //dd($viewFile);
            if(View::exists($viewFile)) {
                return view($viewFile);
            }
        }

        return false;
    }

    private function themeView($name)
    {
        $theme_name = xTheme()->getName();
        $theme_name = trim($theme_name,'"');
        if ($theme_name) {

            $viewFile = $theme_name.".".$this->layout_path.".".$name;
            if (View::exists("theme::".$viewFile)) {
                return view("theme::".$viewFile);
            }

            // 테마 리소스가 없는 경우
            $msg = $theme_name." 테마에 _layouts.".$name.".blade.php 파일을 찾을 수 없습니다.";
            return $this->errorView($msg);
        }

        return false;
    }

    private function errorView($message)
    {
        return view("jinytheme::errors.alert",[
            'message'=>$message
        ]);
    }

}
