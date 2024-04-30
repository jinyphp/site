<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Layout extends SiteView
{
    public $key = "layout";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
