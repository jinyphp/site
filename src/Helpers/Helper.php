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
        // 여기에 인증된 사용자에 대한 처리를 추가합니다.
        $user = Auth::user();
        $slots = config("jiny.site.userslot");
        if($user){
            if($slots && isset($slots[$user->id])) {
                $activeSlot = $slots[$user->id];
                return $activeSlot;
            } else {
                $activeSlot = "";
            }

        } else {
            // 설정파일에서 active slot을 읽어옴
            $slots = config("jiny.site.slot");
            $activeSlot = "";
            if($slots) {
                foreach($slots as $slot => $item) {
                    if($item['active']) {
                        $activeSlot = $slot;
                        return $activeSlot;
                    }
                }
            }
        }

        return false;



        // // 로그인 상태인지 확인
        // $user = Auth::user();
        // $slots = config("jiny.site.userslot");
        // if($user && isset($slots[$user->id])) {
        //     // 사용자 www slot 반환
        //     return $slots[$user->id];
        // } else {
        //     // 설정파일에서 active slot을 읽어옴
        //     $slots = config("jiny.site.slot");
        //     $activeSlot = "";
        //     foreach($slots as $slot => $item) {
        //         if($item['active']) {
        //             // 시스템 기본 www slot
        //             $activeSlot = $slot;
        //             return $activeSlot;
        //         }
        //     }
        // }

        // return false;
    }
}
