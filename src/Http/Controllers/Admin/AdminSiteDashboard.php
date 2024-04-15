<?php

namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Jiny\WireTable\Http\Controllers\DashboardController;
class AdminSiteDashboard extends DashboardController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        $this->actions['view']['layout'] = "jiny-site::admin.dashboard.dash";

        $this->actions['title'] = "Dashboard";
        $this->actions['subtitle'] = "사이트를 관리합니다.";

        //setMenu('menus/site.json');
        setTheme("admin/sidebar");
    }


    public function index(Request $request)
    {


        return parent::index($request);
    }





}
