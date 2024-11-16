<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Livewire\WithFileUploads;
use Livewire\Attributes\On;

/**
 * 다이나믹 위젯 컴포넌트
 */
class SiteWidget extends Component
{
    public $name; // 위젯 이름
    //public $info=[]; // 위젯 정보
    public $setup = false;  // 디자인 모드 활성화



    /**
     * 중재자 패턴 :
     * SiteWidgetLoop 에서 호출되는 이벤트
     * 사이트 레이아웃 및 정보 수정
     */
    #[On('widget-layout-setting')]
    public function WidgetSetLayout($widget_id)
    {
        if(isset($this->widget['key'])
            && $this->widget['key'] == $widget_id) {
            $this->setting();
        }
    }

    /**
     * 위젯 정보 설정 팝업
     */
    public function setting()
    {
        $this->mode = "setting";
        $this->popupForm = true;
        $this->setup = true;
    }

    use WithFileUploads;
    use \Jiny\WireTable\Http\Trait\UploadSlot;

    public $widget=[]; // 위젯정보
    public $widget_id; // page Widget에서 전달되는 순번

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

    use \Jiny\Widgets\Http\Trait\DesignMode;
    use \Jiny\Widgets\Http\Trait\WidgetSaveJson;

    public function mount()
    {
        // json 파일에서 위젯 데이터 읽기
        $this->filename = $this->getFilename();
        $this->dataload();

        // 데이터 파일명과 동일한 구조의 url 경로로 임시설정
        // $this->upload_path = DIRECTORY_SEPARATOR
        //     .str_replace(".", DIRECTORY_SEPARATOR, $this->filename);

        // 위젯 정보 읽기
        //$this->getWidgetInfo();
        $this->viewList = $this->viewListFile();
        $this->viewForm = $this->viewFormFile();
        $this->viewFile = $this->viewFile();

        $this->upload_path = "upload";
        $this->upload_move = "/".trim( $this->filename, "/");
    }

    /**
     * DB에서 위젯 정보를 읽어옵니다.
     */
    // public function getWidgetInfo()
    // {
    //     // 외부에서 전달받은 위젯 이름체크
    //     if($this->name) {
    //         $name = $this->name;

    //     } else {
    //         $name = null;
    //     }

    //     // 위젯 정보에서 위젯 이름 체크
    //     if(!$name) {
    //         if(isset($this->widget['name']) && $this->widget['name']) {
    //             $name = $this->widget['name'];
    //         }
    //     }

    //     // 위젯 이름이 있는 경우
    //     if($name) {
    //         $info = DB::table('site_widgets')
    //             ->where('name', $name)
    //             ->first();
    //         $this->info = $info;

    //         if($info) {
    //             // 리스트 뷰 파일 경로
    //             if($info->view_list) {
    //                 $this->viewList = $info->view_list;
    //             }

    //             // 폼 뷰 파일 경로
    //             if($info->view_form) {
    //                 $this->viewForm = $info->view_form;
    //             }

    //         }
    //     }
    // }

    /**
     * 위젯 데이터 파일명
     */
    protected function getFilename()
    {
        // 외부에서 전달받은 위젯 데이터 파일명
        if($this->filename) {
            //$this->widget['filename'] = $this->filename;
            return $this->filename;
        }

        // 위젯 정보에서 위젯 데이터 파일명
        if(isset($this->widget['filename'])) {
            return $this->widget['filename'];
        }

        // 위젯 데이터 파일명이 없는 경우
        // 라우트 경로와 파일 경로로 파일명 생성
        // if(isset($this->widget['route']) && isset($this->widget['path'])) {
        //     $filename = str_replace('/',DIRECTORY_SEPARATOR,$this->widget['route']);
        //     $filename .= DIRECTORY_SEPARATOR.$this->widget['path'];

        //     //dd($filename);
        //     return $filename;
        // }

        return null;
    }


    /**
     * 위젯 레이아웃 파일 경로
     */
    protected function viewFile()
    {
        if(isset($this->widget['view']['layout'])) {
            return $this->widget['view']['layout'];
        }

        if($this->viewFile) {
            return $this->viewFile;
        }

        return 'jiny-widgets::widgets.layout_list';
    }

    /**
     * 위젯 리스트 파일 경로
     */
    protected function viewListFile()
    {
        if(isset($this->widget['view']['list'])) {
            return $this->widget['view']['list'];
        }

        return 'jiny-widgets::list.group.list';
    }

    /**
     * 위젯 폼 파일 경로
     */
    protected function viewFormFile()
    {
        if(isset($this->widget['view']['form'])) {
            return $this->widget['view']['form'];
        }

        return "jiny-widgets::list.group.form";
    }


    public function updatedName()
    {
        //dump($this->name);
        // if($this->name) {
        //     $name = _getValue($this->name);
        //     $info = DB::table('site_widgets')
        //         ->where('name', $name)
        //         ->first();
        //     if($info) {
        //         $this->widget['name'] = $name;

        //         $this->viewList = $info->view_list;
        //         $this->widget['view']['list'] = $info->view_list;

        //         $this->viewForm = $info->view_form;
        //         $this->widget['view']['form'] = $info->view_form;
        //     }
        // }
    }

    /**
     * 위젯 렌더링
     */
    public function render()
    {
        if(!$this->filename) {
            return <<<EOD
            <div>Widget 데이터 파일명이 없습니다.</div>
            EOD;
        }

        return view($this->viewFile);
    }



    /**
     * Widget Design Mode CRUD
     */
    protected $listeners = [
        'create','popupFormCreate',
        'edit','popupEdit','popupCreate',
        'widget-layout-setting' => "WidgetSetLayout"
    ];

    public function create($value=null)
    {
        $this->popupForm = true;
        $this->edit_id = null;

        // 데이터초기화
        $this->forms = [];
    }

    public function store()
    {
        // 0 이상인 경우, 입력한 데이터값이 있다는 의미
        if(count($this->forms)>0) {
            // 2. 시간정보 생성
            $this->forms['created_at'] = date("Y-m-d H:i:s");
            $this->forms['updated_at'] = date("Y-m-d H:i:s");

            // 3. 파일 업로드 체크 Trait
            $this->fileUpload($this->forms, $this->upload_path);

            $i = count($this->rows)+1;
            $this->rows[$i] = $this->forms;
        }


        // 위젯 정보 저장
        $this->widget['items'] = $this->rows;
        $this->widgetSave($this->widget, $this->filename);

        $this->popupForm = false;
        $this->setup = false;
    }


    public function edit($id)
    {
        $this->edit_id = $id;

        $this->forms = $this->rows[$id];

        $this->popupForm = true;
    }


    public function update()
    {
        // 2. 시간정보 생성
        $this->forms['updated_at'] = date("Y-m-d H:i:s");

        // 3. 파일 업로드 체크 Trait
        $this->fileUpload($this->forms, $this->upload_path);


        $id = $this->edit_id;
        $this->rows[$id] = $this->forms;

        $this->widget['items'] = $this->rows;
        $this->widgetSave($this->widget, $this->filename);

        $this->forms = [];
        $this->edit_id = null;
        $this->popupForm = false;
        $this->setup = false;
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
        $this->deleteUploadFiles($this->rows[$id]);

        // 데이터삭제
        unset($this->rows[$id]);

        $this->widget['items'] = $this->rows;
        $this->widgetSave($this->widget, $this->filename);
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


    public $widget_select = false;
    public $widget_type = [];
    public function widgetPopup()
    {
        $this->widget_select = true;

        $rows = DB::table('site_widgets')->get();
        foreach($rows as $row) {
            $temp = [];
            foreach($row as $key => $value) {
                $temp[$key] = $value;
            }
            $this->widget_type[$row->id] = $temp;
        }
    }

    public function widgetPopupClose()
    {
        $this->widget_select = false;
    }

    public function widgetPopupSelect($id)
    {
        $this->widget_select = false;

        $row = $this->widget_type[$id];
        $this->widget['name'] = $row['name'];
        $this->widget['view']['list'] = $row['view_list'];
        $this->widget['view']['form'] = $row['view_form'];
    }

    public function resetItems()
    {
        $this->widget['items'] = [];
        $this->widgetSave($this->widget, $this->filename);

        $this->popupForm = false;
        $this->setup = false;
    }

    public function widgetApply()
    {
        $this->widget['name'] = $this->name;
        $this->viewList = $this->widget['view']['list'];
        $this->viewForm = $this->widget['view']['form'];
    }



}
