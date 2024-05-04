<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class App extends SiteView
{
    public $key = "app";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

    // public function render()
    // {
    //     return parent::render();
    // }


}
