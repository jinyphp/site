<?php
namespace Jiny\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteCountry extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_country";

        $this->actions['view']['list'] = "jiny-site::admin.country.list";
        $this->actions['view']['form'] = "jiny-site::admin.country.form";

        $this->actions['title'] = "지원국가";
        $this->actions['subtitle'] = "사이트 지역 국가를 관리합니다.";

        // 업로드후 해당경로로 파일 이동
        $this->setUploadAfterMoveTo("/images/flag");
    }


}
