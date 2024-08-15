<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteMenuCode extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_menus";

        $this->actions['view']['list'] = "jiny-site::admin.menu.list";
        $this->actions['view']['form'] = "jiny-site::admin.menu.form";

        $this->actions['title'] = "메뉴관리";
        $this->actions['subtitle'] = "다양한 메뉴를 관리합니다.";
    }


}
