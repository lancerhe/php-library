<?php
/**
 * Sentinel test.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2015-04-05
 */


require_once dirname(__FILE__) . '/../../libraries/redis/Sentinel.php';
require_once dirname(__FILE__) . '/../../libraries/redis/sentinel/Client.php';
require_once dirname(__FILE__) . '/../../libraries/redis/sentinel/ConnectionTcpExecption.php';
require_once dirname(__FILE__) . '/../../libraries/redis/sentinel/ConnectionFailureExecption.php';

class Redis_SentinelTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function connectAllSentinelClientFailure() {
        $this->setExpectedException('Redis_Sentinel_ConnectionFailureExecption');

        $stub_client_1 = $this->getMockBuilder('Redis_Sentinel_Client')->disableOriginalConstructor()->getMock();
        $stub_client_1->expects($this->any())
            ->method('masters')
            ->will($this->throwException(new Redis_Sentinel_ConnectionTcpExecption));

        $stub_client_2 = $this->getMockBuilder('Redis_Sentinel_Client')->disableOriginalConstructor()->getMock();
        $stub_client_2->expects($this->any())
            ->method('masters')
            ->will($this->throwException(new Redis_Sentinel_ConnectionTcpExecption));

        $sentinel = new Redis_Sentinel('my_name');
        $sentinel->add($stub_client_1);
        $sentinel->add($stub_client_2);
        $sentinel->getMaster();
    }

    /**
     * @test
     */
    public function connectSuccess() {
        $stub_client_1 = $this->getMockBuilder('Redis_Sentinel_Client')->disableOriginalConstructor()->getMock();
        $stub_client_1->expects($this->any())
            ->method('masters')
            ->will($this->throwException(new Redis_Sentinel_ConnectionTcpExecption));

        $stub_client_2 = $this->getMockBuilder('Redis_Sentinel_Client')->disableOriginalConstructor()->getMock();
        $stub_client_2->expects($this->any())
            ->method('masters')
            ->willReturn([
                [ 'name' => 'my_redis', 'host' => '192.168.1.5', 'port' => 26379 ], 
            ]);
        $stub_client_2->expects($this->any())
            ->method('slaves')
            ->willReturn([
                [ 'name' => 'my_redis', 'host' => '192.168.1.6', 'port' => 26379, 'flags' => 'shutdown, slave' ], 
                [ 'name' => 'my_redis', 'host' => '192.168.1.7', 'port' => 26379, 'flags' => 'slave' ], 
                [ 'name' => 'my_redis', 'host' => '192.168.1.8', 'port' => 26379, 'flags' => 'slave' ],
            ]);

        $sentinel = new Redis_Sentinel('my_redis');
        $sentinel->add($stub_client_1);
        $sentinel->add($stub_client_2);

        $this->assertEquals('192.168.1.5', $sentinel->getMaster()['host']);
        $this->assertEquals('192.168.1.7', $sentinel->getSlaves()[0]['host']);
        $this->assertEquals('192.168.1.8', $sentinel->getSlaves()[1]['host']);
        $this->assertTrue( in_array( $sentinel->getSlave()['host'], ['192.168.1.7', '192.168.1.8'] ) );
    }
}