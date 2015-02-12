<?php
/**
 * Util_Cookie
 *
 * @category Library
 * @package  Util
 * @author   Lancer He <lancer.he@gmail.com>
 * @version  1.0 
 */
class Util_Cookie {

    public static $data = [];

    public static function isCli() {
        return ( php_sapi_name() == 'cli' );
    }

    public static function get($name) {
        if ( self::isCli() )
            return ( isset(self::$data[$name]) ) ? self::$data[$name] : false;
        else
            return ( isset($_COOKIE[$name]) ) ? $_COOKIE[$name] : false;
    }

    public static function set($name, $value, $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false ) {
        if ( self::isCli() )
            self::$data[$name] = $value;
        else
            setcookie( $name, $value, $expire, $path, $domain, $secure, $httponly );
    }

    public static function has($name) {
        if ( self::isCli() )
            return ( isset(self::$data[$name]) ) ? true : false;
        else
            return ( isset($_COOKIE[$name]) ) ? true : false;
    }

    public static function del($name) {
        if ( self::isCli() )
            unset(self::$data[$name]);
        else
            setcookie( $name, "", time() - 1 );
    }
}