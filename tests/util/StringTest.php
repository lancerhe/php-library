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

    /**
     * @test
     * @dataProvider providerForbdstrpos
     */
    public function bdstrpos($string, $substr, $time, $expected_pos) {
        $pos = Util_String::bdstrpos($string, $substr, $time);
        $this->assertEquals($expected_pos, $pos);
    }
}