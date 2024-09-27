<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class SiteTermsUse extends Component
{
    public $actions = [];

    public $slug;
    public $terms = [];
    public $termBlade;

    use \Jiny\Widgets\Http\Trait\DesignMode;


    public $popupForm = false;
    public $popupWindowWidth = "4xl";
    public $message;
    public $popupDelete = false;
    public $confirm = false;

    public $forms = [];
    public $forms_old=[];

    public $content;
    public $editable = false;

    public function mount()
    {
        $this->actions['view']['form'] = 'jiny-site::admin.terms.form';

        if($terms = $this->fetch()) {
            // 처음 데이터 선택
            $this->termBlade = "www::shop_fashion-v1.terms.".$terms[0]->slug;
        }

        if($this->slug) {
            $this->termBlade = "www::shop_fashion-v1.terms.".$this->slug;
        }
    }

    private function fetch()
    {
        $terms = DB::table('site_terms')->get();
        if($terms) {
            $this->terms = [];
            foreach($terms as $item){
                $temp = [];
                foreach($item as $key => $value) {
                    $temp[$key] = $value;
                }
                $this->terms []= $temp;
            }
        }

        return $terms;
    }


    public function render()
    {
        $this->fetch();

        $term = null;
        if($this->slug) {
            foreach($this->terms as $item) {
                if($item['slug'] == $this->slug) {
                    $term = $item;
                    break;
                }
            }
        }

        // 기본값
        $viewFile = 'jiny-site::site.termsUse.livewire';
        return view($viewFile,[
            'term' => $term
        ]);
    }

    public function choose($id)
    {
        //dd($id);
        $this->termBlade = "www::shop_fashion-v1.terms.use".$id;
    }

    public function create($ref=null)
    {
        $this->popupForm = true;

        unset($this->actions['id']);
        $this->forms = [];
    }

    public function cancel()
    {
        $this->forms = [];
        //$this->forms_old = [];
        $this->popupForm = false;
        $this->popupDelete = false;
        $this->confirm = false;
    }

    public function store()
    {
        $this->popupForm = false;

        $this->forms['created_at'] = date("Y-m-d H:i:s");
        $this->forms['updated_at'] = date("Y-m-d H:i:s");
        DB::table('site_terms')->insert($this->forms);


        //$this->terms []= $this->forms;

        $this->forms = [];
    }

    public function edit($id)
    {
        if($id) {
            $this->actions['id'] = $id;
        }

        $row = DB::table('site_terms')->where('id', $id)->first();
        $this->forms = [];
        foreach($row as $key => $val) {
            $this->forms[$key] = $val;
        }

        $this->popupForm = true;
    }

    public function update()
    {
        $id = $this->forms['id'];
        DB::table('site_terms')->where('id', $id)->update($this->forms);

        $this->forms = [];
        $this->popupForm = false;

        unset($this->actions['id']);
    }

     /** ----- ----- ----- ----- -----
     *  데이터 삭제
     *  삭제는 2단계로 동작합니다. 삭제 버튼을 클릭하면, 실제 동작 버튼이 활성화 됩니다.
     */
    public function delete($id=null)
    {
        $this->popupDelete = true;
    }

    public function deleteCancel()
    {
        $this->popupDelete = false;
    }

    public function deleteConfirm()
    {
        $this->popupDelete = false;
        $this->popupForm = false;

        // 데이터 삭제
        DB::table('site_terms')
        ->where('id', $this->actions['id'])
        ->delete();

        $this->forms = [];
    }

    public function contentEdit()
    {
        $this->editable = true;

        $path = View::getFinder()->find($this->termBlade);
        if(file_exists($path)) {
            $this->content = file_get_contents($path);
        } else {
            $this->content = null;
        }

    }

    public function updateContent()
    {
        $path = View::getFinder()->find($this->termBlade);
        file_put_contents($path, $this->content);

        $this->editable = false;
        //$this->design = false;
    }

    public function agree($id)
    {

    }

}
