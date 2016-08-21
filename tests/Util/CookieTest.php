<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\Cookie;

/**
 * Class CookieTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class CookieTest extends \PHPUnit_Framework_TestCase {
    public function setUp() {
        parent::setUp();
        Cookie::$data = [];
    }

    /**
     * @test
     */
    public function get() {
        Cookie::$data['ace'] = 2;
        $this->assertEquals(2, Cookie::get('ace'));
    }

    /**
     * @test
     */
    public function set() {
        Cookie::set('ace', 'mytip');
        $this->assertEquals('mytip', Cookie::$data['ace']);
    }

    /**
     * @test
     */
    public function has() {
        Cookie::set('ace', 'mytip');
        $this->assertEquals(true, Cookie::has('ace'));
        $this->assertEquals(false, Cookie::has('act'));
    }

    /**
     * @test
     */
    public function del() {
        Cookie::set('ace', 'mytip');
        Cookie::set('act', 'mytip');
        Cookie::del('ace');
        $this->assertEquals(false, Cookie::has('ace'));
        $this->assertEquals(true, Cookie::has('act'));
    }
}