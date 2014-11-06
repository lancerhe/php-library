<?php
/**
 * Algorithm_Unique Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-11-06
 */
require_once dirname(__FILE__) . '/../../libraries/algorithm/Unique.php';

class Algorithm_UniqueTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function guid() {
        $string = Algorithm_Unique::guid();
        $this->assertEquals('36', strlen($string));
    }
}