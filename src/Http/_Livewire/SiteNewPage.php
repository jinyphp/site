<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;

/**
 * 404에서 새로운 페이지를 생성합니다.
 * 현재 uri 기준, 빈 페이지 생성
 */
class SiteNewPage extends Component
{
    public $uri;
    public $slot;
    public $stubFile;

    public $mode;

    public $popupForm = false;
    public $popupWindowWidth = "4xl";

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
        $viewFile = 'jiny-site::www.errors.slot_new_page';
        return view($viewFile);
    }

    public function create()
    {
        $this->popupForm = true;
    }

    public function cancel()
    {
        $this->popupForm = false;
    }

    public function board()
    {
        $this->popupForm = false;

        $path = resource_path('actions');
        $path .= DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->uri);

        if(!is_dir($path)) {
            mkdir($path,0777,true);
        }

        $target = $path.".json";
        json_file_encode($target,[
            'type' => "board"
        ]);

        $this->dispatch('page-realod');
    }

    public function make()
    {
        $this->popupForm = false;

        $path = resource_path('www');
        if($this->slot) {
            $target = $path.DIRECTORY_SEPARATOR.$this->slot;
            $target .= DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $this->uri);

            if(!is_dir($target)) {
                mkdir($target,0777,true);
            }

            $target .= DIRECTORY_SEPARATOR."index.blade.php";

        } else {

        }

        // stub 리소스 파일을 복사
        $src = View::make($this->stubFile)->getPath();
        if(copy($src, $target)) {
            $this->dispatch('page-realod');
        }

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

    public function markdown()
    {
        // 현재 슬롯 가져오기
        $this->slot = www_slot();
        if (!$this->slot) {
            return;
        }

        // 리소스 경로 설정
        $path = resource_path('www');
        $target = $path . DIRECTORY_SEPARATOR . $this->slot;
        $target .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $this->uri);

        // 폴더가 없으면 생성
        if (!is_dir($target)) {
            mkdir($target, 0777, true);
        }

        // index.md 파일 생성
        $target .= DIRECTORY_SEPARATOR . "index.md";

        // 기본 문구가 포함된 마크다운 파일 생성
        $content = "# " . basename($this->uri) . "\n\n404로 생성된 마크다운 페이지입니다. 편집을 통하여 내용을 수정해 주세요.";
        if (file_put_contents($target, $content)) {
            $this->dispatch('page-realod');
        }
    }

    public function html()
    {
        // 현재 슬롯 가져오기
        $this->slot = www_slot();
        if (!$this->slot) {
            return;
        }

        // 리소스 경로 설정
        $path = resource_path('www');
        $target = $path . DIRECTORY_SEPARATOR . $this->slot;
        $target .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $this->uri);

        // 폴더가 없으면 생성
        if (!is_dir($target)) {
            mkdir($target, 0777, true);
        }

        // index.md 파일 생성
        $target .= DIRECTORY_SEPARATOR . "index.html";

        // 기본 문구가 포함된 Html 파일 생성
        $content = "<h1>" . basename($this->uri) . "</h1>\n\n<p>404로 생성된 HTML 페이지입니다. 편집을 통하여 내용을 수정해 주세요.</p>";
        if (file_put_contents($target, $content)) {
            $this->dispatch('page-realod');
        }
    }

    public function blade()
    {
        // 현재 슬롯 가져오기
        $this->slot = www_slot();
        if (!$this->slot) {
            return;
        }

        // 리소스 경로 설정
        $path = resource_path('www');
        $target = $path . DIRECTORY_SEPARATOR . $this->slot;
        $target .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $this->uri);

        // 폴더가 없으면 생성
        if (!is_dir($target)) {
            mkdir($target, 0777, true);
        }

        // index.blade.php 파일 생성
        $target .= DIRECTORY_SEPARATOR . "index.blade.php";

        // 기본 문구가 포함된 Blade 파일 생성
        $content = "<x-www-app>\n<x-www-layout>\n<x-www-main>\n";
        $content .= "<h1>" . basename($this->uri) .
        "</h1>\n\n<p>404로 생성된 Blade 페이지입니다. 편집을 통하여 내용을 수정해 주세요.</p>";
        $content .= "</x-www-main>\n</x-www-layout>\n</x-www-app>";

        if (file_put_contents($target, $content)) {
            $this->dispatch('page-realod');
        }
    }
}
