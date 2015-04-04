<?php
/**
 * Sentinel client test.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-04-05
 */

require_once dirname(__FILE__) . '/../../../libraries/redis/sentinel/Client.php';
require_once dirname(__FILE__) . '/../../../libraries/redis/sentinel/ConnectionTcpExecption.php';

class Redis_Sentinel_ClientTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function connectFailure() {
        $this->setExpectedException('Redis_Sentinel_ConnectionTcpExecption');
        $sentinel_client = new Redis_Sentinel_Client("127.0.0.1", 26379);
        $sentinel_client->masters();
    }
}