<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Header extends SiteView
{
    public $key = "header";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
