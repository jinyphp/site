<?php
namespace Jiny\Site\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteLayoutTag extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table']['name'] = "site_layouts_tag";
        $this->actions['paging'] = 20;

        $this->actions['view']['list'] = "jiny-site::admin.layouts_tag.list";
        $this->actions['view']['form'] = "jiny-site::admin.layouts_tag.form";

        $this->actions['title'] = "동적 레이아웃 테그 관리";
        $this->actions['subtitle'] = "동적 레이아웃을 적용할 수 있는 테그를 관리합니다..";
    }
}
