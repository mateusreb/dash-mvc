<?php

namespace App\Framework\Helpers;

class Session
{
    private static $sessionStarted = false;

    public static function init()
    {
        if (!self::$sessionStarted ) 
        {
            if (!session_id() ) {
                session_start();
            }
            self::$sessionStarted = true;
        }
    }

    public static function exists($name)
    {
        if (strpos($name, '.') ) {
            $key = explode('.', $name);
            if (isset($_SESSION[$key[0]][$key[1]]) ) {
                return true;
            }
        } else {
            if (isset($_SESSION[$name]) ) {
                return true;
            }
        }
        return false;
    }

    public static function set($name, $value)
    {
        if (strpos($name, '.')) {
            $key = explode('.', $name);
            return $_SESSION[$key[0]][$key[1]] = $value;
        } else {
            return $_SESSION[$name] = $value;
        }
        return null;
    }

    public static function get($name)
    {
        if (strpos($name, '.') ) {
            $key = explode('.', $name);
            if (isset($_SESSION[$key[0]][$key[1]]) ) {
                return $_SESSION[$key[0]][$key[1]];
            }
        } else {
            if (self::exists($name) ) {
                return $_SESSION[$name];
            }
        }
        return null;
    }

    public static function delete($name)
    {
        if ( strpos($name, '.') ) 
        {
            $key = explode('.', $name);
            if ( isset($_SESSION[$key[0]][$key[1]])) 
            {
                unset($_SESSION[$key[0]][$key[1]]);
            }
        } 
        else 
        {
            if ( self::exists($name) ) 
            {
                unset($_SESSION[$name]);
            }
        }
        return null;
    }

    public static function destroy()
    {
        if (self::$sessionStarted) 
        {
            session_destroy();
        }
    }
}