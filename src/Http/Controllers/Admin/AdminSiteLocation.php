<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteLocation extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_location";

        $this->actions['view']['list'] = "jiny-site::admin.location.list";
        $this->actions['view']['form'] = "jiny-site::admin.location.form";

        $this->actions['title'] = "지점목록";
        $this->actions['subtitle'] = "사이트 지점 목록을 관리합니다.";

        // 업로드후 해당경로로 파일 이동
        //$this->setUploadAfterMoveTo("/images/flag");
    }


}
