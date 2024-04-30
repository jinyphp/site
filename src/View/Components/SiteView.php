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
        if($result = $this->wwwView($this->key)) {
            return $result;
        }

        // 우선순위2. 테마에서 header 읽기
        if($result = $this->themeView($this->key)) {
            return $result;
        }

        $msg = "layout 디자인 리소스를 읽어 올 수 없습니다.";
        return $this->errorView($msg);
    }

    private function wwwView($key)
    {
        $slot = www_slot();
        if($slot) {
            // slot의 레이아웃 리소스는 _layouts 안에 지정됨
            $viewFile = "www::".$slot.".".$this->layout_path.".".$key;
            if(View::exists($viewFile)) {
                return view($viewFile);
            }
        }

        return false;
    }

    private function themeView($key)
    {
        $theme_name = xTheme()->getName();
        $theme_name = trim($theme_name,'"');
        if ($theme_name) {

            $viewFile = $theme_name.".".$this->layout_path.".".$key;
            if (View::exists("theme::".$viewFile)) {
                return view("theme::".$viewFile);
            }

            // 테마 리소스가 없는 경우
            $msg = $theme_name." 테마에 _layouts.".$key.".blade.php 파일을 찾을 수 없습니다.";
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
