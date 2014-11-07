<?php
/**
 * Util_ShutdownEvent Manage php shutdown events.
 *
 * @category Library
 * @package  Util
 * @author   Lancer He <lancer.he@gmail.com>
 * @version  1.0 
 * @since    2014-08-21
 */
class Util_ShutdownEvent {

    /**
     * array to store user events.
     * @var array
     */
    private static $_events = null;

    /**
     * register shutdown
     */
    public function __construct() {
        if ( is_array(self::$_events) ) return;

        self::$_events = array();
        register_shutdown_function(array($this, 'call'));
    }

    /**
     * Register event.
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
        foreach (self::$_events as $event) {
            $callback = array_shift($event);
            call_user_func_array($callback, $event);
        }
    }
}