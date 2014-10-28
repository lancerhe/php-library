<?php
/**
 * HTTP请求装饰类 简单加密请求 测试类
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-25
 */

require_once dirname(__FILE__) . '/../../../../libraries/http/parse/Abstract.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/parse/Sample.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/parse/Decorator.php';
require_once dirname(__FILE__) . '/../../../../libraries/http/parse/decorator/ClientCrypt.php';

class Parse_Decorator_ClientCryptTest extends PHPUnit_Framework_TestCase {

    protected $_rsa_key_path = '/tmp/phpunit/';

    protected $_aes_sign_key = 'keykeykeykeykey1';

    protected $_aes_sign_iv  = 'iviviviviviviviv';

    public function setUp() {
        if ( ! is_dir($this->_rsa_key_path)) mkdir($this->_rsa_key_path, 0777, true);
        file_put_contents('/tmp/phpunit/priv.key', file_get_contents(dirname(__FILE__) . '/../../../setup/priv.key'));
        file_put_contents('/tmp/phpunit/pub.key', file_get_contents(dirname(__FILE__) . '/../../../setup/pub.key'));
    }

    public static function provideParseSuccess() {
        return array(
            array(0, array(), 1002, '1aabac6d068eef6a7bad3fdf50a05cc8'),
            array(0, null, 1002, '1aabac6d068eef6a7bad3fdf50a05cc8'),
            array(0, array('name' => 'Lancer', 'age' => 27), 1002, '1aabac6d068eef6a7bad3fdf50a05cc8'),
            array(1, array('name' => 'Lancer', 'sex' => 'male'), 998, '64e42109dbcc682969d01b6fa911d7ab'),
            array(2, array('name' => 'Lancer', 'dept' => 'sales'), 1, 'd332bad22159a6ea1122f032b57cfd92'),
        );
    }


    /**
     * @test
     * @dataProvider provideParseSuccess
     */
    public function parseSuccess($mode, $request, $action, $session_id) {
        $body       = $this->_buildPacketBody($request, $mode);
        $header     = $this->_buildPacketHeader(array(
            'mode'       => $mode,
            'action'     => $action,
            'length'     => strlen($body),
            'time'       => time(),
            'session_id' => $session_id, 
        ));

        $http_parse = new Http_Parse_Sample(array(
            'header' => $header,
            'body'   => $body,
        ));
        $http_parse = new Http_Parse_Decorator_ClientCrypt($http_parse);
        $http_parse->setRsaKeyPath($this->_rsa_key_path);
        $http_parse->setSignKey($this->_aes_sign_key);
        $http_parse->setSignIv( $this->_aes_sign_iv);
        $parse = $http_parse->parse();

        $this->assertEquals($request,    $parse['body']);
        $this->assertEquals($action,     $parse['header']['action']);
        $this->assertEquals($session_id, $parse['header']['session_id']);
    }

    /**
     * @test
     * @dataProvider provideParseSuccess
     */
    public function parseSuccessWhenSessionId($mode, $request, $action, $session_id) {
        $body       = $this->_buildPacketBody($request, $mode);
        $header     = $this->_buildPacketHeader(array(
            'mode'       => $mode,
            'action'     => $action,
            'length'     => strlen($body),
            'time'       => time() - 70,
            'session_id' => $session_id, 
        ));

        $http_parse = new Http_Parse_Sample(array(
            'header' => $header,
            'body'   => $body,
        ));
        $http_parse = new Http_Parse_Decorator_ClientCrypt($http_parse);
        $http_parse->setRsaKeyPath($this->_rsa_key_path);
        $http_parse->setSignKey($this->_aes_sign_key);
        $http_parse->setSignIv( $this->_aes_sign_iv);
        $http_parse->setSessionAction($action);
        $parse = $http_parse->parse();

        $this->assertEquals($request,    $parse['body']);
        $this->assertEquals($action,     $parse['header']['action']);
        $this->assertEquals($session_id, $parse['header']['session_id']);
    }

    /**
     * @test
     */
    public function parseByParamsNotCorrect() {
        $this->setExpectedException('Http_Parse_Decorator_ClientCrypt_ParamsInvalidException');

        $http_parse = new Http_Parse_Sample(array(
            'header' => '',
            'body'   => '',
        ));
        $http_parse = new Http_Parse_Decorator_ClientCrypt($http_parse);
        $parse = $http_parse->parse();
    }

    /**
     * @test
     */
    public function parseByDecryptHeaderFailure() {
        $this->setExpectedException('Http_Parse_Decorator_ClientCrypt_DecryptHeaderFailureException');

        $http_parse = new Http_Parse_Sample(array(
            'header' => 'Not5numberNot5numberNot5numberNot5numberNot5number',
            'body'   => '',
        ));
        $http_parse = new Http_Parse_Decorator_ClientCrypt($http_parse);
        $parse = $http_parse->parse();
    }

    /**
     * @test
     */
    public function parseByTimeout() {
        $this->setExpectedException('Http_Parse_Decorator_ClientCrypt_TimeoutException');

        $body       = $this->_buildPacketBody(array(), 1);
        $header     = $this->_buildPacketHeader(array(
            'mode'       => 1,
            'action'     => 1002,
            'length'     => strlen($body),
            'time'       => time() + 70,
            'session_id' => '64e42109dbcc682969d01b6fa911d7ab', 
        ));

        $http_parse = new Http_Parse_Sample(array(
            'header' => $header,
            'body'   => $body,
        ));
        $http_parse = new Http_Parse_Decorator_ClientCrypt($http_parse);
        $parse = $http_parse->parse();
    }

    /**
     * @test
     */
    public function parseByBodyLengthNotMatch() {
        $this->setExpectedException('Http_Parse_Decorator_ClientCrypt_BodyLengthNotMatchException');

        $body       = $this->_buildPacketBody(array(), 1);
        $header     = $this->_buildPacketHeader(array(
            'mode'       => 1,
            'action'     => 1002,
            'length'     => strlen($body) + 2,
            'time'       => time(),
            'session_id' => '64e42109dbcc682969d01b6fa911d7ab', 
        ));

        $http_parse = new Http_Parse_Sample(array(
            'header' => $header,
            'body'   => $body,
        ));
        $http_parse = new Http_Parse_Decorator_ClientCrypt($http_parse);
        $parse = $http_parse->parse();
    }

    /**
     * @test
     */
    public function parseByDecryptBodyFailure() {
        $this->setExpectedException('Http_Parse_Decorator_ClientCrypt_DecryptBodyFailureException');

        $body       = $this->_buildPacketBody(array("user"=>"lancer"), 1) . 'not match words';
        $header     = $this->_buildPacketHeader(array(
            'mode'       => 1,
            'action'     => 1002,
            'length'     => strlen($body),
            'time'       => time(),
            'session_id' => '64e42109dbcc682969d01b6fa911d7ab', 
        ));

        $http_parse = new Http_Parse_Sample(array(
            'header' => $header,
            'body'   => $body,
        ));
        $http_parse = new Http_Parse_Decorator_ClientCrypt($http_parse);
        $http_parse->setRsaKeyPath($this->_rsa_key_path);
        $http_parse->setSignKey($this->_aes_sign_key);
        $http_parse->setSignIv( $this->_aes_sign_iv);
        $parse = $http_parse->parse();
    }

    protected function _buildPacketHeader($header) {
        $request_header  = '';
        $request_header .= pack('C',   $header['mode'] );                   //length: 1
        $request_header .= pack('n',   $header['action'] );                 //length: 2
        $request_header .= pack('N',   $header['length'] );                 //length: 4
        $request_header .= pack('N',   $header['time'] );                   //length: 4
        $request_header .= pack('A32', $header['session_id'] );             //length: 32
        $request_header .= pack('a7',  '');                                 //length: 7
        return $request_header;
    }

    protected function _buildPacketBody($body, $mode) {
        $request_body = json_encode($body);
        switch ( $mode ) {
            case 0:
                return $request_body;
            case 1:
                $crypt = new Crypt_AES();
                $request_body = $crypt->encrypt($request_body, $this->_aes_sign_key, $this->_aes_sign_iv);break;
            case 2:
                $crypt = new Crypt_Rsa($this->_rsa_key_path);
                $request_body = base64_encode( $crypt->pubEncrypt($request_body) );break;
        }
        return $request_body;
    }
}
