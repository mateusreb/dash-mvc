<?php

namespace App\Controllers;

//Model
use App\Models\System;

class SystemController extends Controller
{
    public function downgradeUsers()
    {       
        print_r(System::listUsersExpiredLicenses());
        /*foreach(System::listUsersExpiredLicenses() as $user)
        {
            echo $user['user_id'] . " - ". $user['username'] ."</br>";
        }*/
    }
}
