<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteMenuCode extends Component
{
    public $actions = [];
    public $forms = [];
    public $filename;
    public $edit_id;

    public $menus = [];

    public $popupDelete = false;
    public $confirm = false;

    public function mount()
    {
        $this->actions['view']['form'] = "jiny-site::admin.menu.form";

        $this->scanMenuFiles();
    }

    private function scanMenuFiles()
    {
        $this->menus = [];

        $path = resource_path('menus');
        $dir = scandir($path);
        foreach($dir as $item) {
            if($item == '.' || $item == '..') continue;
            $this->menus []= $item;
        }
    }

    public function render()
    {
        // 기본값
        $viewFile = 'jiny-site::admin.menu.code';
        return view($viewFile);
    }

    public function setMenu($menu)
    {
        //dd($menu);
        $this->dispatch('setMenuFile', $menu);
    }

    public $popupForm = false;
    public $popupWindowWidth = "4xl";
    public $message;

    public function create()
    {
        $this->forms = [];
        $this->popupForm = true;
    }

    public function store()
    {
        $this->popupForm = false;

        if(isset($this->forms['code'])) {
            DB::table('site_menus')->insert($this->forms);

            // 파일 생성
            $path = resource_path('menus');
            if(!is_dir($path)) mkdir($path,0777,true);

            $filename = $path.DIRECTORY_SEPARATOR.$this->forms['code'].".json";
            file_put_contents($filename, "");

            $this->scanMenuFiles();
        }


    }

    public function cancel()
    {
        $this->forms = [];
        $this->edit_id = null;
        $this->popupForm = false;
    }

    public function edit($item)
    {
        $this->actions['id'] = $item;
        $this->edit_id = $item;

        $code = str_replace(".json","",$item);
        $row = DB::table('site_menus')->where('code',$code)->first();
        if($row) {
            $this->forms = [];
            foreach($row as $key => $value) {
                $this->forms[$key] = $value;
            }
        }

        $this->filename = $this->forms['code'];


        $this->popupForm = true;
    }

    public function update()
    {
        $this->popupForm = false;

        $code = str_replace(".json","",$this->edit_id);
        $row = DB::table('site_menus')
            ->where('code',$code)
            ->update($this->forms);

        // 파일이름 변경
        if($this->filename != $this->forms['code']) {
            $path = resource_path('menus');
            $src = $path.DIRECTORY_SEPARATOR.$this->filename.".json";
            $dst = $path.DIRECTORY_SEPARATOR.$this->forms['code'].".json";
            rename($src, $dst);

            $this->scanMenuFiles();
        }

        $this->forms = [];
        //dd($row);
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

    }

    /**
     * 삭제 확인 컨펌을 하는 경우에,
     * 실제적인 삭제가 이루어짐
     */
    public function deleteConfirm()
    {
        $this->popupDelete = false;
        $this->popupForm = false;

        //dd($this->edit_id);
        // 파일 생성
        $path = resource_path('menus');
        if(!is_dir($path)) mkdir($path,0777,true);

        $filename = $path.DIRECTORY_SEPARATOR.$this->forms['code'].".json";
        if(file_exists($filename)) {
            unlink($filename);

            //$code = str_replace(".json","",$item);
            $row = DB::table('site_menus')
                ->where('code',$this->forms['code'])
                ->delete();

            $this->forms = [];

            $this->scanMenuFiles();
        }



        $id = $this->edit_id;
        $this->edit_id = null;


    }

}
