<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Navbar extends SiteView
{
    public $key = "nav";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
