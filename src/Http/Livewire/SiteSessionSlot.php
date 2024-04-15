<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SiteSessionSlot extends Component
{
    public $user_id;
    public $slots = [];
    public $userSlot = [];
    public $selectedSlot;

    public function mount()
    {
        $this->slots = config("jiny.site.slot");
        $this->userSlot = config("jiny.site.userslot");

        $user = Auth::user();
        if($user) {
            $this->user_id = $user->id;

            // 사용자 정의 slot
            if(isset($this->userSlot[$user->id])) {
                $this->selectedSlot = $this->userSlot[$user->id];
            }
        }

        // 기본 active slot
        if(!$this->selectedSlot) {
            foreach($this->slots as $key => $item) {
                if($item['active']) {
                    $this->selectedSlot = $key;
                }
            }
        }
    }

    public function render()
    {
        // 기본값
        $viewFile = 'jiny-site::livewire.slot-session';
        return view($viewFile);
    }

    public function submit()
    {
        $user_id = $this->user_id;
        $this->userSlot[$user_id] = $this->selectedSlot;

        // 사용자별 user slot 저장
        $this->phpSave($this->userSlot, "jiny/site/userslot");
    }

    public function phpSave($slots, $path)
    {
        // 저장
        $str = $this->convToPHP($slots);
$file = <<<EOD
<?php
return $str;
EOD;
        // PHP 설정파일명
        $path = $this->filename($path);

        // 설정 디렉터리 검사
        $info = pathinfo($path);
        if(!is_dir($info['dirname'])) mkdir($info['dirname'],0755, true);

        file_put_contents($path, $file);
    }

    public function convToPHP($form, $level=1)
    {
        $str = "[\n"; //초기화
        $lastKey = array_key_last($form);

        foreach($form as $key => $value) {
            for($i=0;$i<$level;$i++) $str .= "\t";

            if(is_array($value)) {
                $str .= "'$key'=>".''.$this->convToPHP($value,$level+1).'';
            } else {
                $str .= "'$key'=>".'"'.addslashes($value).'"';
            }

            if($key != $lastKey) $str .= ",\n";
        }

        $str .= "\n";

        if($level>1) {
            for($i=0;$i<$level-1;$i++) $str .= "\t";
        }

        $str .= "]";

        return $str;
    }

    /**
     * 설정 파일명 얻기
     */
    private function filename($filename)
    {
        $path = config_path().DIRECTORY_SEPARATOR.$filename.".php";
        return $path;
    }

}
