<?php
use LancerHe\Library\Algorithm\Unique;

/**
 * Class UniqueTest
 *
 * @author Lancer He <lancer.he@gmail.com>
 */
class UniqueTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function guid() {
        $string = Unique::guid();
        $this->assertEquals('36', strlen($string));
    }
}