<?php
namespace Jiny\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Slot
{
    private static $Instance;
    public $request;

    /**
     * 싱글턴 인스턴스를 생성합니다.
     */
    public static function instance()
    {

        if (!isset(self::$Instance)) {
            // 자기 자신의 인스턴스를 생성합니다.
            self::$Instance = new self();

            // 정보를 읽어 옵니다.
            $user = user(); // 싱글턴 객체
            //dump($user);
            //dump("slot load");
            self::$Instance->reload();

            return self::$Instance;
        } else {
            // 인스턴스가 중복
            return self::$Instance;
        }
    }

    public $name;
    public $slots = [];

    public function reload()
    {
        //$user = user(); // 싱글턴 객체
        //dump($user);

        if($active = $this->checkUserSlot()) {
            //dump("userSlot");
            return $this;
        }

        if($active = $this->checkSiteSlot()) {
            //dump("siteSlot");
            return $this;
        }

        return false;
    }

    public function load() {

        if($active = $this->checkUserSlot()) {
            //dump("userSlot");
            return $this;
        }

        if($active = $this->checkSiteSlot()) {
            //dump("siteSlot");
            return $this;
        }

        return false;
    }

    /**
     * 여기에 인증된 사용자에 대한 처리를 추가합니다.
     */
    private function checkUserSlot()
    {
        //$user = Auth::user();
        $user = user(); // 싱글턴 객체
        if($user && isset($user->id)){
            //dd($user);

            $slots = config("jiny.site.userslot");
            $this->slots = $slots;

            if($slots && isset($slots[$user->id])) {
                $activeSlot = $slots[$user->id];
                $this->name = $activeSlot;
                return true;
            }
        }

        return false;
    }

    /**
     * 설정파일에서 active slot을 읽어옴
     */
    private function checkSiteSlot()
    {
        $slots = config("jiny.site.slot");
        $this->slots = $slots;
        if($slots) {
            foreach($slots as $slot => $item) {
                if($item['active']) {
                    $activeSlot = $item['name'];//slot;
                    $this->name = $activeSlot;

                    return true;
                }
            }
        }

        return false;
    }


    /**
     * 임시로 슬롯을 변경할 수 있습니다.
     */
    public function temp($name)
    {
        $this->name = $name;
    }


}
