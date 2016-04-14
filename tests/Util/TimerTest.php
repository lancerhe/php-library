<?php
/**
 * Timer Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-01-24
 */

namespace Library\Tests\Util;

use Library\Util\Timer;

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