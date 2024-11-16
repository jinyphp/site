<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

/**
 * 사이트 화면번호
 */
use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteScreen extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_screen";

        $this->actions['view']['list'] = "jiny-site::admin.screen.list";
        $this->actions['view']['form'] = "jiny-site::admin.screen.form";

        $this->actions['title'] = "사이트 화면번호";
        $this->actions['subtitle'] = "사이트 화면번호를 관리합니다.";

        // 업로드후 해당경로로 파일 이동
        //$this->setUploadAfterMoveTo("/images/flag");
    }


}
