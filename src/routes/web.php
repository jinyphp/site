<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

if(!function_exists("route_dynamic")) {

    // Fallack 사이트 오토라우팅
    Route::fallback(function () {

        if(isset($_SERVER['REQUEST_URI'])) {
            if($res = route_dynamic($_SERVER['REQUEST_URI'])) {
                return $res;
            }
        }

        // shop 리소스에서
        // 404 오류 페이지 출력
        if(view()->exists("www::404")) {
            return view("www::404");
        }

        // fallback 리소스에서
        //return view("fallback::404");
        return $_SERVER['REQUEST_URI']."의 리소스를 찾을 수 없습니다.";

    })->middleware('web');


    function route_dynamic($uri) {
        //1. blade.php 파일이 있는 경우 찾아서 출력함
        if($res = route_isBlade($uri)) {
            return $res;
        }

        //2. Markown 파일이 있는 경우 찾아서 출력함
        if($res = route_isMarkdown($uri)) {
            return $res;
        }

        //9. 리소스가
        if($res = route_isBladeResource($uri)) {
            return $res;
        }

    }

    // shop 폴더에서 검색
    function route_isBlade($uri) {
        $prefix_www = "www";
        $filename = str_replace('/','.',$uri);
        $filename = ltrim($filename,".");

        // resources.shop
        // 지정한 파일이름
        if(view()->exists($prefix_www."::".$filename)) {
            return view($prefix_www."::".$filename);
        }
        // 파일이 존재하지 않고, 폴더명인 경우
        // 폴더 안에 있는 index로 대체
        else
        if(view()->exists($prefix_www."::".$filename.".index")) {
            return view($prefix_www."::".$filename.".index");
        }
    }

    // 리소스폴더에서 검색
    function route_isBladeResource($uri) {
        $filename = str_replace('/','.',$uri);
        $filename = ltrim($filename,".");

        // 리소스폴더에 파일명과 동일한 blade 파일이 있는지 확인
        if (view()->exists($filename))
        {
            // 리소스 뷰를 바로 출력합니다.
            return view($filename);
        }
        // 혹시 폴더명이 존재하는 경우, $filename/index.blade.php를
        // 출력합니다.
        else if (view()->exists($filename.".index"))
        {
            return view($filename.".index");
        }

    }

    // 마크다운 파일인 경우
    function route_isMarkdown($uri) {
        $prefix_www = "www";
        $filename = str_replace('/','.',$uri);
        $filename = ltrim($filename,".");

        // 마크다운 페이지 생성
        $path = resource_path($prefix_www);
        $txt = null;
        if(file_exists($path.DIRECTORY_SEPARATOR.$filename.".md")) {
            $txt = file_get_contents($path.DIRECTORY_SEPARATOR.$filename.".md");
        }
        else
        if(file_exists($path.DIRECTORY_SEPARATOR.$filename.DIRECTORY_SEPARATOR."index.md")) {
            $txt = file_get_contents($path.DIRECTORY_SEPARATOR.$filename.DIRECTORY_SEPARATOR."index.md");
        }

        if($txt) {
            $Parsedown = new Parsedown();
            $content = $Parsedown->parse($txt);
            return view("www::_layouts.markdown",['content'=>$content]);
        }

    }

}





