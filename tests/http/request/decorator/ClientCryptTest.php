<?php
/**
 * HTTP Client Connect Request Decorator Tesecase
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-25
 */

require_once dirname(__FILE__) . '/../../../../libraries/http/request/Abstract.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/request/Curl.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/request/Decorator.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/request/decorator/ClientCrypt.php';

class Decorator_ClientCryptTest extends PHPUnit_Framework_TestCase {

    protected $_rsa_key_path = '/tmp/phpunit/';

    protected $_aes_sign_key = 'keykeykeykeykey1';

    protected $_aes_sign_iv  = 'iviviviviviviviv';

    public function setUp() {
        $stub_http_curl = $this->getMock('Http_Request_Curl', array('executeRequest'));
        $stub_http_curl->expects($this->any())
            ->method('executeRequest')
            ->will($this->returnValue(''));
        $this->_http_request = new Http_Request_Decorator_ClientCrypt($stub_http_curl);
        $this->_http_request->setRsaKeyPath($this->_rsa_key_path);
        $this->_http_request->setSignKey($this->_aes_sign_key);
        $this->_http_request->setSignIv( $this->_aes_sign_iv);

        if ( ! is_dir($this->_rsa_key_path)) mkdir($this->_rsa_key_path, 0777, true);
        file_put_contents('/tmp/phpunit/priv.key', file_get_contents(dirname(__FILE__) . '/../../../setup/priv.key'));
        file_put_contents('/tmp/phpunit/pub.key', file_get_contents(dirname(__FILE__) . '/../../../setup/pub.key'));
    }

    /**
     * @test
     */
    public function sendRequestWithNoEncrypt() {
        $this->_http_request->sendRequest(
            "http://www.baidu.com", 
            array(
                "mode"       => 0,
                "action"     => 1002,
                "session_id" => '3776081ca1f9765bec58238365d8ade9',
                "request"    => array('name' => 'Lancer', 'age' => 27),
            )
        );
        $request = $this->_http_request->getRequest();
        parse_str($request->post, $post);

        list(, $mode)        = unpack('C*', substr($post['header'], 0, 1) );
        list(, $action)      = unpack('n*', substr($post['header'], 1, 2) );
        list(, $session_id)  = unpack('A*', substr($post['header'], 11, 32) );
        $this->assertEquals("0",    $mode);
        $this->assertEquals("1002", $action);
        $this->assertEquals("3776081ca1f9765bec58238365d8ade9", $session_id);
        $this->assertEquals('{"name":"Lancer","age":27}', $post['body']);
    }

    /**
     * @test
     */
    public function sendRequestWithAESEncrypt() {
        $this->_http_request->sendRequest(
            "http://www.baidu.com", 
            array(
                "mode"       => 1,
                "action"     => 1002,
                "session_id" => '3776081ca1f9765bec58238365d8ade9',
                "request"    => array('name' => 'Lancer', 'age' => 27),
            )
        );
        $request = $this->_http_request->getRequest();
        parse_str($request->post, $post);

        $crypt = new Crypt_AES();
        $body  = $crypt->decrypt($post['body'], $this->_aes_sign_key, $this->_aes_sign_iv);

        $this->assertEquals('{"name":"Lancer","age":27}', $body);
    }

    /**
     * @test
     */
    public function sendRequestWithRSAEncrypt() {
        $this->_http_request->sendRequest(
            "http://www.baidu.com", 
            array(
                "mode"       => 2,
                "action"     => 1002,
                "session_id" => '3776081ca1f9765bec58238365d8ade9',
                "request"    => array('name' => 'Lancer', 'age' => 27),
            )
        );
        $request = $this->_http_request->getRequest();
        parse_str($request->post, $post);

        $crypt = new Crypt_RSA($this->_rsa_key_path);
        $body  = $crypt->privDecrypt(base64_decode($post['body']));

        $this->assertEquals('{"name":"Lancer","age":27}', $body);
    }
}