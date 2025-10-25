<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class SiteScreen extends Component
{
    public $search;
    public $popup = false;
    public $rows = [];

    public $viewFile;

    public function mount()
    {
        //$this->search = request()->get('search');
        if(!$this->viewFile) {
            $this->viewFile = 'jiny-site::site.screen';
        }
    }

    public function render()
    {
        return view($this->viewFile);
    }

    public function clear()
    {
        $this->search = null;
    }

    public function cancel()
    {
        $this->popup = false;
    }

    public function pageSearch()
    {
        $this->popup = true;

        $rows = DB::table('site_screen')->get();
        $this->rows = [];
        foreach ($rows as $row) {
            $temp = [];
            foreach ($row as $key => $value) {
                $temp[$key] = $value;
            }

            $this->rows []= $temp;
        }

        //dd($this->rows);
    }

    public function move($uri)
    {
        //($uri);
        return redirect($uri);
    }
}
