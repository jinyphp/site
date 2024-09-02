<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

/**
 * 현재 uri 기준, 빈 페이지 생성
 */
class SiteNewPage extends Component
{
    public $uri;
    public $slot;
    public $stubFile;

    public function mount()
    {
        $this->uri = Request::path();
        $this->slot = $this->getSlot();

        if(!$this->stubFile) {
            $this->stubFile = "jiny-site::stub.layout";
        }
    }

    public function render()
    {
        // 기본값
        $viewFile = 'jiny-site::livewire.slot_new_page';
        return view($viewFile);
    }

    public function create()
    {
        $path = resource_path('www');
        if($this->slot) {
            $target = $path.DIRECTORY_SEPARATOR.$this->slot;
            $target .= DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->uri);

            // dd($target);

            if(!is_dir($target)) {
                mkdir($target,0777,true);
            }

            $target .= DIRECTORY_SEPARATOR."index.blade.php";

            // if(is_dir($target)) {

            // } else {
            //     $target .= ".blade.php";
            // }
        } else {

        }

        //dump($target);

        $src = View::make($this->stubFile)->getPath();
        //dd($src);

        if(copy($src, $target)) {
            $this->dispatch('page-realod');
        }


        //dd($this->uri);
    }

    private function getSlot()
    {
        // 2.slot
        // 여기에 인증된 사용자에 대한 처리를 추가합니다.
        $user = Auth::user();
        $slots = config("jiny.site.userslot");
        if($user && count($slots)>0){
            if($slots && isset($slots[$user->id])) {
                return $slots[$user->id];
            }
        }

        // 설정파일에서 active slot을 읽어옴
        else {
            $slots = config("jiny.site.slot");
            if(is_array($slots) && count($slots)>0) {
                foreach($slots as $slot => $item) {
                    if($item['active']) {
                        return  $slot;
                    }
                }
            }
        }

        return false;
    }
}
