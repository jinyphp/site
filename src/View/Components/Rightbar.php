<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Rightbar extends SiteView
{
    public $name;
    public $data;

    public function __construct($name=null,$data=null)
    {
        if($name) {
            $this->name = $name;
        } else {
            // Action 설정값 읽기
            $val = Action()->get('layouts.rightbar');
            if($val) {
                $this->name = $val;
            } else {
                $this->name = "rightbar"; // 기본값
            }
        }

        $this->data = $data;
    }

}
