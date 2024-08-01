<?php

namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\Config\Http\Controllers\ConfigController;
class AdminHeader extends ConfigController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ##
        $this->actions['filename'] = "jiny/site/headers"; // 설정파일명(경로)

        $this->actions['view']['form'] = "jiny-site::admin.headers.form";
        $this->actions['view']['main'] = "jiny-site::admin.headers.layout";

        $this->actions['title'] = "Site 상단";
        $this->actions['subtitle'] = "사이트를 상단의 디자인을 설정합니다.";
    }

    public function index(Request $request)
    {
        // 메뉴 설정
        ##$this->menu_init();
        return parent::index($request);
    }
}
