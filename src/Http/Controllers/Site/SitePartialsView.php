<?php
namespace Jiny\Site\Http\Controllers\Site;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\Site\Http\Controllers\SiteController;
class SitePartialsView extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);
    }

}
