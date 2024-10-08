<?php
namespace Jiny\Site\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\Site\Http\Controllers\SiteController;
class SiteTermsUse extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ##
        /*
        $this->actions['filename'] = "jiny/site/footers"; // 설정파일명(경로)

        $this->actions['view']['form'] = "jiny-site::admin.footers.form";
        $this->actions['view']['main'] = "jiny-site::admin.footers.layout";

        $this->actions['title'] = "Site 하단";
        $this->actions['subtitle'] = "사이트를 하단의 디자인을 설정합니다.";
        */

        //$this->actions['view']['layout'] = "terms-and-conditions";
        $this->actions['view']['layout'] = "jiny-site::site.termsUse.layout";
    }

    public function index(Request $request)
    {
        // Request 객체에서 'any' 값을 가져옴
        $any = $request->route('any');
        $uri = request()->path();

        $this->params['slug'] = $any;
        return parent::index($request);
    }

}
