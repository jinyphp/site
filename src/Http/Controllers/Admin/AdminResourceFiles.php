<?php

namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminResourceFiles extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        $this->actions['view']['main'] = "jiny-site::admin.files.main";
    }

    public function index(Request $request, ...$slug)
    {

        if(!isset($actions['path'])) {
            $this->actions['path'] = "/resources/www";
        }

        // 서브경로를 추가합니다.
        $this->actions['slug'] = implode("/",$slug);
        return parent::index($request);
    }

}
