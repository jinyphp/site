<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Livewire\Attributes\On;

class SiteSlotSetting extends Component
{
    public $viewFile;
    public $rows = [];
    public $selectedSlot;

    public $popupForm = false;
    public $popupDelete = false;
    public $confirm = false;
    public $actions = [];
    public $form = [];
    public $edit_id;

    public function mount()
    {
        $conf = str_replace("/",".",$this->actions['filename']);
        $this->rows = config($conf);
        foreach($this->rows as $key => $item) {
            if(isset($item['active']) && $item['active']) {
                $this->selectedSlot = $key;
            }
        }
    }

    public function render()
    {
        // 기본값
        $viewFile = 'jiny-site::admin.slot.list';

        if(isset($this->actions['view']['list'])) {
            $viewFile = $this->actions['view']['list'];
        }

        return view($viewFile);
    }

    public function selectSlot($option)
    {
        $this->selectedSlot = $option;
    }

    protected $listeners = [
        'popupFormOpen','popupFormClose',
        'create','popupFormCreate',
        'edit','popupEdit','popupCreate'
    ];


    #[On('popupFormCreate')]
    public function popupFormCreate($value=null)
    {
        return $this->create($value);
    }

    public function create($value=null)
    {
        $this->popupForm = true;
        $this->edit_id = null;


        $this->form = [];
        $this->form['name'] = "";
        $this->form['description'] = "";
    }

    // public function cancel()
    // {
    //     $this->popupForm = false;
    //     $this->actions = [];
    // }

    public function store()
    {
        $name = $this->form['name']; //$this->new_slot_name;

        $this->rows[$name] = [
            'active' => false,
            'name' => $name,
            'description' => $this->form['description']
        ];


        // 폴더 생성
        $path = resource_path('www');
        if(!is_dir($path."/".$name)) {
            mkdir($path."/".$name, 0777, true);
        }

        $this->apply();

        $this->popupForm = false;

    }

    public function edit($id)
    {
        $this->edit_id = $id;
        $this->form = $this->rows[$id];

        $this->popupForm = true;
    }

    public function update()
    {
        $id = $this->edit_id;
        $this->rows[$id] = $this->form;

        $this->phpSave($this->rows, $this->actions['filename']);

        $this->form = [];
        $this->edit_id = null;
        $this->popupForm = false;
    }

    public function cancel()
    {
        $this->form = [];
        $this->edit_id = null;
        $this->popupForm = false;
    }

    public function delete($id=null)
    {
        $this->popupDelete = true;
    }

    public function deleteCancel()
    {
        $this->popupDelete = false;
        $this->popupForm = false;
    }

    public function deleteConfirm()
    {
        $this->popupDelete = false;
        $this->popupForm = false;

        $id = $this->edit_id;
        $this->edit_id = null;
        // 실제동작
        unset($this->rows[$id]);
        $this->phpSave($this->rows, $this->actions['filename']);
    }



    public function apply()
    {
        foreach($this->rows as $key => &$item) {
            if($this->selectedSlot == $key) {
                $item['active'] = true;
            } else {
                $item['active'] = false;
            }
        }

        $this->phpSave($this->rows, $this->actions['filename']);

        // 페이지 리로드
        // return redirect()->refresh();
    }


    public function phpSave($rows, $filepath)
    {
        // 저장
        $str = $this->convToPHP($rows);
$file = <<<EOD
<?php
return $str;
EOD;
        // PHP 설정파일명
        $path = $this->filename($filepath);

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
