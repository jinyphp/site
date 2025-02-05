<?php
use Illuminate\Support\Facades\View;



/**
 * 리소스 화면을 반환합니다.
 * $t 는 외부에서 전달받은 $this 객체 입니다.
 */
function getViewName($t, $default=null) {

    // 우선순위1 : actions 설정값
    //$aViewLayout = Action()->get('view.layout');
    if (isset($t->actions['view']['layout'])) {
        $aViewLayout = $t->actions['view']['layout'];
        if ($aViewLayout) {
            if($res = siteViewName($aViewLayout)){
                return $res;
            }
        }
    }


    // 우선순위2 :
    // 컨트롤러 코드에서 설정한 값이 있는 경우
    if($t->viewFileLayout) {
        // 2-1:
        $viewFile = $t->viewFileLayout;
        if($res = siteViewName($viewFile)){
            return $res;
        }
    }


    // 우선순위3 :
    if($default) {
        return $default;
    }


    return false;
}

// 1. theme->slot-www 순으로 검색
function siteViewName($viewFile) {
    // 1.절대경로 확인
    if($res = isPackageView($viewFile)) {
        return $res;
    }

    // 2. slot 검사
    // 패키지 경로가 포함됨
    if($viewFile = inSlotView($viewFile)) {
        return $viewFile;
    }

    // 2: 테마 파일
    if($result = inThemeView($viewFile)) {
        return $result;
    }

    // 3: resources/views
    if(View::exists($viewFile)) {
        return $viewFile;
    }

    return false;
}


function isPackageView($viewFile)
{
    // 페키지 경로를 모두 포함해서 검사함
    if (strpos($viewFile, '::') !== false) {
        if (View::exists($viewFile)) {
            return $viewFile;
        }
    }

    return false;
}

/**
 * Slot _partials 안에서 리소스를 검출할 수 있도록
 * prefix 코드를 붙여 줍니다.
 */
if(!function_exists("inSlotPartial")) {
    function inSlotPartial($viewFile, $prefix = "www")
    {
        // $slot = www_slot();
        $slot = Slot()->name;
        return $prefix."::".$slot."."."_partials.".$viewFile;
    }
}


/**
 * Slot 안에서 리소스를 검출할 수 있도록
 * prefix 코드를 붙여 줍니다.
 */
if(!function_exists("inSlot")) {
    function inSlot($viewFile, $prefix = "www") {
        // $slot = www_slot();
        $slot = Slot()->name;
        return $prefix."::".$slot.".".$viewFile;
    }
}


// 슬롯안에 뷰가 있는지 검사
// 순차적으로 검사, slot -> www -> default
function inSlotView($viewFile, $default = null)
{
    // 페키지 경로를 모두 포함해서 검사함
    if (strpos($viewFile, '::') !== false) {
        return $viewFile;
    }

    // 페키지 경로가 없는 겨우에는 slot에서 검색
    // 먼저 슬롯 안에 있는지
    $prefix = "www";
    $slot = Slot()->name;
    if($slot) {
        if(View::exists($prefix."::".$slot.".".$viewFile)) {
            return $prefix."::".$slot.".".$viewFile;
        }
    }
    // slot에 없는 경우 상위 www 공용안에 있는지 검사
    else {
        if(View::exists($prefix."::".$viewFile)) {
            return $prefix."::".$viewFile;
        }
    }

    // 기본 리소스가 있는 경우
    if($default) {
        return $default;
    }

    return false;
}


function inThemeView($viewFile)
{
    $theme = trim(xTheme()->getName(),'"');
    $theme = str_replace('/','.',$theme);
    if($theme) {
        // 테마 리소스가 있는 경우
        if (View::exists("theme::".$theme.".".$viewFile)) {
            return "theme::".$theme.".".$viewFile;
        }
    }

    return false;
}

