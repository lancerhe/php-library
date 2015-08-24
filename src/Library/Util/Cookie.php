<?php
/**
 * Cookie
 *
 * @category Library
 * @package  Util
 * @author   Lancer He <lancer.he@gmail.com>
 * @version  1.0 
 */

namespace Library\Util;

class Cookie {

    public static $data = [];

    public static function isCli() {
        return ( php_sapi_name() == 'cli' );
    }

    public static function get($name) {
        return self::isCli() ? self::$data[$name] : $_COOKIE[$name];
    }

    public static function set($name, $value, $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false ) {
        self::isCli() ? (self::$data[$name] = $value) : setcookie( $name, $value, $expire, $path, $domain, $secure, $httponly );
    }

    public static function has($name) {
        return self::isCli() ? array_key_exists($name, self::$data) : isset($name, $_COOKIE);
    }

    public static function del($name) {
        if ( self::isCli() ) unset(self::$data[$name]); else setcookie( $name, "", time() - 1 );
    }
}