<?php

namespace App\Framework\Routing;

use App\Framework\Helpers\Session;

class Redirect
{
    public static function to($location, $data = [])
    {
        if ($data)
        {
            foreach ($data as $key => $value) 
            {
                Session::set($key, $value);
            }
        }
        return die(header("Location: {$location}"));        
    }
}