<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Menu extends SiteView
{
    public $key = "menu";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
