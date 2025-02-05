<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

/**
 * 언어 관리
 */
use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteLanguage extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_language";

        $this->actions['view']['list'] = "jiny-site::admin.language.list";
        $this->actions['view']['form'] = "jiny-site::admin.language.form";

        $this->actions['title'] = "지원언어";
        $this->actions['subtitle'] = "사이트 지원언어를 관리합니다.";

        // 업로드후 해당경로로 파일 이동
        //$this->setUploadAfterMoveTo("/images/flag");
    }


}
