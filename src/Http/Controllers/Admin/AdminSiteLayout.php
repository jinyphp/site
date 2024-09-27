<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteLayout extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_layouts";

        $this->actions['view']['list'] = "jiny-site::admin.layouts.list";
        $this->actions['view']['form'] = "jiny-site::admin.layouts.form";

        $this->actions['title'] = "다이나믹 레이아웃";
        $this->actions['subtitle'] = "다양한 레이아웃을 관리합니다.";
    }


}
