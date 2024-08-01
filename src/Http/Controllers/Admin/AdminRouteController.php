<?php
namespace Jiny\Site\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use Jiny\WireTable\Http\Controllers\WireTablePopupForms;
class AdminRouteController extends WireTablePopupForms
{
    public function __construct()
    {
        //dd("1234");

        parent::__construct();
        $this->setVisit($this);

        ##
        $this->actions['table'] = "jiny_route"; // 테이블 정보
        $this->actions['paging'] = 10; // 페이지 기본값

        $this->actions['view']['list'] = "jiny-site::admin.route.list";
        $this->actions['view']['form'] = "jiny-site::admin.route.form";

    }


    /**
     * DB 갱신전에 호출되는 동작
     */
    public function hookUpdating($form)
    {
        // 코드명 변경 체크
        /*
        if ($this->wire->old['route'] != $form['route']) {
            $path = resource_path('actions');
            $filename = $path.$this->wire->old['route'].".json";
            if(file_exists($filename)) {
                // 파일명 변경하기
                $newfile = str_replace("/","_",ltrim($form['route'],"/")).".json";
                rename($filename, $path.DIRECTORY_SEPARATOR.$newfile);
            }
        }
        */

        return $form;
    }


    /**
     * DB 데이터를 삭제하기 전에 동작
     */
    public function hookDeleting($row)
    {
        $path = resource_path('actions');
        if($path) {
            /*
            dd($path.$row>forms->route);
            $filename = $path.$row>forms->route.".json";

            if(file_exists($filename)) {
                unlink($filename);
            }
            */

            return $row;
        }
    }


}
