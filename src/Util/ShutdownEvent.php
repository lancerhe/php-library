<?php
namespace LancerHe\Library\Util;

/**
 * Class ShutdownEvent
 *
 * @package LancerHe\Library\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class ShutdownEvent {
    /**
     * array to store user events.
     *
     * @var array
     */
    private static $_events = null;

    /**
     * register shutdown
     */
    public function __construct() {
        if ( is_array(self::$_events) ) return;
        self::$_events = [];
        register_shutdown_function([$this, 'call']);
    }

    /**
     * Register event.
     *
     * @return boolean
     */
    public function add() {
        $event = func_get_args();
        if ( empty($event) ) {
            return trigger_error("Register event need method.", E_USER_WARNING);
        }
        if ( ! is_callable($event[0]) ) {
            return trigger_error("Register event can not be call.", E_USER_WARNING);
        }
        self::$_events[] = $event;
        return true;
    }

    /**
     * call event when you need.
     */
    public function call() {
        foreach ( self::$_events as $event ) {
            $callback = array_shift($event);
            call_user_func_array($callback, $event);
        }
    }
}