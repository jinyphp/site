<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Home extends SiteView
{
    public $key = "home";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
