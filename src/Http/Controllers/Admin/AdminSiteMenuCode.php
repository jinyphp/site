<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminSiteMenuCode extends WireTablePopupForms
{
    public function __construct()
    {
        parent::__construct();
        $this->setVisit($this);

        ## 테이블 정보
        $this->actions['table'] = "site_menus";

        $this->actions['view']['list'] = "jiny-site::admin.menu.list";
        $this->actions['view']['form'] = "jiny-site::admin.menu.form";

        $this->actions['title'] = "메뉴관리";
        $this->actions['subtitle'] = "다양한 메뉴를 관리합니다.";
    }


    ## 신규 데이터 DB 삽입후에 호출됩니다.
    public function hookStored($wire, $form)
    {
        $id = $form['id'];

        // 파일 생성
        $path = resource_path('menus');
        if(!is_dir($path)) mkdir($path,0777,true);

        $filename = $path.DIRECTORY_SEPARATOR.$form['code'].".json";
        file_put_contents($filename, "");
    }

    // DB 수정이 완료된 후에 실행되는 후크 메소드
    public function hookUpdated($wire, $form, $old)
    {
        // 메뉴코드 변경
        if($form['code'] != $old['code']) {
            $path = resource_path('menus');
            $src = $path.DIRECTORY_SEPARATOR.$old['code'].".json";
            $dst = $path.DIRECTORY_SEPARATOR.$form['code'].".json";
            rename($src, $dst);
        }

        return $form;
    }

    ## delete 동직이 실행된후 호출됩니다.
    public function hookDeleted($wire, $row)
    {
        $path = resource_path('menus');
        $dst = $path.DIRECTORY_SEPARATOR.$row['code'].".json";
        unlink($dst);

        return $row;
    }


}
