<?php
/**
 * Util_Validate Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */
require dirname(__FILE__) . '/../../libraries/util/Validate.php';

class Util_ValidateTest extends PHPUnit_Framework_TestCase {
    
    public static function providerEmail() {
        return array(
            array(true,  'lancer.he@gmail.com'),
            array(false, 'lancer.he#gmail.com'),
            array(true,  'lisa.yang@asiainnovations.com'),
        );
    }

    /**
     * @test
     * @dataProvider providerEmail
     */
    public function validateEmailAddr($expected, $string) {
        $this->assertEquals($expected, Util_Validate::isEmailAddr($string));
    }

    public static function providerHttpUrl() {
        return array(
            array(true,  'http://www.baidu.com'),
            array(true,  'https://www.google.com/?gws_rd=ssl#newwindow=1&q=svn+merge+branch+to+another'),
            array(false, 'ftp://www.baidu.com'),
            array(false, 'git:///192.168.2.1/php-libary/trunk'),
        );
    }

    /**
     * @test
     * @dataProvider providerHttpUrl
     */
    public function validateHttpUrl($expected, $string) {
        $this->assertEquals($expected, Util_Validate::isHttpUrl($string) );
    }

    public static function providerEmptyString() {
        return array(
            array(true,  ''),
            array(true,  '   '),
            array(false, 'not empty'),
        );
    }

    /**
     * @test
     * @dataProvider providerEmptyString
     */
    public function validateEmptyString($expected, $string) {
        $this->assertEquals($expected, Util_Validate::isEmptyString($string) );
    }

    public static function providerNumber() {
        return array(
            array(true,  '478493922'),
            array(true,  '0033993232'),
            array(false, 'e222323223'),
        );
    }

    /**
     * @test
     * @dataProvider providerNumber
     */
    public function validateNumber($expected, $string) {
        $this->assertEquals($expected, Util_Validate::isNumber($string) );
    }

    public static function providerLengthBetween() {
        return array(
            array(true,  'Nickname', 4, 9),
            array(false, 'Nickname', 1, 6),
            array(true,  '白富美', 3, 3, 'utf-8'),
            array(true,  '白富美#2', 5, 5, 'utf-8'),
            array(false, '白富美', 4, 6, 'utf-8'),
            array(true,  '白富美', 1, 6, 'gb2312'),
            array(true,  '91无线_百度手机助手_IOS_fhdlfhdlfhldhfldffdfshfslhflslfslfhslhflshflshhflkdshfkldsfkhkdfkdfkdhfkdjfkdjfkdjfk', 1, 100, 'utf-8'),
            array(true,  '91无线_百度手机助手_IOS_酷玩汇~@#￥%……&*（）——=+-【】{】、|；‘：“，。《》？91无91无线_百度手机助手_IOS_酷玩汇~@#￥%……&*（）——=+-【】{】、|；‘：“，。', 1, 100, 'utf-8'),
        );
    }

    /**
     * @test
     * @dataProvider providerLengthBetween
     */
    public function validateLengthBetween($expected, $string, $min, $max, $charset='utf-8') {
        $this->assertEquals($expected, Util_Validate::isLengthBetween($string, $min, $max, $charset) );
    }

    public static function providerValueBetween() {
        return array(
            array(true,  5, 4, 9),
            array(false, 7, 1, 6),
        );
    }

    /**
     * @test
     * @dataProvider providerValueBetween
     */
    public function validateValueBetween($expected, $number, $min, $max) {
        $this->assertEquals($expected, Util_Validate::isValueBetween($number, $min, $max) );
    }


    public function providerUsername() {
        return array(
            array(true,  'sd6192709', 4, 16),
            array(false, 'sd6', 4, 16 ),
        );
    }


    /**
     * @test
     * @dataProvider providerUsername
     */
    public function validateUsername($expected, $string, $min, $max) {
        $this->assertEquals($expected, Util_Validate::isUsername($string, $min, $max) );
    }


    public function providerPassword() {
        return array(
            array(true,  '1234567', 4, 16),
            array(false, '装个虚拟机', 4, 16),
        );
    }


    /**
     * @test
     * @dataProvider providerPassword
     */
    public function validatePassword($expected, $string, $min, $max) {
        $this->assertEquals($expected, Util_Validate::isPassword($string, $min, $max) );
    }


    public function providerSame() {
        return array(
            array(true,  '1234567',  '1234567'),
            array(false, '装个虚拟机', '装个虚拟'),
            array(false, '    ', '  '),
            array(true,  '    ',  '    '),
        );
    }


    /**
     * @test
     * @dataProvider providerSame
     */
    public function validateSame($expected, $string_1, $string_2) {
        $this->assertEquals($expected, Util_Validate::isSame($string_1, $string_2) );
    }


    public function providerMobile() {
        return array(
            array(true,  '15960720246'),
            array(false, '12960720246'),
        );
    }


    /**
     * @test
     * @dataProvider providerMobile
     */
    public function validateMobile($expected, $string) {
        $this->assertEquals($expected, Util_Validate::isMobile($string) );
    }
}