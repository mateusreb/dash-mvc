<?php

namespace App\Controllers;

use App\Framework\Template\View;
use App\Framework\Xenforo\Xenforo;
use App\Framework\Routing\Redirect;
use App\Framework\Routing\Request;
use App\Framework\Helpers\Session;
use App\Framework\Helpers\Csrf;
use App\Framework\Helpers\Header;

//Models
use App\Models\Reports;
use App\Models\System;

class LoginController extends Controller
{
    public function index()
    {
        return View::show('login', $this->data);
    }

    public function auth()
    {
        $Request = new Request();
        if (Csrf::validate($Request->input('_csrf'))) 
        {
            if (Xenforo::xf()->auth($Request->input('username'), $Request->input('password'))) 
            {
                $xfinfo =  Xenforo::xf()->getUserInfoByName($Request->input('username'));

                if (!System::checkUserExists($xfinfo['username'])) 
                {
                    if (!System::createUser($xfinfo['username'])) 
                    {
                        return Redirect::to(
                            '/login',
                            ['alert-type' => 'danger',
                            'alert-text' => 'deu erro no login'
                        ]);
                    }
                }            
                Session::set('username', $xfinfo['username']);
                Session::set('user-id', $xfinfo['user_id']);
                Session::set('_ptoken', md5(hash('sha256', $xfinfo['username'] . Header::getUserIP() . Header::getUserAgent())));  
                
                Reports::registerLogin([
                    'user_id' => $xfinfo['user_id'],
                     'date' => date('Y-m-d h:i:s'),
                     'ip' => Header::getUserIP(),
                     'platform' => 'WEB',
                     'status' => 'OK',
                     'info' => Header::getUserAgent()
                ]);
                return Redirect::to('/home');
            }
        }
        return Redirect::to(
            '/login',
            ['alert-type' => 'danger',
            'alert-text' => 'erro no login'
        ]);
    }

    public function logout()
    {
        Session::destroy();
        Redirect::to('/login');
    }
}
