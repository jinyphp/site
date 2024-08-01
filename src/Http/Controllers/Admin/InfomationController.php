<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\Config\Http\Controllers\ConfigController;
class InfomationController extends ConfigController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ##
        $this->actions['filename'] = "jiny/site/infomation"; // 설정파일명(경로)

        $this->actions['view']['form'] = "jiny-site::admin.infomation.form";
        $this->actions['view']['main'] = "jiny-site::admin.infomation.layout";

        $this->actions['title'] = "Site 정보";
        $this->actions['subtitle'] = "다양한 사이트의 정보를 설정합니다.";
    }

    public function index(Request $request)
    {
        // 메뉴 설정
        ##$this->menu_init();
        return parent::index($request);
    }
}
