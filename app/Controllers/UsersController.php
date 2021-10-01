<?php

namespace App\Controllers;

use App\Framework\Template\View;
use App\Framework\Helpers\Modals;
use App\Framework\Routing\Request;
use App\Framework\Routing\Redirect;
use App\Framework\Helpers\Csrf;

//Models
use App\Models\User;
use App\Models\Users;
use App\Models\Guid;

class UsersController extends Controller
{
    public function manageUsers()
    {
        $this->protect();  
        $this->admin();      
        $this->data['pagetitle'] = 'Manage Users';
        $this->data['users-vip'] = Users::listUsersVIP();
        $this->data['modal'] = Modals::Alert(
            'modalDeleteUser',
            'Attention',
            'Do you want to delete this user?',
            'warning',
            'exclamation-triangle',
            ['user-id'],
            '/manage-users/delete'
        );
        return View::make('admin.manage-users', $this->data);
    }

    public function editUser($user_id)
    {
        $this->protect();  
        $this->admin();
        $this->data['user-info'] = Users::getUserInfo($user_id);
        $this->data['pagetitle'] = 'Edit User - ' . $this->data['user-info']['username'];      
        $this->data['user-info']['guid-status'] = Guid::guidIsBanned($this->data['user-info']['guid'], $this->data['user-info']['user_id']);   
        return View::make('admin.edit-user', $this->data);
    }

    public function userDetails($user_id)
    {
        $this->protect();  
        $this->admin();
        $this->data['user-info'] = Users::getUserInfo($user_id);
        $this->data['pagetitle'] = 'User Details - ' . $this->data['user-info']['username'];
        $this->data['transactions'] = User::getTransactions($user_id);
        return View::make('admin.user-details', $this->data);
    }

    public function postEditUser($user_id)
    {
        $this->protect();  
        $this->admin();
        $Request = new Request();
        if($Request->input('_csrf'))
        {         
            $product_id = $Request->input('product_id');
            if(Users::updateUser($Request->body(), $product_id))
            {
                return Redirect::to(
                    "/manage-user/edit/{$user_id}",
                     ['alert-type' => 'success',
                      'alert-text' => 'User information successfully updated.']
                );
            }
        }
        return Redirect::to(
            "/manage-user/edit/{$user_id}",
            ['alert-type' => 'danger',
            'alert-text' => 'Problem modifying user information.']
        );
    }

    public function postDeleteUser()
    {      
        $this->protect();  
        $this->admin();
        $Request = new Request();
        if($Request->input('_csrf'))
        {
            if(Users::deleteUser($Request->input('user-id')))
            {
                return Redirect::to(
                    '/manage-users',
                    ['alert-type' => 'success',
                    'alert-text' => 'User deleted successfully.']
                );
            }
        }
        return Redirect::to(
            '/manage-products',
            ['alert-type' => 'danger',
            'alert-text' => 'Problem deleting user.']
        );
    }
}