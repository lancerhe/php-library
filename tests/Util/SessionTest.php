<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\Session;

/**
 * Class SessionTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class SessionTest extends \PHPUnit_Framework_TestCase {
    /**
     *
     */
    public function setUp() {
        parent::setUp();
        Session::getInstance()->destroy();
    }

    /**
     * @test
     */
    public function get_and_set() {
        Session::getInstance()->set('ace', 'value');
        $this->assertEquals('value', Session::getInstance()->get('ace'));
        $this->assertEquals(32, strlen(Session::getInstance()->getSessionId()));
    }

    /**
     * @test
     */
    public function has() {
        Session::getInstance()->set('ace', 'mytip');
        $this->assertEquals(true, Session::getInstance()->has('ace'));
        $this->assertEquals(false, Session::getInstance()->has('act'));
    }

    /**
     * @test
     */
    public function del() {
        Session::getInstance()->set('ace', 'mytip');
        Session::getInstance()->set('act', 'mytip');
        Session::getInstance()->del('ace');
        $this->assertEquals(false, Session::getInstance()->has('ace'));
        $this->assertEquals(true, Session::getInstance()->has('act'));
    }

    /**
     *
     */
    public function tearDown() {
        parent::tearDown();
        Session::getInstance()->destroy();
    }
}