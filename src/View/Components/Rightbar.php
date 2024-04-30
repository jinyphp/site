<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Rightbar extends SiteView
{
    public $key = "rightbar";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
