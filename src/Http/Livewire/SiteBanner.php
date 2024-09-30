<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class SiteBanner extends Component
{
    public $code;
    public $limit=5;

    public $viewFile;

    public function mount()
    {
        if($this->viewFile) {
            $this->viewFile = $this->checkViewFile($this->viewFile);
        } else {
            $this->viewFile = "jiny-site::site.banner";
        }

    }

    private function checkViewFile($viewFile)
    {
        if (strpos($viewFile, '::') !== false) {
            if (View::exists($viewFile)) {
                return $viewFile;
            }
        }

        if($viewFile = $this->inSlotView($viewFile)) {
            return $viewFile;
        }

        return false;
    }

    // 슬롯안에 뷰가 있는지 검사
    private function inSlotView($viewFile)
    {
        $prefix = "www";
        $slot = $slot = www_slot();

        // 페키지 경로가 없는 겨우에는 slot에서 검색
        // 먼저 슬롯 안에 있는지 검사
        if($slot) {
            if(View::exists($prefix."::".$slot.".".$viewFile)) {
                return $prefix."::".$slot.".".$viewFile;
            }
        }
        // slot에 없는 경우 상위 www 공용안에 있는지 검사
        else {
            if(View::exists($prefix."::".$viewFile)) {
                return $prefix."::".$viewFile;
            }
        }

        return false;
    }

    public function render()
    {
        $rows = $this->banners();
        if(count($rows)>0) {
            return view($this->viewFile,[
                'rows'=> $rows
            ]);
        }

        $body = <<<EOD
<!-- site banner -->
EOD;
        return $body;

    }

    private function banners()
    {
        $db = DB::table('site_banner')->orderBy('id', 'desc');

        // 활성화된 베너만 선택
        $db->where('enable',1);

        if($this->code) {
            if(is_array($this->code)) {
                foreach($this->code as $key => $value) {
                    $db->where($key, $value);
                }
            } else {
                $db->where('type',$this->code);
            }
        }

        if(is_array($this->limit)) {
            $db->offset($this->limit[0]-1)  // Skip the first 9 records
            ->limit($this->limit[1]);   // Fetch the next 8 records (10th to 17th)
        } else {
            $db->limit($this->limit);
        }

        return $db->get();

        // return getSiteBanner(3);
    }



}
