<?php
namespace Jiny\Site;

use Illuminate\Support\Facades\Auth;

class Slot
{
    private static $Instance;

    /**
     * 싱글턴 인스턴스를 생성합니다.
     */
    public static function instance()
    {
        if (!isset(self::$Instance)) {
            // 자기 자신의 인스턴스를 생성합니다.
            self::$Instance = new self();

            // 정보를 읽어 옵니다.
            self::$Instance->load();

            return self::$Instance;
        } else {
            // 인스턴스가 중복
            return self::$Instance;
        }
    }

    public $name;
    public $slots = [];

    public function load() {

        if($active = $this->checkUserSlot()) {
            return $this;
        }

        if($active = $this->checkSiteSlot()) {
            return $this;
        }

        return false;
    }

    /**
     * 여기에 인증된 사용자에 대한 처리를 추가합니다.
     */
    private function checkUserSlot()
    {
        $user = Auth::user();
        if($user){
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