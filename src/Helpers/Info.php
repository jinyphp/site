<?php
namespace Jiny\Site;

if (!function_exists(__NAMESPACE__ . "\\Info")) {
    function Info($key = null) {
        $obj = \Jiny\Site\SiteInfo::instance("info");
        return $obj->get($key);
    }
}

if (!function_exists(__NAMESPACE__ . "\\Setting")) {
    function Setting($key = null) {
        $obj = \Jiny\Site\SiteSetting::instance("setting");
        return $obj->get($key);
    }
}

if (!function_exists(__NAMESPACE__ . "\\Header")) {
    function Header($key = null) {
        $obj = \Jiny\Site\SiteHeader::instance("header");
        return $obj->get($key);
    }
}

if (!function_exists(__NAMESPACE__ . "\\Footer")) {
    function Footer($key = null) {
        $obj = \Jiny\Site\SiteFooter::instance("footer");
        return $obj->get($key);
    }
}

if (!function_exists(__NAMESPACE__ . "\\MenuItems")) {
    function MenuItems($file) {
        $path = resource_path('menus');

        $filename = $path.DIRECTORY_SEPARATOR.$file;
        if(file_exists($filename)) {
            $json = file_get_contents($filename);
            return json_decode($json,true)['items'];
        }

        return [];
    }
}

