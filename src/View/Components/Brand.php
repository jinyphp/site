<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Brand extends SiteView
{
    public $name;
    public $data;

    public function __construct($name=null,$data=null)
    {
        if($name) {
            $this->name = $name;
        } else {
            // Action 설정값 읽기
            $val = Action()->get('layouts.brand');
            if($val) {
                $this->name = $val;
            } else {
                $this->name = "brand"; // 기본값
            }
        }

        $this->data = $data;
    }

}
