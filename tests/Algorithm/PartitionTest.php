<?php
namespace LancerHe\Library\Tests\Algorithm;

use LancerHe\Library\Algorithm\Partition;

/**
 * Class PartitionTest
 *
 * @package LancerHe\Library\Tests\Algorithm
 * @author  Lancer He <lancer.he@gmail.com>
 */
class PartitionTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function trigger_error_while_type_in_error_num_15_on_method_getIndexById() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        Partition::getIndexById(4, 15);
    }

    /**
     * @test
     */
    public function id_4_should_be_return_partition_8_on_method_getIndexById_while_num_is_8() {
        $this->assertEquals('8', Partition::getIndexById(4, 10));
    }

    /**
     * @test
     */
    public function id_4_should_be_return_partition_S_on_method_getIndexById_while_num_is_36() {
        $this->assertEquals('S', Partition::getIndexById(4, 36));
    }

    /**
     * @desc provider for trigger_error_while_type_in_error_figure_on_method_getIndexByFigure.
     */
    public function error_figure() {
        return [
            ["1001"], ["0"], ["-2"],
        ];
    }

    /**
     * @test
     * @dataProvider error_figure
     */
    public function trigger_error_while_type_in_error_figure_on_method_getIndexByFigure($figure) {
        $this->setExpectedException('PHPUnit_Framework_Error');
        Partition::getIndexByFigure(4, $figure);
    }

    /**
     * @desc provider for assert_from_provider_getIndexByFigures.
     */
    public function assert_figure() {
        return [
            ["0", "234", "1000"],
            ["0", "999", "1000"],
            ["1", "1000", "1000"],
            ["101", "101000", "1000"],
        ];
    }

    /**
     * @test
     * @dataProvider assert_figure
     */
    public function assert_from_provider_getIndexByFigure($expected, $id, $figure) {
        $this->assertEquals($expected, Partition::getIndexByFigure($id, $figure));
    }
}