<?php
namespace Jiny\Site\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Jiny\WireTable\Http\Controllers\LiveController;
class SiteController extends LiveController
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        // 페이지 레이아웃
        //$this->viewFileLayout = "jiny-site"."::www.layout";

    }

    // 레이아웃을 변경할 수 있습니다.
    protected function setLayout($path)
    {
        if($path) {
            $this->viewFileLayout = $path;
        }

        return $this;
    }

    public function index(Request $request)
    {
        return parent::index($request);
    }



    /**
     * index Process
     */
    /*
    public function index(Request $request)
    {
        // 1.IP확인
        $ipAddress = $request->ip();
        $this->actions['request']['ip'] = $ipAddress;

        // 2. request로 전달되는 uri 파라미터값을 분석합니다.
        $this->checkRequestNesteds($request);

        // 3. request로 전달되는 uri 쿼리스트링을 확인합니다.
        $this->checkRequestQuery($request);

        // 4.테마확인
        // if(isset($this->actions['theme'])) {
        //     if($this->actions['theme']) {
        //         if(function_exists("setTheme")) {
        //             setTheme($this->actions['theme']);

        //             // 레이아웃 적용을 테마로 설정합니다.
        //             $this->viewFileLayout = $this->packageName."::theme.dash";
        //         }
        //     }
        // }

        // 5.로그인: 사용자 메뉴 설정
        // $user = Auth::user();
        // if($user) {
        //     //$this->setUserMenu($user);
        // }

        ## 6.권한
        $this->permitCheck();
        if($this->permit['read']) {

            $view = $this->getViewFileLayout();
            if (view()->exists($view)) {
                $_data = [
                    'actions'=>$this->actions,
                    'nested'=>$this->nested,
                    'request'=>$request
                ];

                return view($view, $_data);
            }

            return view($this->packageName."::errors.message",[
                'message' => $view."를 읽어올수 없습니다."
            ]);
        }

        ## 7.권한 접속 실패
        return view("jiny-wire-table::error.permit",[
            'actions'=>$this->actions,
            'request'=>$request
        ]);
    }
    */




}
