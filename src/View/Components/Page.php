<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Page extends SiteView
{
    public $key = "page";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
