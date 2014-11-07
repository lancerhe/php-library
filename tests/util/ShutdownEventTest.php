<?php
/**
 * Util_Array Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-27
 */
require_once dirname(__FILE__) . '/../../libraries/util/ShutdownEvent.php';

class Util_ShutdownEventTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        exec("rm -f /tmp/wwwlogs/shutdownwrite");
    }

    /**
     * @test
     */
    public function addEvent() {
        $ShutdownEvent = new Util_ShutdownEvent();
        $ShutdownEvent->add(
            array('TestUtil_ShutdownEvent', 'trace'),
            'response trace testing on shutdown.'
        );
    }

    /**
     * @test
     */
    public function addEventWithError() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $ShutdownEvent = new Util_ShutdownEvent();
        $ShutdownEvent->add();
    }

    /**
     * @test
     */
    public function addEventWithUnableClassError() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $ShutdownEvent = new Util_ShutdownEvent();
        $ShutdownEvent->add('TestTest');
    }

    /**
     * @test
     */
    public function call() {
        $ShutdownEvent = new Util_ShutdownEvent();
        $ShutdownEvent->call();
        $this->assertEquals('response trace testing on shutdown.', file_get_contents('/tmp/wwwlogs/shutdownwrite') );
    }
}

class TestUtil_ShutdownEvent {

    public static function trace($message) {
        file_put_contents('/tmp/wwwlogs/shutdownwrite', $message);
    }
}