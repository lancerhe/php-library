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

    /*
     *
     * @brief 截取两个子字符串之间的字符串
     *
     * @example:
     * Util_String::substring('abca/need/asdfas', '/');  
     * 返回 'need', 两个'/'之间的字符串
     *
     * Util_String::substring('ab!before!need===', '!', '===')
     * 返回 'before!need'之间的字符串
     *
     * Util_String::substring('ab!before!need===', '!', '===', 1)
     * 返回 'need',  === 之前最近一个!号间的字
     */
    public static function substring($string, $begin, $end = '', $near_end = 0){
        if($near_end){
            $before = substr($string, 0, strpos($string, $end));
            $beginPos = strrpos($before, $begin) + strlen($begin);
            return substr($before, $beginPos);
        } else {
            $start = strpos($string, $begin);
            $after = substr($string, $start + strlen($begin));
            $stop = $end ? strpos($after, $end) : strpos($after, $begin);
            return substr($after, 0, $stop);
        }
    }
}