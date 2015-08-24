<?php
/**
 * Algorithm_Partition Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-11-06
 */

namespace Library\Tests\Algorithm;

use Library\Algorithm\Partition;

class PartitionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getPartitionIndexWithError() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        Partition::getIndexById(4, 15);
    }

    /**
     * @test
     */
    public function getPartitionIndexWith10Num() {
        $index = Partition::getIndexById(4, 10);
        $this->assertEquals('8', $index);
    }

    /**
     * @test
     */
    public function getPartitionIndexWith36Num() {
        $index = Partition::getIndexById(4, 36);
        $this->assertEquals('S', $index);
    }
}