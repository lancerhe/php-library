<?php
/**
 * Util_Cookie Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-02-12
 */
require_once dirname(__FILE__) . '/../../libraries/util/Cookie.php';

class Util_CookieTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        parent::setUp();
        Util_Cookie::$data = [];
    }

    /**
     * @test
     */
    public function get() {
        Util_Cookie::$data['ace'] = 2;
        $this->assertEquals(2, Util_Cookie::get('ace'));
    }

    /**
     * @test
     */
    public function set() {
        Util_Cookie::set('ace', 'mytip');
        $this->assertEquals('mytip', Util_Cookie::$data['ace']);
    }

    /**
     * @test
     */
    public function has() {
        Util_Cookie::set('ace', 'mytip');
        $this->assertEquals(true, Util_Cookie::has('ace'));
        $this->assertEquals(false, Util_Cookie::has('act'));
    }

    /**
     * @test
     */
    public function del() {
        Util_Cookie::set('ace', 'mytip');
        Util_Cookie::set('act', 'mytip');
        Util_Cookie::del('ace');
        $this->assertEquals(false, Util_Cookie::has('ace'));
        $this->assertEquals(true , Util_Cookie::has('act'));
    }
}