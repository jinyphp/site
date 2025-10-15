<?php
namespace Jiny\Site\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Jiny\WireTable\Http\Controllers\LiveController;
class SiteController extends LiveController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);
    }


    public function index(Request $request)
    {
        return parent::index($request);
    }

}
