<?php

namespace App\Framework\Template;

class View
{
    protected static $contentpath;

    public static function show($path, $data = []){
        if (is_array($data))
            extract($data);
        $path = "/" . $path;
        $config = require_once "../config/globals.php";
        return require_once "../resources/views" . str_replace( '.', '/', $path ) . ".php";
    }

    protected static function content($data = [])
    {
        require_once "../resources/views" . str_replace( '.', '/', self::$contentpath ) . ".php";
    }

    public static function make($path, $data = []){
        if (is_array($data))
            extract($data);
        $path = "/" . $path;

        self::$contentpath = $path;
        $config = require_once "../config/globals.php";
        return require_once "../resources/views/layout/layout.php";
    }
}