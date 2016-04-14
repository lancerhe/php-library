<?php
/**
 * Timer
 *
 * @category Library
 * @package  Util
 * @author   Lancer He <lancer.he@gmail.com>
 * @version  1.0 
 */

namespace Library\Util;

class Timer {

    /**
    * @var array $_timer Collection of timers
    */
    private static $_timer = array();

    /**
     * start - Start a timer
     *
     * @param string $id The id of the timer to start
     */
    public static function start($id) {
        if (isset(self::$_timer[$id]))
            throw new Exception("Timer already set: $id");

        self::$_timer[$id] = self::microtime();
    }
    
    /**
     * stop - Stop a timer
     *
     * @param string $id The id of the timer to stop
     */
    public static function stop($id) {
        return self::microtime() - self::$_timer[$id];
    }

    /**
     * get microtime float
     */
    public static function microtime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
}