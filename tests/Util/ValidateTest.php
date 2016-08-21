<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\Validate;

/**
 * Class ValidateTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class ValidateTest extends \PHPUnit_Framework_TestCase {
    /**
     * @return array
     */
    public static function providerEmailAddress() {
        return [
            [true, 'lancer.he@gmail.com'],
            [false, 'lancer.he#gmail.com'],
            [true, 'lisa.yang@asiainnovations.com'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerEmailAddress
     */
    public function validate_email_address($expected, $string) {
        $this->assertEquals($expected, Validate::isEmailAddress($string));
    }

    /**
     * @return array
     */
    public static function providerHttpUrl() {
        return [
            [true, 'http://www.baidu.com'],
            [true, 'https://www.google.com/?gws_rd=ssl#newwindow=1&q=svn+merge+branch+to+another'],
            [false, 'ftp://www.baidu.com'],
            [false, 'git:///192.168.2.1/php-libary/trunk'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerHttpUrl
     */
    public function validate_http_url($expected, $string) {
        $this->assertEquals($expected, Validate::isHttpUrl($string));
    }

    /**
     * @return array
     */
    public static function providerEmptyString() {
        return [
            [true, ''],
            [true, '   '],
            [false, 'not empty'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerEmptyString
     */
    public function validate_empty_string($expected, $string) {
        $this->assertEquals($expected, Validate::isEmptyString($string));
    }

    /**
     * @return array
     */
    public static function providerNumber() {
        return [
            [true, '478493922'],
            [true, '0033993232'],
            [false, 'e222323223'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerNumber
     */
    public function validate_number($expected, $string) {
        $this->assertEquals($expected, Validate::isNumber($string));
    }

    /**
     * @return array
     */
    public static function providerLengthBetween() {
        return [
            [true, 'Nickname', 4, 9],
            [false, 'Nickname', 1, 6],
            [true, '白富美', 3, 3, 'utf-8'],
            [true, '白富美#2', 5, 5, 'utf-8'],
            [false, '白富美', 4, 6, 'utf-8'],
            [true, '白富美', 1, 6, 'gb2312'],
            [true, '91无线_百度手机助手_IOS_fhdlfhdlfhldhfldffdfshfslhflslfslfhslhflshflshhflkdshfkldsfkhkdfkdfkdhfkdjfkdjfkdjfk', 1, 100, 'utf-8'],
            [true, '91无线_百度手机助手_IOS_酷玩汇~@#￥%……&*（）——=+-【】{】、|；‘：“，。《》？91无91无线_百度手机助手_IOS_酷玩汇~@#￥%……&*（）——=+-【】{】、|；‘：“，。', 1, 100, 'utf-8'],
        ];
    }

    /**
     * @param        $expected
     * @param        $string
     * @param        $min
     * @param        $max
     * @param string $charset
     * @test
     * @dataProvider providerLengthBetween
     */
    public function validate_length_between($expected, $string, $min, $max, $charset = 'utf-8') {
        $this->assertEquals($expected, Validate::isLengthBetween($string, $min, $max, $charset));
    }

    /**
     * @return array
     */
    public static function providerValueBetween() {
        return [
            [true, 5, 4, 9],
            [false, 7, 1, 6],
        ];
    }

    /**
     * @param $expected
     * @param $number
     * @param $min
     * @param $max
     * @test
     * @dataProvider providerValueBetween
     */
    public function validate_value_between($expected, $number, $min, $max) {
        $this->assertEquals($expected, Validate::isValueBetween($number, $min, $max));
    }

    /**
     * @return array
     */
    public static function providerUsername() {
        return [
            [true, 'sd6192709', 4, 16],
            [false, 'sd6', 4, 16],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @param $min
     * @param $max
     * @test
     * @dataProvider providerUsername
     */
    public function validate_username($expected, $string, $min, $max) {
        $this->assertEquals($expected, Validate::isUsername($string, $min, $max));
    }

    /**
     * @return array
     */
    public static function providerPassword() {
        return [
            [true, '1234567', 4, 16],
            [false, '装个虚拟机', 4, 16],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @param $min
     * @param $max
     * @test
     * @dataProvider providerPassword
     */
    public function validate_password($expected, $string, $min, $max) {
        $this->assertEquals($expected, Validate::isPassword($string, $min, $max));
    }

    /**
     * @return array
     */
    public static function providerSame() {
        return [
            [true, '1234567', '1234567'],
            [false, '装个虚拟机', '装个虚拟'],
            [false, '    ', '  '],
            [true, '    ', '    '],
        ];
    }

    /**
     * @param $expected
     * @param $string_1
     * @param $string_2
     * @test
     * @dataProvider providerSame
     */
    public function validate_same($expected, $string_1, $string_2) {
        $this->assertEquals($expected, Validate::isSame($string_1, $string_2));
    }

    /**
     * @return array
     */
    public static function providerMobile() {
        return [
            [true, '15960720246'],
            [false, '12960720246'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerMobile
     */
    public function validate_mobile($expected, $string) {
        $this->assertEquals($expected, Validate::isMobile($string));
    }

    /**
     * @return array
     */
    public static function providerNickname() {
        return [
            [true, 'LancerHe'],
            [true, '风花雪月'],
            [false, 'Lancer He'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider  providerNickname
     */
    public function validate_mickname($expected, $string) {
        $this->assertEquals($expected, Validate::isNickname($string));
    }

    /**
     * @return array
     */
    public static function providerChinese() {
        return [
            [true, '风花雪月'],
            [false, 'MyName'],
            [false, '由此开始Tiny'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerChinese
     */
    public function validate_chinese($expected, $string) {
        $this->assertEquals($expected, Validate::isChinese($string));
    }

    /**
     * @return array
     */
    public static function providerContainsChinese() {
        return [
            [true, '风花雪月'],
            [false, 'MyName'],
            [true, '由此开始Tiny'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerContainsChinese
     */
    public function validate_contains_chinese($expected, $string) {
        $this->assertEquals($expected, Validate::isContainsChinese($string));
    }

    /**
     * @return array
     */
    public static function providerIpAddress() {
        return [
            [true, '217.0.0.1'],
            [true, '192.168.1.1'],
            [false, '262.0.0.1'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerIpAddress
     */
    public function validate_ip_address($expected, $string) {
        $this->assertEquals($expected, Validate::isIpAddress($string));
    }

    /**
     * @return array
     */
    public static function providerPrivateIpAddress() {
        return [
            [true, '10.1.0.1'],
            [true, '172.16.2.4'],
            [true, '172.31.1.5'],
            [true, '192.168.1.5'],
            [false, '11.1.0.1'],
            [false, '172.15.2.4'],
            [false, '172.32.1.5'],
            [false, '192.167.1.5'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerPrivateIpAddress
     */
    public function validate_private_ip_address($expected, $string) {
        $this->assertEquals($expected, Validate::isPrivateIpAddress($string));
    }

    /**
     * @return array
     */
    public static function providerIdCard() {
        return [
            [false, '3501128702121222322'],
            [false, '350104198625141254'],
            [true, '350112198702123343'],
            [false, '35011287021232x'],
            [true, '350112870212132'],
        ];
    }

    /**
     * @param $expected
     * @param $string
     * @test
     * @dataProvider providerIdCard
     */
    public function validate_id_card($expected, $string) {
        $this->assertEquals($expected, Validate::isIdCard($string));
    }
}