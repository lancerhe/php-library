<?php
/**
 * Log Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-28
 */

namespace Library\Tests\Util;

use Library\Util\Log;

class LogTest extends \PHPUnit_Framework_TestCase {

    public static function provideWrite() {
        return array(
            array('/tmp', 'phpunit.log',     'TestPHP', '/tmp/phpunit.log',     'TestPHP'.PHP_EOL),
            array('/tmp', 'tmp/phpunit.log', 'TestPHP', '/tmp/tmp/phpunit.log', 'TestPHP'.PHP_EOL),
        );
    }

    /**
     * @test
     * @dataProvider provideWrite
     */
    public function write($log_path, $log_file, $log_content, $expected_log_file, $expected_log_content) {
        Log::$log_path = $log_path;
        Log::write($log_content, $log_file);

        $this->assertTrue(file_exists($expected_log_file));
        $this->assertEquals($expected_log_content, file_get_contents($expected_log_file));
    }

    public function tearDown() {
        if (file_exists("/tmp/phpunit.log")) {
            unlink("/tmp/phpunit.log");
        }
        if (file_exists("/tmp/tmp/phpunit.log")) {
            unlink("/tmp/tmp/phpunit.log");
            rmdir("/tmp/tmp");
        }
    }
}