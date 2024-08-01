<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteManager extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_manager";

        $this->actions['view']['list'] = "jiny-site::admin.manager.list";
        $this->actions['view']['form'] = "jiny-site::admin.manager.form";

        $this->actions['title'] = "사이트 관리자";
        $this->actions['subtitle'] = "사이트를 관리하는 사원을 지정합니다.";
    }


    ## 신규 데이터 DB 삽입전에 호출됩니다.
    public function hookStoring($wire,$form)
    {
        // 이메일에 대한 사용자 id를 갱신합니다.
        $user = DB::table('users')->where('email',$form['email'])->first();
        if($user) {
            $form['user'] = $user->id;
            $form['user_name'] = $user->name;
        }

        return $form; // 사전 처리한 데이터를 반환합니다.
    }

    ## 데이터를 수정하기전에 호출됩니다.
    public function hookUpdating($wire, $form, $old)
    {
        // 이메일에 대한 사용자 id를 갱신합니다.
        $user = DB::table('users')->where('email',$form['email'])->first();
        if($user) {
            $form['user'] = $user->id;
            $form['user_name'] = $user->name;
        }

        return $form;
    }
}
