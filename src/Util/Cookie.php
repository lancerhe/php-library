<?php
namespace LancerHe\Library\Util;

/**
 * Class Cookie
 *
 * @package LancerHe\Library\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class Cookie {
    /**
     * @var array
     */
    public static $data = [];

    /**
     * @return bool
     */
    public static function isCli() {
        return (php_sapi_name() == 'cli');
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function get($name) {
        return self::isCli() ? self::$data[$name] : $_COOKIE[$name];
    }

    /**
     * @param        $name
     * @param        $value
     * @param int    $expire
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httponly
     */
    public static function set($name, $value, $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false) {
        self::isCli() ? (self::$data[$name] = $value) : setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * @param $name
     * @return bool
     */
    public static function has($name) {
        return self::isCli() ? array_key_exists($name, self::$data) : isset($_COOKIE[$name]);
    }

    /**
     * @param $name
     */
    public static function del($name) {
        if ( self::isCli() ) unset(self::$data[$name]); else setcookie($name, "", time() - 1);
    }
}