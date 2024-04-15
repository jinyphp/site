<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\Config\Http\Controllers\ConfigController;
class UserSlotSettingController extends ConfigController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ##
        $this->actions['filename'] = "jiny/site/userslot"; // 설정파일명(경로)

        $this->actions['view']['main'] = "jiny-site::admin.userslot.layout-php";
        //$this->actions['view']['form'] = "jiny-site::admin.slot.form";
        $this->actions['view']['list'] = "jiny-site::admin.userslot.list";

        $this->actions['view']['form'] = "jiny-site::admin.userslot.form";

        $this->actions['title'] = "사용자 슬롯설정";
        $this->actions['subtitle'] = "슬롯을 변경하여 사이트 리소스를 변경할 수 있습니다.";

        // 생성버튼 활성화
        $this->actions['create']['enable'] = false;
        $this->actions['create']['title'] = "추가";
    }

    public function index(Request $request)
    {
        // 메뉴 설정
        ##$this->menu_init();
        return parent::index($request);
    }
}
