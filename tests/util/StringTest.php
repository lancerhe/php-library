<?php
/**
 * Util_Log Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-06-04
 */
require_once dirname(__FILE__) . '/../../libraries/util/String.php';

class Util_StringTest extends PHPUnit_Framework_TestCase {

    public static function providerForbdstrpos() {
        return [
            ['a-b-c-d-', '-', 2, 4],
            ['a-b-c-d-', '-', 3, 6],
        ];
    }

    public static function providerForsubstring() {
        return [
            ['abca//asdfas',        '/',  '',    '', ''],
            ['abca/need/asdfas',    '/',  '',    '', 'need'],
            ['ab!before!need===',   '!', '===',  '', 'before!need'],
            ['ab!before!need===',   '!', '===',  1, 'need'],
            ['ab!before!我的家===', '!', '===',   1, '我的家'],
        ];
    }

    public static function providerForcutBefore() {
        return [
            ['ab!before!need===',  '===',  4, 'need'],
            ['abca/need/asdfas',    '/',   4, 'abca'],
            ['ab!before!need===',   'ab',  4, ''],
            ['ab!before!need===',   'ab',  0, ''],
        ];
    }

    /**
     * @test
     * @dataProvider providerForbdstrpos
     */
    public function bdstrpos($string, $substr, $time, $expected_pos) {
        $pos = Util_String::bdstrpos($string, $substr, $time);
        $this->assertEquals($expected_pos, $pos);
    }

    /**
     * @test
     * @dataProvider providerForsubstring
     */
    public function substring($string, $begin, $end, $near_end, $expected) {
        $string = Util_String::substring($string, $begin, $end, $near_end);
        $this->assertEquals($expected, $string);
    }

    /**
     * @test
     * @dataProvider providerForcutBefore
     */
    public function cutBefore($string, $needle, $length, $expected) {
        $string = Util_String::cutBefore($string, $needle, $length);
        $this->assertEquals($expected, $string);
    }
}