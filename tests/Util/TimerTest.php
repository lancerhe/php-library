<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\Timer;

/**
 * Class TimerTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class TimerTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function diff() {
        Timer::start('init');
        usleep(2000); //sleep 0.002
        $diff = Timer::stop('init');
        $this->assertGreaterThan(0.002, $diff);
    }
}