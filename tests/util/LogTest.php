<?php
/**
 * Util_Log Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-28
 */
require_once dirname(__FILE__) . '/../../libraries/util/Log.php';

class Util_LogTest extends PHPUnit_Framework_TestCase {

    public static function provideWrite() {
        return array(
            array('/tmp/wwwlogs', 'php.log', 'TestPHP', '/tmp/wwwlogs/php.log', 'TestPHP'.PHP_EOL),
            array('/tmp/wwwlogs', 'tmp/php.log', 'TestPHP', '/tmp/wwwlogs/tmp/php.log', 'TestPHP'.PHP_EOL),
        );
    }

    /**
     * @test
     * @dataProvider provideWrite
     */
    public function write($log_path, $log_file, $log_content, $expected_log_file, $expected_log_content) {
        Util_Log::$log_path = $log_path;
        Util_Log::write($log_content, $log_file);

        $this->assertTrue(file_exists($expected_log_file));
        $this->assertEquals($expected_log_content, file_get_contents($expected_log_file));
    }

    public function tearDown() {
        exec("rm -rf /tmp/wwwlogs/*");
    }
}