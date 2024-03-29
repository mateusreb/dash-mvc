<?php

namespace App\Framework\Helpers;

class Cookie
{

    /**
     * Verifica se um cookie existe
     *
     * @access public
     * @param string 	$name 	Nome do cookie
     * @return boolean
     */
    public static function exists($name)
    {
        $cookie = filter_input(INPUT_COOKIE, $name, FILTER_DEFAULT);
        return ( isset($cookie) ? true : false );
    }

    /**
     * Cria um cookie
     *
     * @access public
     * @param string 	$name 		Nome do cookie
     * @param string 	$value 		Valor do cookie
     * @param int 		$expiry 	Validade do cookie
     * @return boolean
     */
    public static function set($name, $value, $expiry)
    {
        if ( setcookie($name, $value, time() + $expiry, '/') ) {
            return true;
        }

        return false;
    }

    /**
     * Obtém o valor de um cookie
     *
     * @access public
     * @param string 	$name 	Nome do cookie
     * @return string
     */
    public static function get($name)
    {
        $cookie = filter_input(INPUT_COOKIE, $name, FILTER_DEFAULT);
        return self::exists($name) ? $cookie : null;
    }

    /**
     * Deleta um cookie
     *
     * @access public
     * @param string 	$name 	Nome do cookie
     * @return void
     */
    public static function delete($name)
    {
        self::set($name, '', time() - 1);
    }
}