<?php

require_once __DIR__ . "/../routes/web.php";


class App 
{        
    public function Init()
    {
        App\Framework\Database\DB::openConnection();
        App\Framework\Helpers\Session::init();
        App\Framework\Routing\Route::run();    
    }
}