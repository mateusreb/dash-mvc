<?php

namespace App\Framework\Helpers;

use App\Framework\Helpers\Session;

class Csrf {
    public static function generate()
    {
        if(Session::exists('_csrf'))
        {
            return Session::get('_csrf');
        }        
        $token = md5(hash('sha256', time() . uniqid(mt_rand())));
        Session::set('_csrf', $token);
        return $token;        
    }

    public static function validate($token)
    {
        if($token && Session::exists('_csrf') )
        {
            if($token == Session::get('_csrf')){
                Session::delete('_csrf');
                return true;
            }
        }
        Session::delete('_csrf');
        return false;
    }
}