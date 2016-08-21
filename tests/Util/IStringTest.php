<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\IString;

/**
 * Class StringTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class StringTest extends \PHPUnit_Framework_TestCase {
    /**
     * @return array
     */
    public static function provider_for_timeStrPoss() {
        return [
            ['a-b-c-d-', '-', 2, 4],
            ['a-b-c-d-', '-', 3, 6],
        ];
    }

    /**
     * @return array
     */
    public static function provider_for_substring() {
        return [
            ['abca//asdfas', '/', '', '', ''],
            ['abca/need/asdfas', '/', '', '', 'need'],
            ['ab!before!need===', '!', '===', '', 'before!need'],
            ['ab!before!need===', '!', '===', 1, 'need'],
            ['ab!before!我的家===', '!', '===', 1, '我的家'],
        ];
    }

    /**
     * @return array
     */
    public static function provider_for_cutBefore() {
        return [
            ['ab!before!need===', '===', 4, 'need'],
            ['abca/need/asdfas', '/', 4, 'abca'],
            ['ab!before!need===', 'ab', 4, ''],
            ['ab!before!need===', 'ab', 0, ''],
        ];
    }

    /**
     * @return array
     */
    public static function provider_for_cutString() {
        return [
            ['My name is lancer', 10, '...', 'utf-8', 'My name is...'],
            ['My name is lancer', 10, '...', 'gbk', 'My name is...'],
            ['My name is lancer', 17, '...', 'gbk', 'My name is lancer'],
            ['我的名字是lancer', 17, '...', 'gbk', '我的名字是la...'],
            ['我的名字是lancer', 9, '...', 'utf-8', '我的名字...'],
            ['我的名字是lancer', 8, '...', 'utf-8', '我的名字...'],
            ['我的名字是lancer', 7, '...', 'utf-8', '我的名...'],
            ['My Name is &amp; Lancer', 16, '...', 'utf-8', 'My Name is &amp;...'],
        ];
    }

    /**
     * @param $string
     * @param $subStr
     * @param $time
     * @param $expected_pos
     * @test
     * @dataProvider provider_for_timeStrPoss
     */
    public function timeStrPos($string, $subStr, $time, $expected_pos) {
        $pos = IString::timeStrPos($string, $subStr, $time);
        $this->assertEquals($expected_pos, $pos);
    }

    /**
     * @param $string
     * @param $begin
     * @param $end
     * @param $near_end
     * @param $expected
     * @test
     * @dataProvider provider_for_substring
     */
    public function substring($string, $begin, $end, $near_end, $expected) {
        $string = IString::substring($string, $begin, $end, $near_end);
        $this->assertEquals($expected, $string);
    }

    /**
     * @param $string
     * @param $needle
     * @param $length
     * @param $expected
     * @test
     * @dataProvider provider_for_cutBefore
     */
    public function cutBefore($string, $needle, $length, $expected) {
        $string = IString::cutBefore($string, $needle, $length);
        $this->assertEquals($expected, $string);
    }

    /**
     * @param $string
     * @param $length
     * @param $dot
     * @param $charset
     * @param $expected
     * @test
     * @dataProvider provider_for_cutString
     */
    public function cutString($string, $length, $dot, $charset, $expected) {
        $string = IString::cutString($string, $length, $dot, $charset);
        $this->assertEquals($expected, $string);
    }
}