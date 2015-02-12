<?php
/**
 * Util_Cookie Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-02-12
 */
require_once dirname(__FILE__) . '/../../libraries/util/Session.php';

class Util_SessionTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
        Util_Session::getInstance()->destroy();
    }

    /**
     * @test
     */
    public function getAndSet() {
        Util_Session::getInstance()->set('ace', 'value');
        $this->assertEquals('value', Util_Session::getInstance()->get('ace'));
        $this->assertEquals(32, strlen(Util_Session::getInstance()->getSessionId()));
    }

    /**
     * @test
     */
    public function has() {
        Util_Session::getInstance()->set('ace', 'mytip');
        $this->assertEquals(true, Util_Session::getInstance()->has('ace'));
        $this->assertEquals(false, Util_Session::getInstance()->has('act'));
    }

    /**
     * @test
     */
    public function del() {
        Util_Session::getInstance()->set('ace', 'mytip');
        Util_Session::getInstance()->set('act', 'mytip');
        Util_Session::getInstance()->del('ace');
        $this->assertEquals(false, Util_Session::getInstance()->has('ace'));
        $this->assertEquals(true , Util_Session::getInstance()->has('act'));
    }

    public function tearDown() {
        parent::tearDown();
        Util_Session::getInstance()->destroy();
    }
}