<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Request;
use Livewire\Attributes\On;

use Jiny\Widgets\Http\Livewire\Widget;
class SiteWidgetMenu extends Widget
{
    public $uri;

    public $widget_id;      // 위젯 아디이
    public $widget_path;    // 위젯 json 파일 경로
    public $widget = [];    // 위젯 데이터

    use WithFileUploads;
    use \Jiny\WireTable\Http\Trait\Upload;

    // public $code;
    public $code; // 메뉴코드
    public $code_key;
    public $key;
    public $menus=[]; //

    public $upload_path;

    public $viewFile;
    public $rows = [];

    public $mode;
    public $design_mode;
    public $popupForm = false;
    public $viewForm;
    public $viewList;
    public $popupDelete = false;
    public $confirm = false;

    public $viewNode;
    public $viewHeader;
    public $viewItem;
    public $viewSub;


    public $actions = [];
    public $forms = [];
    public $edit_id;

    public $popupWindowWidth = "4xl";
    public $message;

    use \Jiny\Widgets\Http\Trait\DesignMode;

    public function mount()
    {
        parent::mount();

        // actions 정보를 확인합니다.
        if(!$this->actions) {
            $this->actions = Action()->data;
            //dd($this->actions);
        }

        //dd($this->actions);

        // action 설정값에 적용된 메뉴를 설정
        // 코드키
        if($this->key) {
            $this->code_key = $this->key;
        }

        if($this->code_key) {
            //dd($this->code_key);
            $code_key = $this->code_key;

            if(isset($this->actions['menu'][$code_key]) && $this->actions['menu'][$code_key]) {
                $this->code = _getValue($this->actions['menu'][$code_key]);
            }
        }


        // widget 정보 읽기
        $path = $this->widgetJsonPath();
        $this->widget = json_file_decode($path);

        if(!$this->code) { // 외부입력값이 없는 경우
            if(isset($this->widget['code'])) {
                $this->code = _getValue($this->widget['code']);
            }
        }

        if($this->code) {
            $this->menuload();
        } else {
            $this->rows = [];
            $this->rows['items'] = [];
        }



        if(!$this->viewNode) {
            $this->viewNode = "jiny-site::site.menus.sidebar.style1.node";
        }

        if(!$this->viewHeader) {
            $this->viewHeader = "jiny-site::site.menus.sidebar.style1.header";
        }

        if(!$this->viewItem) {
            $this->viewItem = "jiny-site::site.menus.sidebar.style1.item";
        }

        if(!$this->viewSub) {
            $this->viewSub = "jiny-site::site.menus.sidebar.style1.sub";
        }

        $this->viewListFile();
        $this->viewFormFile();

        // 데이터 파일명과 동일한 구조의 url 경로로 임시설정
        $this->upload_path = DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $this->code);
    }

    public function render()
    {
        if(!$this->viewFile) {
            $this->viewFile = 'jiny-site::site.menus.sidebar.style1.layout';
        }
        $this->viewFile = siteViewName($this->viewFile);

        // 기본값
        return view('jiny-site::site.menus.layout');
    }



    protected function menuload($type="json")
    {
        $path = resource_path('menus');
        if(!is_dir($path)) mkdir($path,0777,true);

        if(file_exists($path.DIRECTORY_SEPARATOR.$this->code.".json")) {
            $body = file_get_contents($path.DIRECTORY_SEPARATOR.$this->code.".json");
            $menus = json_decode($body,true);
        } else {
            $menus = [];
        }

        if($menus) {
            $this->rows = $menus;
        } else {
            $this->rows['items'] = [];
        }
    }

    protected function menusSave($rows, $filepath)
    {
        $str = json_encode($rows, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );

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

            $this->menusSave($this->rows, $this->code);
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

            $this->menusSave($this->rows, $this->code);
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
        $this->menusSave($this->rows, $this->code);

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

        $this->mode = null;
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
        $this->menusSave($this->rows, $this->code);
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
        $this->code = str_replace(".json","",$value);
        $this->menuload();
    }


    public function itemUp($item)
    {

    }

    public function itemDown($item)
    {

    }

    public function setting()
    {
        parent::setting();

        // widget 정보 읽기
        $path = $this->widgetJsonPath();
        //dump($path);
        $this->forms = json_file_decode($path);

        //dd($this->forms);
    }

    public function widgetSave()
    {
        $path = $this->widgetJsonPath();
        json_file_encode($path, $this->forms);
        //dd($this->forms);

        $this->popupForm = false;
        $this->mode = null;
        $this->setup = false;

        // 수정한 widget 정보 반영
        $this->widget = $this->forms;

        // 메뉴다시 읽기
        if(isset($this->widget['code'])) {
            $this->code = _getValue($this->widget['code']);

            $this->code = $this->code;
            $this->menuload();
        } else {
            $this->code = null;
            $this->rows = [];
            $this->rows['items'] = [];
        }

        $this->forms = [];


    }

    protected function widgetJsonPath()
    {
        // widget 파일 경로 체크
        $path = resource_path('widgets');
        $path .= DIRECTORY_SEPARATOR;

        if($this->widget_path) {
            // 외부에서 지정한 widget 파일경로에 데이터를 저장
            $temp = str_replace('.json', "", $this->widget_path);
            $path .= str_replace('/', DIRECTORY_SEPARATOR, $temp);
            $path .= ".json";

        } else if($this->uri) {
            // url 경로와 일치된 위치에 저장
            // 디렉터리 생성
            $dir = str_replace('/', DIRECTORY_SEPARATOR, $this->uri);
            if(!is_dir($path.$dir)) {
                mkdir($path.$dir, 0777, true);
            }

            $path .= str_replace('/', DIRECTORY_SEPARATOR, $this->uri);
            $path .= DIRECTORY_SEPARATOR;
            if($this->widget_id) {
                $path .= $this->widget_id.".json";
            } else {
                $path .= "0.json";
            }
        }

        return $path;
    }

    #[On('menu-mode')]
    public function MenuMode($mode=null)
    {
        if($this->design) {
            $this->design = false;
            $this->design_mode = false;
        } else {
            $this->design = "menu";
            $this->design_mode = true;
        }
    }

}
