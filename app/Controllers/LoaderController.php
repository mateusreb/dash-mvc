<?php

namespace App\Controllers;


//Models
use App\Models\Loader;

class LoaderController
{
    public function auth()
    {
        echo Loader::auth();    
    }

    public function check()
    {
        echo Loader::check();    
    }
}
