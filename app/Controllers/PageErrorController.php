<?php

namespace App\Controllers;

use App\Framework\Template\View;

class PageErrorController
{
    public function error404()
    {
        header("HTTP/1.0 404 Not Found");
        return View::show('404');
    }
}