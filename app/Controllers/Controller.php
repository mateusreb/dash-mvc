<?php

namespace App\Controllers;

use App\Framework\Routing\Redirect;
use App\Framework\Helpers\Session;
use App\Framework\Helpers\Alerts;
use App\Framework\Xenforo\Xenforo;
use App\Framework\Helpers\Csrf;
use App\Framework\Helpers\Header;

abstract class Controller
{
    protected $data;
    
    public function __construct()
    {
        $this->data['alert'] = Alerts::get(); 
        $this->data['_csrf'] = Csrf::generate(); 

        if(Session::exists('_ptoken'))
        { 
            $xfuser = Xenforo::xf()->getUserInfoByName(Session::get('username'));
            //print_r($xfuser);
            if($xfuser)
            {
                $this->data['description'] = '';   
                $this->data['avatar'] = Xenforo::xf()->getAvatar($xfuser['username']); 
                $this->data['username'] = $xfuser['username'];
                $this->data['user-id'] =  $xfuser['user_id'];  
                $this->data['user-group'] = $xfuser['user_group_id'];  
                $this->data['is-admin'] = $xfuser['is_admin']; 
            }
            else
            {
                Session::destroy();
                //return Redirect::to('/login');
            }   
        }  
    }

    protected function protect()
    {
        if (Session::get('_ptoken') != md5(hash('sha256', Session::get('username') . Header::getUserIP() . Header::getUserAgent())))
        {
            Session::destroy();
            return Redirect::to('/login');                       
        }   
    }
    
    protected function admin()
    {
        if(!$this->data['is-admin'])
        {
            return Redirect::to('/'); 
            die();
        }
    }
}