<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

class SiteMenuItem extends Component
{
    use WithFileUploads;
    use \Jiny\WireTable\Http\Trait\Upload;

    public $filename;

    public $menus=[]; // 메뉴트리
    public $upload_path;

    public $viewFile;
    public $rows = [];

    public $popupForm = false;
    public $viewForm;
    public $viewList;

    public $popupDelete = false;
    public $confirm = false;

    public $actions = [];
    public $forms = [];
    public $edit_id;

    public $popupWindowWidth = "4xl";
    public $message;

    public function mount()
    {
        if(!$this->filename) {
            //$this->filename = "menu";
        }
        $this->menuload();

        $this->viewListFile();
        $this->viewFormFile();

        // 데이터 파일명과 동일한 구조의 url 경로로 임시설정
        $this->upload_path = DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $this->filename);
    }

    public function render()
    {
        if(!$this->filename) {
            return <<<EOD
            <div class="card">
            <div class="card-header">
            메뉴 데이터 파일이 선택되지 않았습니다.
            </div>
            </div>
            EOD;
        }

        if(!$this->viewFile) {
            $this->viewFile = 'jiny-site::admin.menu_item.list_json';
        }

        // 기본값
        return view($this->viewFile);
    }



    protected function menuload($type="json")
    {
        $path = resource_path('menus');
        if(!is_dir($path)) mkdir($path,0777,true);

        if(file_exists($path.DIRECTORY_SEPARATOR.$this->filename.".json")) {
            $body = file_get_contents($path.DIRECTORY_SEPARATOR.$this->filename.".json");
            $menus = json_decode($body,true);
        } else {
            $menus = [];
        }


        if($menus) {
            $this->rows = $menus;
            //dd($this->rows);
            /*
            foreach($menus as $key => $item) {
                // 외부 설정값 우선적용
                // 없는 경우, 설정파일값으로 대체
                if(!isset($this->rows[$key])) {
                    $this->rows[$key] = $item;
                }
            }
            */
        } else {
            $this->rows['items'] = [];
        }


        // items 데이터 읽기
        /*
        if($this->menus) {
            if(isset($this->menus['items'])) {
                $this->rows = $this->menus['items'];
            }
        }
        */
    }

    protected function menusSave($rows, $filepath)
    {
        $str = json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );

        //dd($str);

        $path = resource_path('menus');
        if(!is_dir($path)) mkdir($path,0777,true);

        $filepath = str_replace(["/","."],DIRECTORY_SEPARATOR,$filepath);
        file_put_contents($path.DIRECTORY_SEPARATOR.$filepath.".json", $str);

        return true;
    }

    protected function viewListFile()
    {
        if(!$this->viewList) {
            $this->viewList = 'jiny-menuss::list.group.list';
        }
    }

    protected function viewFormFile()
    {
        if(!$this->viewForm) {
            $this->viewForm = "jiny-site::admin.menu_item.form";

            $this->actions['view']['form'] = $this->viewForm;
        }
    }


    protected $listeners = [
        'create','popupFormCreate',
        'edit','popupEdit','popupCreate',
        'setMenuFile'
    ];

    public $ref;

    public function create($ref=null)
    {
        if($ref) {
            $this->ref = trim($ref,'-');
        } else {
            $this->ref = null;
        }

        //dd($this->ref);

        $this->popupForm = true;
        // 데이터초기화
        $this->forms = [];
    }

    public function store()
    {
        // 2. 시간정보 생성
        //$this->forms['created_at'] = date("Y-m-d H:i:s");
        //$this->forms['updated_at'] = date("Y-m-d H:i:s");

        // 3. 파일 업로드 체크 Trait
        //$this->fileUpload($this->forms, $this->upload_path);

        if($this->ref == null ) {
            $this->storeRoot();
        } else {
            $this->storeSub();
        }
    }

    private function storeRoot()
    {
        if(!empty($this->forms) && isset($this->forms['title'])) {
            $this->rows['items'] []= $this->forms;
            $this->forms = [];

            $this->menusSave($this->rows, $this->filename);
        }

        $this->popupForm = false;
    }

    private function storeSub()
    {
        if(!empty($this->forms) && isset($this->forms['title'])) {
            $ref = explode('-',$this->ref);
            $temp = &$this->rows['items'];
            foreach( $ref  as $i) {
                if(isset($temp[$i])) {
                    $temp = &$temp[$i];
                }
                else if(isset($temp['items'][$i])) {
                    $temp = &$temp['items'][$i];
                }
            }

            $temp['items'] []= $this->forms;
            $this->forms = [];

            $this->menusSave($this->rows, $this->filename);
        }
        $this->popupForm = false;
    }




    public function edit($id)
    {
        $this->actions['id'] = $id;
        $this->edit_id = $id;

        $ref = explode('-',$id);
        $temp = &$this->rows['items'];
        foreach( $ref  as $i) {
            if(isset($temp[$i])) {
                $temp = &$temp[$i];
            }
            else if(isset($temp['items'][$i])) {
                $temp = &$temp['items'][$i];
            }
        }

        //dd($temp);

        $this->forms = $temp;
        $this->popupForm = true;
    }


    public function update()
    {
        // 2. 시간정보 생성
        $this->forms['updated_at'] = date("Y-m-d H:i:s");

        // 3. 파일 업로드 체크 Trait
        $this->fileUpload($this->forms, $this->upload_path);

        $id = $this->edit_id;

        $ref = explode('-',$id);
        $temp = &$this->rows['items'];
        foreach( $ref  as $i) {
            if(isset($temp[$i])) {
                $temp = &$temp[$i];
            }
            else if(isset($temp['items'][$i])) {
                $temp = &$temp['items'][$i];
            }
        }

        foreach($this->forms as $key => $value) {
            $temp[$key] = $value;
        }
        // $temp = $this->forms;
        //dd($this->rows);

        //$this->rows[$id] = $this->forms;
        //$this->menus['items'] = $this->rows;
        $this->menusSave($this->rows, $this->filename);

        $this->forms = [];
        $this->edit_id = null;
        $this->actions['id'] = null;
        $this->popupForm = false;
        //$this->setup = false;
    }


    public function cancel()
    {
        $this->forms = [];
        $this->edit_id = null;
        $this->popupForm = false;
        $this->setup = false;
    }


    /**
     * 삭제 팝업창 활성화
     */
    public function delete($id=null)
    {
        $this->popupDelete = true;
    }


    public function deleteCancel()
    {
        $this->popupDelete = false;
        $this->popupForm = false;
        $this->setup = false;
    }

    /**
     * 삭제 확인 컨펌을 하는 경우에,
     * 실제적인 삭제가 이루어짐
     */
    public function deleteConfirm()
    {
        $this->popupDelete = false;
        $this->popupForm = false;
        $this->setup = false;

        $id = $this->edit_id;
        $this->edit_id = null;

        // 이미지삭제
        // $this->deleteUploadFiles($this->rows[$id]);


        // 데이터삭제
        $ref = explode('-',trim($id,'-'));
        //dump($ref);
        $temp = &$this->rows['items'];
        $ddd = &$this->rows['items'];
        foreach( $ref as $i) {
            if(isset($temp[$i])) {
                $ddd = &$temp;
                $temp = &$temp[$i];

            }
            else if(isset($temp['items'][$i])) {
                $ddd = &$temp['items'];
                $temp = &$temp['items'][$i];

            }
        }

        //dump($ddd);
        //dd($temp);
        unset($ddd[$i]);


        //$this->menus['items'] = $this->rows;
        $this->menusSave($this->rows, $this->filename);
    }

    // 삭제해야 되는 이미지가 있는 경우
    protected function deleteUploadFiles($form)
    {
        $path = storage_path('app');
        $type_name = ["image", "img", "images", "upload"];

        foreach($form as $key => $item) {
            if(in_array($key, $type_name)) {
                $filepath = $path."/".$item;
                if(file_exists($filepath)) {
                    unlink($filepath);
                }
            }
        }
    }


    /**
     * 이벤트
     */


    public function setMenuFile($value)
    {
        //dd($value);
        $this->filename = str_replace(".json","",$value);
        $this->menuload();
    }


    public function itemUp($item)
    {

    }

    public function itemDown($item)
    {

    }



}
