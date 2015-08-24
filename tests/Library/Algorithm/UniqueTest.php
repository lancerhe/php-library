<?php
/**
 * Algorithm_Unique Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-11-06
 */

namespace Library\Tests\Algorithm;

use Library\Algorithm\Unique;

class UniqueTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function guid() {
        $string = Unique::guid();
        $this->assertEquals('36', strlen($string));
    }
}