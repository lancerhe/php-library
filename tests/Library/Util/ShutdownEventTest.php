<?php
/**
 * Util_Array Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-27
 */

namespace Library\Tests\Util;

use Library\Util\ShutdownEvent;

class ShutdownEventCalledInTest {

    public static function trace($message) {
        file_put_contents('/tmp/shutdownwrite', $message);
    }
}

class ShutdownEventTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        exec("rm -f /tmp/shutdownwrite");
    }

    /**
     * @test
     */
    public function addEvent() {
        $ShutdownEvent = new ShutdownEvent();
        $ShutdownEvent->add(
            array('Library\Tests\Util\ShutdownEventCalledInTest', 'trace'),
            'response trace testing on shutdown.'
        );
    }

    /**
     * @test
     */
    public function addEventWithError() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $ShutdownEvent = new ShutdownEvent();
        $ShutdownEvent->add();
    }

    /**
     * @test
     */
    public function addEventWithUnableClassError() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $ShutdownEvent = new ShutdownEvent();
        $ShutdownEvent->add('TestTest');
    }

    /**
     * @test
     */
    public function call() {
        $ShutdownEvent = new ShutdownEvent();
        $ShutdownEvent->call();
        $this->assertEquals('response trace testing on shutdown.', file_get_contents('/tmp/shutdownwrite') );
    }
}