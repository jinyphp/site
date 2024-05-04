<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Brand extends SiteView
{
    public $key = "brand";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
