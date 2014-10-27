<?php
/**
 * Util_Client Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-27
 */
require dirname(__FILE__) . '/../../libraries/util/Client.php';

class Util_ClientTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getIpUnknow() {
        $this->assertEquals('unknown', Util_Client::getIp());
    }

    /**
     * @test
     */
    public function getIpWith_HTTP_CLIENT_IP() {
        putenv("HTTP_CLIENT_IP=192.168.236.61");
        $this->assertEquals('192.168.236.61', Util_Client::getIp());
    }

    /**
     * @test
     */
    public function getIpWith_HTTP_X_FORWARDED_FOR() {
        putenv("HTTP_X_FORWARDED_FOR=192.168.236.61");
        $this->assertEquals('192.168.236.61', Util_Client::getIp());
    }

    /**
     * @test
     */
    public function getIpWith_REMOTE_ADDR() {
        putenv("REMOTE_ADDR=192.168.236.61");
        $this->assertEquals('192.168.236.61', Util_Client::getIp());
    }

    /**
     * @test
     */
    public function getIpWith_SERVER_REMOTE_ADDR() {
        $_SERVER['REMOTE_ADDR'] = '192.168.236.61';
        $this->assertEquals('192.168.236.61', Util_Client::getIp());
    }

    public function tearDown() {
        parent::tearDown();
        putenv('HTTP_CLIENT_IP');
        putenv('HTTP_X_FORWARDED_FOR');
        putenv('REMOTE_ADDR');
    }
}