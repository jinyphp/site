<?php
namespace Jiny\Site\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Markdown extends SiteView
{
    public $key = "markdown";
    public $data;

    public function __construct($data=null)
    {
        $this->data = $data;
    }

}
