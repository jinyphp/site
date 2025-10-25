<?php
namespace Jiny\Site\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

use Livewire\Attributes\On;

/**
 * 선택한 국가의 세부 지역을 선택합니다.
 */
class SiteLocation extends Component
{
    public $actions;
    public $viewFile;

    public $country;
    public $location;
    public $rows = [];

    public function mount()
    {
        if(!$this->viewFile) {
            $this->viewFile = "jiny-site::site.location";
        }

        $country = session()->get('country');
        if($country) {
            $this->country = $country;
            $this->countryLocations($country);

        } else {
            $this->rows = [];
            $this->location = null;
        }

        //dd($this->rows);
    }


    private function countryLocations($country)
    {
        $cty = DB::table('site_country')
                    ->where('code', $country)
                    ->first();
        if($cty) {
            $rows = DB::table('site_location')
            ->where('country','like', $cty->id.":%")
            ->get();

            $this->rows = [];
            if(count($rows)>0) {

                foreach($rows as $item) {
                    $code = $item->id;
                    $temp = [];
                    foreach($item as $key => $value) {
                        $temp[$key] = $value;
                    }
                    $this->rows[$code] = $temp;
                }

                // 세션 값 가져오기
                $location = session()->get('location');
                if(!$location) {
                    if(isset($rows[0])) {
                        $this->location = $rows[0]->id;
                    }
                } else {
                    $this->location = $location;
                }
            }
        }
    }

    public function render()
    {
        return view($this->viewFile);
    }

    public function choose($code)
    {
        $this->location = $code;

        // 세션 값 설정
        session()->put('location', $code);
    }

    #[On('country-updated')]
    public function countryUpdated($code)
    {
        $this->countryLocations($code);
    }


}
