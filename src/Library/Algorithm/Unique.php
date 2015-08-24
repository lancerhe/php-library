<?php
/**
* 唯一算法 
*
* @category Library
* @package  Algorithm
* @author   Lancer He <lancer.he@gmail.com>
* @version  1.0 
*/

namespace Library\Algorithm;

class Unique {

    /**
     * 返回全局唯一标识符GUID
     * @access public
     * @static
     *
     * @return string
     */   
    public static function guid(){
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12);
        return $uuid;
    }
}