<?php
namespace LancerHe\Library\Util;

/**
 * Class Validate
 *
 * @package LancerHe\Library\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class Validate {
    /**
     * isEmailAddress 是否Email有效格式
     *
     * @access  public
     * @static
     * @param string $string 需要匹配的字符串
     * @return boolean
     * @example Validate::isEmailAddress( 'lancer.he@gmail.com' );
     */
    public static function isEmailAddress($string) {
        $regexp = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
        //$regexp = '/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$/';
        //$regexp = '/^[a-z0-9][a-z\.0-9-_]+@[a-z0-9_-]+(?:\.[a-z]{0,3}\.[a-z]{0,2}|\.[a-z]{0,3}|\.[a-z]{0,2})$/i';
        return preg_match($regexp, $string) ? true : false;
    }

    /**
     * isHttpUrl 是否Http url 格式
     *
     * @access  public
     * @static
     * @param string $string 需要匹配的字符串
     * @return boolean
     * @example Validate::isHttpUrl( 'http://www.baidu.com' );
     */
    public static function isHttpUrl($string) {
        $regexp = '/^http|https:\/\/[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$/';
        return preg_match($regexp, $string) ? true : false;
    }

    /**
     * isEmptyString 是否字符串为空
     *
     * @access  public
     * @static
     * @param string $string 需要匹配的字符串
     * @return boolean
     * @example Validate::isEmptyString( 'A' );
     */
    public static function isEmptyString($string) {
        if ( ! is_string($string) ) return false;
        $string = trim($string);
        return $string == '' ? true : false;
    }

    /**
     * isNumber 是否为数字
     *
     * @access  public
     * @static
     * @param  string $string 需要匹配的字符串或者数字
     * @return boolean
     * @example Validate::isNumber( '2131' );
     */
    public static function isNumber($string) {
        $regexp = '/^[0-9]*$/';
        return preg_match($regexp, $string) ? true : false;
    }

    /**
     * isLengthBetween 字符串长度判断是否在某个区间内
     *
     * @access  public
     * @static
     * @param string   $string 需要匹配的字符串
     * @param interger $min    最小长度
     * @param interger $max    最大长度
     * @return boolean
     * @example Validate::isLengthBetween( 'Nickname' );
     */
    public static function isLengthBetween($string, $min = 4, $max = 16, $charset = 'gb2312') {
        $string = trim($string);
        if ( ! in_array($charset, ['gb2312', 'utf-8']) ) return false;
        if ( $charset == 'gb2312' ) {
            $string = iconv("utf-8", "gbk", $string);
            $length = strlen($string);
        } else {
            $length = mb_strlen($string, $charset);
        }
        if ( $length < $min ) return false;
        if ( $length > $max ) return false;
        return true;
    }

    /**
     * isValueBetween 判断数值是否在某个区间内
     *
     * @access  public
     * @static
     * @param int $number 当前数值
     * @param int $min    最小值
     * @param int $max    最大值
     * @return boolean
     * @example Validate::isValueBetween( 97, 4 ,10);
     */
    public static function isValueBetween($number, $min, $max) {
        if ( $number > $max ) return false;
        if ( $number < $min ) return false;
        return true;
    }

    /**
     * isUsername 是否为用户名
     *
     * @access  public
     * @static
     * @param string $string 用户名字符串
     * @param int    $min    最小长度
     * @param int    $max    最大长度
     * @return boolean
     * @example Validate::isUsername( 'Lancer' );
     */
    public static function isUsername($string, $min = 4, $max = 16) {
        if ( ! self::IsLengthBetween($string, $min, $max) ) return false;
        $regexp = '/^[\x80-\xff_a-zA-Z0-9]/';
        return preg_match($regexp, $string) ? true : false;
    }

    /**
     * isPassword 是否为密码
     *
     * @access  public
     * @static
     * @param string $string 需要匹配的密码
     * @param int    $min    最小长度
     * @param int    $max    最大长度
     * @return boolean
     * @example Validate::isPassword( 'Lancer' );
     */
    public static function isPassword($string, $min = 4, $max = 16) {
        if ( ! self::isLengthBetween($string, $min, $max) ) return false;
        $regexp = '/^[_a-zA-Z0-9]*$/';
        return preg_match($regexp, $string) ? true : false;
    }

    /**
     * isSame 两个字符串是否一致
     *
     * @access  public
     * @static
     * @param string $original 字符串1
     * @param string $compare  字符串2
     * @return boolean
     * @example Validate::isSame( 'Lancer', 'Lancer2' );
     */
    public static function isSame($original, $compare) {
        return $original === $compare ? true : false;
    }

    /**
     * isMobile 是否为手机格式
     *
     * @access  public
     * @static
     * @param string $string 手机号码
     * @return boolean
     * @example Validate::isMobile( '15960720246' );
     */
    public static function isMobile($string) {
        $regexp = '/^(?:13|15|18)[0-9]{9}$/';
        return preg_match($regexp, $string) ? true : false;
    }

    /**
     * isNickname 是否为昵称格式
     *
     * @access  public
     * @static
     * @param string $string 昵称名称
     * @return boolean
     * @example Validate::isNickname( '风华正茂' );
     */
    public static function isNickname($string) {
        //Copy From DZ
        $regexp = '/^\s*$|^c:\\con\\con$|[%,\*\"\s\t\<\>\&\'\(\)]|\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8/is';
        return preg_match($regexp, $string) ? false : true;
    }

    /**
     * isChinese 是否为中文
     *
     * @access  public
     * @static
     * @param string $string
     * @param string $charset
     * @return boolean
     * @example Validate::isChinese( '风华正茂' );
     */
    public static function isChinese($string, $charset = 'utf8') {
        $regexp = $charset == 'utf8' ? '/^[\x{4e00}-\x{9fa5}]+$/u' : '/^([\x80-\xFF][\x80-\xFF])+$/';
        return preg_match($regexp, $string) ? true : false;
    }

    /**
     * isContainsChinese 是否包含中文
     *
     * @access  public
     * @static
     * @param string $string
     * @return boolean
     * @example Validate::isContainsChinese( '风华正茂' );
     */
    public static function isContainsChinese($string) {
        $regexp = '/([\x81-\xfe][\x40-\xfe])/';
        return preg_match($regexp, $string) ? true : false;
    }

    /**
     * isIpAddress 是否为IP地址
     *
     * @access  public
     * @static
     * @param string $ip
     * @return boolean
     * @example Validate::isIpAddress( '' );
     */
    public static function isIpAddress($ip) {
        $result = ip2long($ip);
        return ($result == - 1 || $result == false) ? false : true;
    }

    /**
     * isPrivateIpAddress 是否为内网IP地址
     *
     * @access  public
     * @static
     * @param string $ip
     * @return boolean
     * @example Validate::isPrivateIpAddress( '' );
     */
    public static function isPrivateIpAddress($ip) {
        return ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }

    /**
     * isIDCard 是否为身份证件号
     *
     * @access  public
     * @static
     * @param string $idCard
     * @return boolean
     * @example Validate::isIDCard( '350104198625141254' );
     */
    public static function isIDCard($idCard) {
        //identification card  18 bits
        if ( strlen($idCard) != 15 && strlen($idCard) != 18 ) {
            return false;
        }
        $regexp = '/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/';
        if ( preg_match($regexp, $idCard) ) {
            return true;
        }
        $regexp = '/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}(\d|x|X)$/';
        if ( preg_match($regexp, $idCard) ) {
            return true;
        }
        return false;
    }
}