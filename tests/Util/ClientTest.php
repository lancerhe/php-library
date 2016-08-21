<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\Client;

/**
 * Class ClientTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class ClientTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function getIp_Unknow() {
        $this->assertEquals('unknown', Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_EVN_HTTP_CLIENT_IP() {
        putenv("HTTP_CLIENT_IP=192.168.236.61");
        $this->assertEquals('192.168.236.61', Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_EVN_HTTP_X_FORWARDED_FOR() {
        putenv("HTTP_X_FORWARDED_FOR=56.167.1.23");
        $this->assertEquals('56.167.1.23', Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_EVN_HTTP_X_FORWARDED_FOR_SIGNLE() {
        putenv("HTTP_X_FORWARDED_FOR=192.168.236.61, 56.167.1.23");
        $this->assertEquals('56.167.1.23', Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_EVN_HTTP_X_FORWARDED_FOR_SIGNLE_NOT_FOUND() {
        putenv("HTTP_X_FORWARDED_FOR=192.168.236.61, 10.12.23.33");
        $this->assertEquals('unknown', Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_EVN_HTTP_X_FORWARDED_FOR_MUTIL() {
        putenv("HTTP_X_FORWARDED_FOR=192.168.236.61, 192.168.1.23");
        $this->assertEquals('192.168.236.61, 192.168.1.23', Client::getIp(false));
    }

    /**
     * @test
     */
    public function getIp_EVN_REMOTE_ADDR() {
        putenv("REMOTE_ADDR=192.168.236.61");
        $this->assertEquals('192.168.236.61', Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_SERVER_REMOTE_ADDR() {
        $_SERVER['REMOTE_ADDR'] = '192.168.236.61';
        $this->assertEquals('192.168.236.61', Client::getIp());
    }

    public static function providerBrowser() {
        return [
            ['MSIE 7.0', 'Internet Explorer'],
            ['Firefox 7.0', 'Mozilla Firefox'],
            ['Safari 7.0', 'Apple Safari'],
            ['Chrome 7.0', 'Google Chrome'],
            ['Flock 7.0', 'Flock'],
            ['Opera 7.0', 'Opera'],
            ['Netscape 7.0', 'Netscape'],
            ['MyBrowser 7.0', 'unknown'],
            [null, 'unknown'],
        ];
    }

    /**
     * @test
     * @dataProvider providerBrowser
     */
    public function getBrowser($user_agent, $expected_browser) {
        $_SERVER['HTTP_USER_AGENT'] = $user_agent;
        $this->assertEquals($expected_browser, Client::getBrowser());
    }

    public function tearDown() {
        parent::tearDown();
        putenv('HTTP_CLIENT_IP');
        putenv('HTTP_X_FORWARDED_FOR');
        putenv('REMOTE_ADDR');
    }
}