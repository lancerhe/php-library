<?php
/**
 * HTTP Parse Sapmle Testcase.
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-28
 */

require_once dirname(__FILE__) . '/../../../libraries/http/parse/Abstract.php';
require_once dirname(__FILE__) . '/../../../libraries/http/parse/Sample.php';

class SampleTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function parse() {
        $http_parse = new Http_Parse_Sample("header=user&name=lancer");
        $request = $http_parse->parse();
        $this->assertEquals("header=user&name=lancer", $request);
    }
}