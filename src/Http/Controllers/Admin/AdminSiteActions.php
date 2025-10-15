<?php
namespace Jiny\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteActions extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        $this->actions['view']['layout'] = "jiny-site::admin.actions.layout";

        $this->actions['title'] = "Action json";
        $this->actions['subtitle'] = "Action json 파일 관리";
    }

    public function index(Request $request)
    {
        $subPath = $request->path ?? '';

        $this->params['path'] = $subPath;
        return parent::index($request);
    }


}
