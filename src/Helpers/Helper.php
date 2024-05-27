<?php
use Illuminate\Support\Facades\Auth;

if(!function_exists("www_view")) {
    function www_view($path, $args=[]) {
        $prefix = "www";
        return view($prefix."::".$path, $args);
    }
}

if(!function_exists("www_slot_view")) {
    function www_slot_view($path, $args=[], $slot=null) {
        $prefix = "www";

        if(!$slot) {
            return view($prefix."::".$path, $args);
        }

        return view($prefix."::".$slot.".".$path, $args);
    }
}

if(!function_exists("www_slot")) {
    function www_slot() {
        $activeSlot = "";

        // 여기에 인증된 사용자에 대한 처리를 추가합니다.
        $user = Auth::user();
        $slots = config("jiny.site.userslot");
        if($user){
            if($slots && isset($slots[$user->id])) {
                $activeSlot = $slots[$user->id];
                return $activeSlot;
            }
        }


        // 설정파일에서 active slot을 읽어옴
        $slots = config("jiny.site.slot");
        if($slots) {
            foreach($slots as $slot => $item) {
                //dump($item);
                if($item['active']) {
                    $activeSlot = $item['name'];//slot;
                    //dump($activeSlot);
                    return $activeSlot;
                }
            }
        }


        return $activeSlot;
        //return false;

    }
}




