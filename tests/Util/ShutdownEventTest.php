<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\ShutdownEvent;

/**
 * Class ShutdownEventCalledInTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class ShutdownEventCalledInTest {
    /**
     * @param $message
     */
    public static function trace($message) {
        file_put_contents('/tmp/phpunit', $message);
    }
}

/**
 * Class ShutdownEventTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class ShutdownEventTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function addEvent() {
        $ShutdownEvent = new ShutdownEvent();
        $ShutdownEvent->add(
            ['LancerHe\Library\Tests\Util\ShutdownEventCalledInTest', 'trace'],
            'response trace testing on shutdown.'
        );
    }

    /**
     * @test
     */
    public function add_event_with_error() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $ShutdownEvent = new ShutdownEvent();
        $ShutdownEvent->add();
    }

    /**
     * @test
     */
    public function add_event_with_unable_class_error() {
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
        $this->assertEquals('response trace testing on shutdown.', file_get_contents('/tmp/phpunit'));
        unlink('/tmp/phpunit');
    }
}