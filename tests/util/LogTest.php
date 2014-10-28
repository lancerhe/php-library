<?php
/**
 * Util_Log Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-28
 */
require dirname(__FILE__) . '/../../libraries/util/Log.php';

class Util_LogTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function write() {
        Util_Log::$log_path = "/tmp/wwwlogs/";
        Util_Log::write('TestPHP', 'php.log');

        $this->assertTrue(file_exists('/tmp/wwwlogs/php.log'));
        $this->assertEquals('TestPHP' . PHP_EOL, file_get_contents('/tmp/wwwlogs/php.log'));
    }

    public function tearDown() {
        if ( file_exists('/tmp/wwwlogs/php.log') ) {
            unlink('/tmp/wwwlogs/php.log');
        }
    }
}