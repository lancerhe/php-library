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
    public function getIp_Unknow() {
        $this->assertEquals('unknown', Util_Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_EVN_HTTP_CLIENT_IP() {
        putenv("HTTP_CLIENT_IP=192.168.236.61");
        $this->assertEquals('192.168.236.61', Util_Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_EVN_HTTP_X_FORWARDED_FOR() {
        putenv("HTTP_X_FORWARDED_FOR=192.168.236.61");
        $this->assertEquals('192.168.236.61', Util_Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_EVN_REMOTE_ADDR() {
        putenv("REMOTE_ADDR=192.168.236.61");
        $this->assertEquals('192.168.236.61', Util_Client::getIp());
    }

    /**
     * @test
     */
    public function getIp_SERVER_REMOTE_ADDR() {
        $_SERVER['REMOTE_ADDR'] = '192.168.236.61';
        $this->assertEquals('192.168.236.61', Util_Client::getIp());
    }

    public static function providerBrowser(){
        return array(
            array('MSIE 7.0',    'Internet Explorer'),
            array('Firefox 7.0', 'Mozilla Firefox'),
            array('Safari 7.0',  'Apple Safari'),
            array('Chrome 7.0',  'Google Chrome'),
            array('Flock 7.0',   'Flock'),
            array('Opera 7.0',   'Opera'),
            array('Netscape 7.0', 'Netscape'),
            array('MyBrowser 7.0', 'unknown'),
            array(null,            'unknown'),
        );
    }

    /**
     * @test
     * @dataProvider providerBrowser
     */
    public function getBrowser($user_agent, $expected_browser) {
        $_SERVER['HTTP_USER_AGENT'] = $user_agent;
        $this->assertEquals($expected_browser, Util_Client::getBrowser());
    }

    public function tearDown() {
        parent::tearDown();
        putenv('HTTP_CLIENT_IP');
        putenv('HTTP_X_FORWARDED_FOR');
        putenv('REMOTE_ADDR');
    }
}