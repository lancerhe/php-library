<?php
/**
 * HTTP日志装饰类 测试类
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-25
 */

require_once dirname(__FILE__) . '/../../../../libraries/util/Log.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/request/Abstract.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/request/Curl.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/request/Decorator.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/request/decorator/LoggerFile.php';

class Decorator_LoggerFileTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function write() {
        $http_request = new Http_Request_Curl();
        $http_request = new Http_Request_Decorator_LoggerFile($http_request);
        $http_request->setLogFilePath("/httprequest/phpunit.log");
        $http_request->sendRequest("http://127.0.0.1", array("a" => 1));

        $request = new StdClass();
        $request->post = array(2);
        $request->url  = 'http://www.baidu.com';
        $http_request->setRequest($request);

        $this->assertTrue(file_exists('/tmp/wwwlogs/httprequest/phpunit.log'));
        $log = file_get_contents('/tmp/wwwlogs/httprequest/phpunit.log');
        $this->assertContains('Host: 127.0.0.1', $log);
        $this->assertContains('[request_variable_body] => a=1', $log);
        $this->assertContains('[request_original_body] => a=1', $log);
        $this->assertContains('[response_http_code]', $log);
        $this->assertContains('[response_body]', $log);
    }

    public function tearDown() {
        parent::tearDown();
        exec("rm -rf /tmp/wwwlogs/*");
    }
}