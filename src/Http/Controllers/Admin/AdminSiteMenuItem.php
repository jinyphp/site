<?php

namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Jiny\WireTable\Http\Controllers\WireDashController;
class AdminSiteMenuItem extends WireDashController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        $this->actions['view']['layout'] = "jiny-site::admin.menu_item.layout";

        $this->actions['title'] = "Site Menu";
        $this->actions['subtitle'] = "사이트 메뉴를 관리합니다.";
    }


    public function index(Request $request)
    {
        $data = [
            'actions' => $this->actions,
        ];

        $viewFile = $this->getViewFileLayout($default=null);
        return view($viewFile, $data);
        // return parent::index($request);
    }

}
