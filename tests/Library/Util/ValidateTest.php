<?php
/**
 * Validate Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-04-15
 */

namespace Library\Tests\Util;

use Library\Util\Validate;

class ValidateTest extends \PHPUnit_Framework_TestCase {
    
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
        $this->assertEquals($expected, Validate::isEmailAddr($string));
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
        $this->assertEquals($expected, Validate::isHttpUrl($string) );
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
        $this->assertEquals($expected, Validate::isEmptyString($string) );
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
        $this->assertEquals($expected, Validate::isNumber($string) );
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
        $this->assertEquals($expected, Validate::isLengthBetween($string, $min, $max, $charset) );
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
        $this->assertEquals($expected, Validate::isValueBetween($number, $min, $max) );
    }


    public static function providerUsername() {
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
        $this->assertEquals($expected, Validate::isUsername($string, $min, $max) );
    }


    public static function providerPassword() {
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
        $this->assertEquals($expected, Validate::isPassword($string, $min, $max) );
    }


    public static function providerSame() {
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
        $this->assertEquals($expected, Validate::isSame($string_1, $string_2) );
    }


    public static function providerMobile() {
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
        $this->assertEquals($expected, Validate::isMobile($string) );
    }

    public static function providerNickname() {
        return array(
            array(true, 'LancerHe'),
            array(true, '风花雪月'),
            array(false,'Lancer He'),
        );
    }

    /**
     * @test
     * @dataProvider  providerNickname
     */
    public function validateNickname($expected, $string) {
        $this->assertEquals($expected, Validate::isNickname($string));
    }

    public static function providerChinese() {
        return array(
            array(true,  '风花雪月'),
            array(false, 'MyName'),
            array(false, '由此开始Tiny'),
        );
    }

    /**
     * @test
     * @dataProvider providerChinese
     */
    public function validateChinese($expected, $string) {
        $this->assertEquals($expected, Validate::isChinese($string));
    }

    public static function providerContainsChinese() {
        return array(
            array(true,  '风花雪月'),
            array(false, 'MyName'),
            array(true,  '由此开始Tiny'),
        );
    }

    /**
     * @test
     * @dataProvider providerContainsChinese
     */
    public function validateContainsChinese($expected, $string) {
        $this->assertEquals($expected, Validate::isContainsChinese($string));
    }

    public static function providerIpAddr() {
        return array(
            array(true, '217.0.0.1'),
            array(true, '192.168.1.1'),
            array(false,'262.0.0.1'),
        );
    }

    /**
     * @test
     * @dataProvider providerIpAddr
     */
    public function validateIpAddr($expected, $string) {
        $this->assertEquals($expected, Validate::isIpAddr($string));
    }

    public static function providerPrivateIpAddr() {
        return array(
            array(true, '10.1.0.1'),
            array(true, '172.16.2.4'),
            array(true, '172.31.1.5'),
            array(true, '192.168.1.5'),
            array(false, '11.1.0.1'),
            array(false, '172.15.2.4'),
            array(false, '172.32.1.5'),
            array(false, '192.167.1.5'),
        );
    }

    /**
     * @test
     * @dataProvider providerPrivateIpAddr
     */
    public function validatePrivateIpAddr($expected, $string) {
        $this->assertEquals($expected, Validate::isPrivateIpAddr($string));
    }

    public static function providerIdCard() {
        return array(
            array(false,'3501128702121222322'),
            array(false,'350104198625141254'),
            array(true, '350112198702123343'),
            array(false,'35011287021232x'),
            array(true ,'350112870212132'),
        );
    }

    /**
     * @test
     * @dataProvider providerIdCard
     */
    public function validateIdCard($expected, $string) {
        $this->assertEquals($expected, Validate::isIdCard($string));
    }
}