<?php
/**
 * Util_String
 *
 * @category Util
 * @package  Util_String
 * @author   Lancer <lancer.he@gmail.com>
 * @version  1.0 
 */
class Util_String {

    /*
     * @brief 子字符串在字符串中，第N次出现的位置
     * @example:
     * Util_String::bdstrpos('a-b-c-d-', '-', 2);  
     * '_'第2次在'a-b-c-d-'中出现的返回值为：4
     *
     * Util_String::bdstrpos('a-b-c-d-', '-', 3);  
     * '_'第3次在'a-b-c-d-'中出现的返回值为：6
     */
    public static function bdstrpos($string, $substr, $time = 1) {
        $len = strlen($substr);
        $return  = 0;
        for($i = 0; $i < $time; $i++){
            $pos = strpos($string, $substr) + $len;
            $string = substr($string, $pos);
            $return += $pos;
        }
        return $return;
    }
}