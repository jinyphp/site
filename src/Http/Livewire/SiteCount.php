<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class SiteCount extends Component
{

    public function render()
    {
        // 기본값
        $viewFile = 'jiny-site::livewire.slot-session';
        return view($viewFile);
    }

}
