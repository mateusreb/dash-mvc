<?php

namespace App\Framework\Helpers;

class Alerts {
    public static function get()
    {
        if (Session::exists('alert-type') && Session::exists('alert-text')) {
            $type = Session::get('alert-type');
            Session::delete('alert-type');
            $text = Session::get('alert-text');            
            Session::delete('alert-text');
            return "<div class='alert alert-{$type}' role='alert'>{$text}</div>";
        } else {
            return '';
        }
    }

}