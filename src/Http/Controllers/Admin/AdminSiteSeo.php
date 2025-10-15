<?php
namespace Jiny\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteSeo extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_seo";

        $this->actions['view']['list'] = "jiny-site::admin.seo.list";
        $this->actions['view']['form'] = "jiny-site::admin.seo.form";

        $this->actions['title'] = "SEO관리";
        $this->actions['subtitle'] = "사이트 SEO를 관리합니다.";
    }


}
