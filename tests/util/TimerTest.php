<?php
/**
 * Util_Timer Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-01-24
 */
require_once dirname(__FILE__) . '/../../libraries/util/Timer.php';

class Util_TimerTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function diff() {
        Util_Timer::start('init');
        usleep(2000); //sleep 0.002
        $diff = Util_Timer::stop('init');
        $this->assertGreaterThan(0.002, $diff);
    }
}