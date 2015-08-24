<?php
/**
 * Session
 *
 * @category Library
 * @package  Util
 * @author   Lancer He <lancer.he@gmail.com>
 * @version  1.0 
 */

namespace Library\Util;

class Session {

    public static function getInstance() {
        return ( php_sapi_name() == 'cli' ) ? Session_Cli::getInstance() : Session_Http::getInstance();
    }
}


/**
 * CLI模式下会模拟一个session_id，同时在/tmp/下产生一个sesscli文件用来保存session信息
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-23
 * @copyright http://www.crackedzone.com
 */
class Session_Cli implements Session_Interface  {
 
    protected static $_instance = null;
 
    /**
     * session_id
     * @var string
     */
    protected $_session_id = null;
 
    /**
     * session数组
     * @var array
     */
    protected $_session = array();
 
    /**
     * session是否已经开启
     * @var boolean
     */
    protected $_started = false;
 
    /**
     * 单例模式禁止Clone
     */
    private function __clone() {}
 
    /**
     * 单例模式禁止外部初始化
     */
    private function __construct() {}
 
    /**
     * 返回单例模式
     */
    public static function getInstance() {
        if ( ! is_null( self::$_instance ) ) {
            return self::$_instance;
        }
 
        $instance = new self();
        $instance->start();
        self::$_instance = $instance;
        return $instance;
    }

    public function getSessionId() {
        return $this->_session_id;
    }
 
 
    /**
     * 开启Session
     * @return void
     */
    public function start() {
        $this->_init();
        $this->_started      = true;
    }
 
 
    /**
     * 初始session
     * @return void
     */
    protected function _init() {
        $this->_session_id   = md5(uniqid());
    }
 
 
    /**
     * 通过name查看Session是否存在
     * @param  string $name
     * @return boolean
     */
    public function has($name) {
        return isset($this->_session[$name]);
    }
 
 
    /**
     * 通过name从Session中获取一个值
     * @param  string $name 为空时返回整个sessino
     * @return mixed
     */
    public function get($name='') {
        if ( ! $name )
            return $this->_session;
 
        return isset($this->_session[$name]) ? $this->_session[$name] : null;
    }
 
 
    /**
     * 给指定的name设置一个session值，返回连缀对象
     * @param  string $name
     * @param  mixed  $value
     * @return object
     */
    public function set($name, $value) {
        $this->_session[$name] = $value;
        return $this;
    }
 
 
    /**
     * 从session中删除一个值，失败返回false，成功返回连缀对象
     * @param  string $name
     * @return false|object
     */
    public function del($name) {
        if ( ! $this->has($name) ) return false;
 
        unset($this->_session[$name]);
        return $this;
    }

    public function destroy() {
        $this->_session = [];
    }
}


/**
 * Http模式下管理$_SESSION类
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-23
 * @copyright http://www.crackedzone.com
 */
class Session_Http implements Session_Interface  {
 
    protected static $_instance = null;
 
    /**
     * session是否已经开启
     * @var boolean
     */
    protected $_started = false;
 
    /**
     * 单例模式禁止Clone
     */
    private function __clone() {}
 
    /**
     * 单例模式禁止外部初始化
     */
    private function __construct() {}
 
    /**
     * 返回单例模式
     */
    public static function getInstance() {
        if ( ! is_null( self::$_instance ) ) {
            return self::$_instance;
        }
 
        $instance = new self();
        $instance->start();
        self::$_instance = $instance;
        return $instance;
    }
 
 
    /**
     * 开启Session
     * @return void
     */
    public function start() {
        session_start();
        $this->_started      = true;
    }
 
 
    /**
     * 通过name查看Session是否存在
     * @param  string $name
     * @return boolean
     */
    public function has($name) {
        return isset($_SESSION[$name]);
    }
 
 
    /**
     * 通过name从Session中获取一个值
     * @param  string $name 为空时返回整个sessino
     * @return mixed
     */
    public function get($name='') {
        if ( ! $name )
            return $_SESSION;
 
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }
 
 
    /**
     * 给指定的name设置一个session值，返回连缀对象
     * @param  string $name
     * @param  mixed  $value
     * @return object
     */
    public function set($name, $value) {
        $_SESSION[$name] = $value;
        return $this;
    }
 
 
    /**
     * 从session中删除一个值，失败返回false，成功返回连缀对象
     * @param  string $name
     * @return false|object
     */
    public function del($name) {
        if ( ! $this->has($name) ) return false;
 
        unset($_SESSION[$name]);
        return $this;
    }

    public function destroy() {
        session_destroy();
    }
}


/**
 * Session接口
 * @author    Lancer He <lancer.he@gmail.com>
 * @since     2014-04-23
 * @copyright http://www.crackedzone.com
 */
interface Session_Interface {
    // 开启
    public function start();
    // 是否存在某个Session
    public function has($name);
    // 获取某个Session
    public function get($name='');
    // 给某个Session赋值
    public function set($name, $value);
    // 删除某个Session值
    public function del($name);
    // 清空Session
    public function destroy();
}