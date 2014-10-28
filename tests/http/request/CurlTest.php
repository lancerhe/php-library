<?php
/**
 * HTTP Curl Testcase.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-27
 */

require_once dirname(__FILE__) . '/../../../libraries/http/request/Abstract.php';
require_once dirname(__FILE__) . '/../../../libraries/http/request/Curl.php';

class CurlTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function setRequest() {
        $curl = new Http_Request_Curl();
        $request = new StdClass();
        $request->post = array(2);
        $request->url  = 'http://www.baidu.com';
        $curl->setRequest($request);
        $result = $curl->getRequest();
        $this->assertEquals($result->post, $request->post);
        $this->assertEquals($result->url,  $request->url);
    }
}