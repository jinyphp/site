<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Sidebar extends SiteView
{
    public $key = "sidebar";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
