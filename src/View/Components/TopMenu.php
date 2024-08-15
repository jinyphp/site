<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class TopMenu extends SiteView
{
    public $key = "topmenu";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
