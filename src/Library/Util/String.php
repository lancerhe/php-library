<?php
/**
 * String
 *
 * @category Library
 * @package  Util
 * @author   Lancer <lancer.he@gmail.com>
 * @version  1.0 
 */

namespace Library\Util;

class String {

    /*
     * @brief 子字符串在字符串中，第N次出现的位置
     * @example:
     * String::bdstrpos('a-b-c-d-', '-', 2);  
     * '_'第2次在'a-b-c-d-'中出现的返回值为：4
     *
     * String::bdstrpos('a-b-c-d-', '-', 3);  
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
     * String::substring('abca/need/asdfas', '/');  
     * 返回 'need', 两个'/'之间的字符串
     *
     * String::substring('ab!before!need===', '!', '===')
     * 返回 'before!need'之间的字符串
     *
     * String::substring('ab!before!need===', '!', '===', 1)
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

    /*
     *
     * @brief 截取某个字符串前几位字符
     * @examle echo String::cutBefore('ab!before!need===', '===', 4); //返回 need
     */
    public static function cutBefore($string, $needle, $length){
        if ( $length === 0 ) 
            return false;
        $pos = strpos($string, $needle);
        if ( $pos === 0 )
            return '';
        $before = substr($string, 0, $pos);
        return substr($before, -$length);
    }

    /**
     * @brief 按$length指定的实际页面宽度，来截取字符串, 支持gbk, utf8, 需要在配置里设置页面字符集
     *
     * @param [in] string $string   the string to cut
     * @param [in] int $length      the length want to cut
     * @param [in] string $dot      suffix symbols 
     * @return cutted string 
     *
     */
    public static function cutString($string, $length, $dot = ' ...', $charset = 'gbk') {
        if(strlen($string) <= $length)
            return $string;

        $pre = '{%';
        $end = '%}';
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);

        $strcut = '';
        if(strtolower($charset) == 'utf-8') {

            $n = $tn = $noc = 0;
            while($n < strlen($string)) {

                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1; $n++; $noc++;
                } elseif(194 <= $t && $t <= 223) {
                    $tn = 2; $n += 2; $noc += 2;
                } elseif(224 <= $t && $t <= 239) {
                    $tn = 3; $n += 3; $noc += 2;
                } elseif(240 <= $t && $t <= 247) {
                    $tn = 4; $n += 4; $noc += 2;
                } elseif(248 <= $t && $t <= 251) {
                    $tn = 5; $n += 5; $noc += 2;
                } elseif($t == 252 || $t == 253) {
                    $tn = 6; $n += 6; $noc += 2;
                } else {
                    $n++;
                }

                if($noc >= $length) 
                    break;
            }
            if($noc > $length) 
                $n -= $tn;

            $strcut = substr($string, 0, $n);

        } else 
            for($i = 0; $i < $length; $i++)
                $strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];

        $strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
        return $strcut.$dot;
    }
}