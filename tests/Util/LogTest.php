<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\Log;

/**
 * Class LogTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class LogTest extends \PHPUnit_Framework_TestCase {
    /**
     * @return array
     */
    public static function provideWrite() {
        return [
            ['/tmp', 'phpunit.log', 'TestPHP', '/tmp/phpunit.log', 'TestPHP' . PHP_EOL],
            ['/tmp', 'tmp/phpunit.log', 'TestPHP', '/tmp/tmp/phpunit.log', 'TestPHP' . PHP_EOL],
        ];
    }

    /**
     * @param $logPath
     * @param $logFile
     * @param $logContent
     * @param $expectedLogFile
     * @param $expectedLogContent
     *
     * @test
     * @dataProvider provideWrite
     */
    public function write($logPath, $logFile, $logContent, $expectedLogFile, $expectedLogContent) {
        Log::$log_path = $logPath;
        Log::write($logContent, $logFile);
        $this->assertTrue(file_exists($expectedLogFile));
        $this->assertEquals($expectedLogContent, file_get_contents($expectedLogFile));
    }

    /**
     *
     */
    public function tearDown() {
        if ( file_exists("/tmp/phpunit.log") ) {
            unlink("/tmp/phpunit.log");
        }
        if ( file_exists("/tmp/tmp/phpunit.log") ) {
            unlink("/tmp/tmp/phpunit.log");
            rmdir("/tmp/tmp");
        }
    }
}