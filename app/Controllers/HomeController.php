<?php

namespace App\Controllers;

use App\Framework\Template\View;
use App\Framework\Xenforo\Xenforo;
use App\Models\User;

use App\Models\Product;
class HomeController extends Controller
{
    public function index()
    {        
        $this->protect();        
        $this->data['pagetitle'] = 'Home';
       //Xenforo::xf()->upgradeUser(72183, Xenforo::SGROUP_PBLA);  
        //Xenforo::xf()->banUser(72183);  
        //Xenforo::xf()->downgradeUser(72183, Xenforo::GROUP_USER); 
        //print_r(Xenforo::GetUserInfo($this->data['username']));     
        /*if ($this->data['is-admin']) 
        {           
            return View::make('admin.index', $this->data);
        } 
        else 
        {*/
            $this->data['user-subscriptions'] = User::getSubscriptions($this->data['user-id']);
            $this->data['user-counts']['subscriptions'] = User::getSubscriptionCount($this->data['user-id']);
            $this->data['user-counts']['transactions'] = User::getTransactionsCount($this->data['user-id']);
            $this->data['user-counts']['connections'] = User::getConnectionsCount($this->data['user-id']);
            $this->data['user-counts']['resets'] = User::getResetCount($this->data['user-id']);           
            return View::make('user.index', $this->data);
        //}
    }
}