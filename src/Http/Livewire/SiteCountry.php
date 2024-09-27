<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class SiteCountry extends Component
{
    public $actions;
    public $viewFile;

    public $country;
    public $rows = [];

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site::site.country";
        }

        $rows = country();
        $this->rows = [];
        foreach($rows as $item) {
            $code = $item->code;
            $temp = [];
            foreach($item as $key => $value) {
                $temp[$key] = $value;
            }
            $this->rows[$code] = $temp;
        }

        // 세션 값 가져오기
        $country = session()->get('country');
        if(!$country) {
            $this->country = $rows[0]->code;
        } else {
            $this->country = $country;
        }

    }


    public function render()
    {
        return view($this->viewFile);
    }

    public function choose($code)
    {
        $this->country = $code;

        // 세션 값 설정
        session()->put('country', $code);

        // 이벤트 발생
        $this->dispatch('country-updated', $code);
    }


}
