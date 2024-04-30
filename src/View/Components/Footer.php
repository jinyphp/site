<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Footer extends SiteView
{
    public $key = "footer";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
