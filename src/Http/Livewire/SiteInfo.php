<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class SiteInfo extends Component
{
    public $actions;
    public $viewFile;
    public $jsonName = "site";

    public $forms = [];

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site::admin.setting.json";
        }

        $filename = $this->getFilename();
        $this->loadSetting($filename);
    }

    ## 사이트 정보는
    ## 모든 슬롯에도 공용 될 수 있도록 www 루트안에 설정
    private function getFilename()
    {
        $path = resource_path('www');
        if(!is_dir($path)) mkdir($path);

        $filename = $path.DIRECTORY_SEPARATOR."site_info.json";

        return $filename;
    }

    private function loadSetting($filename)
    {
        if (file_exists($filename)) {
            $rules = json_decode(file_get_contents($filename), true);

            foreach ($rules as $key => $value) {
                $this->forms[$key] = $value;
            }
        }
    }

    public function render()
    {
        return view($this->viewFile);
    }

    /**
     * 동작 로직
     */
    public $addKeyStatus = false;
    public $key_name;
    public function addNewCreate()
    {
        $this->addKeyStatus = true;
        $this->key_name = null;
    }

    public function addNewCancel()
    {
        $this->addKeyStatus = false;
        $this->key_name = null;
    }

    public function addNewSubmit()
    {
        $this->addKeyStatus = false;
        if($this->key_name) {
            $this->forms[$this->key_name] = null;
        }

    }

    public function itemRemove($key)
    {
        unset($this->forms[$key]);
    }


    /**
     * json 저장
     */
    public function save()
    {
        // 수정일자 갱신
        $this->forms['updated_at'] = date("Y-m-d H:i:s");

        $filename = $this->getFilename();

        // json 포맷으로 데이터 변환
        $json = json_encode($this->forms,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        file_put_contents($filename, $json);

    }









}
