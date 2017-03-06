<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\Sequence;

/**
 * Class SequenceTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class SequenceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function restore() {
        $ret = (new Sequence(1))->restore(512513241288541193);
        $this->assertEquals(1488770715035, $ret['time']);
        $this->assertEquals(1, $ret['node']);
        $this->assertEquals(9, $ret['count']);
    }
}
