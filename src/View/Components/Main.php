<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Main extends SiteView
{
    public $key = "main";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
