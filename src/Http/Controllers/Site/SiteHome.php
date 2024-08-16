<?php
namespace Jiny\Site\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\Site\Http\Controllers\SiteController;
class SiteHome extends SiteController
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
    }

    public function index(Request $request)
    {

        $this->log();

        $slot = www_slot();
        if($slot) {
            ## 우선순위1
            $view = "www::".$slot.".index";
            if(view()->exists($view)) {
                return view($view,[
                    'actions' => $this->actions
                ]);
            }
        } else {
            ## 우선순위2
            $view = "www::index";
            if(view()->exists($view)) {
                return view($view,[
                    'actions' => $this->actions
                ]);
            }
        }

        ## 우선순위3 : 테마
        $theme = getThemeName();
        if($theme) {
            $view = "theme::".$theme.".index";

            if(view()->exists($view)) {
                return view($view,[
                    'actions' => $this->actions
                ]);
            }
        }

        ## 우선순위4: 기본리소스 웰컴
        $view = "welcome";
        if(view()->exists($view)) {
            return view($view,[
                'actions' => $this->actions
            ]);
        }

        ## 오류
        return false;



        //return parent::index($request);
    }

    private function log()
    {
        $date = explode('-',date("Y-m-d"));
        $log = DB::table('site_log')
                ->where('year',$date[0])
                ->where('month',$date[1])
                ->where('day',$date[2])
                ->first();
        if($log) {
            DB::table('site_log')
                ->where('year',$date[0])
                ->where('month',$date[1])
                ->where('day',$date[2])
                ->increment('cnt', 1,[ 'updated_at' => date("Y-m-d H:i:s") ]);
        } else {
            DB::table('site_log')->insert([
                'year' => $date[0],
                'month' => $date[1],
                'day' => $date[2],
                'uri' => "/",
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
                'cnt' => 1
            ]);
        }
    }



}
