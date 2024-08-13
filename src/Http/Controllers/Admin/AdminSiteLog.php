<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteLog extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_log";

        $this->actions['view']['list'] = "jiny-site::admin.log.list";
        $this->actions['view']['form'] = "jiny-site::admin.log.form";

        $this->actions['title'] = "로그관리";
        $this->actions['subtitle'] = "사이트 접속 통계를 관리 합니다.";
    }


}
