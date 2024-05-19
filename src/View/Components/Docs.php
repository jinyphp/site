<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Docs extends SiteView
{
    public $key = "docs";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
