<?php
/**
 * Algorithm_Partition Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-11-06
 */
require_once dirname(__FILE__) . '/../../libraries/algorithm/Partition.php';

class Algorithm_PartitionTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getPartitionIndexWithError() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        Algorithm_Partition::getIndexById(4, 15);
    }

    /**
     * @test
     */
    public function getPartitionIndexWith10Num() {
        $index = Algorithm_Partition::getIndexById(4, 10);
        $this->assertEquals('8', $index);
    }

    /**
     * @test
     */
    public function getPartitionIndexWith36Num() {
        $index = Algorithm_Partition::getIndexById(4, 36);
        $this->assertEquals('S', $index);
    }
}