<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Content extends SiteView
{
    public $key = "content";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
