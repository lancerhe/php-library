<?php
/**
 * HTTP Client Connect Parse Decorator
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-28
 */

require_once dirname(__FILE__) . '/../../../crypt/AES.php';
require_once dirname(__FILE__) . '/../../../crypt/RSA.php';

class Http_Parse_Decorator_ClientCrypt_Mode {
    const PLAINTEXT  = 0; // 不加密模式
    const AES        = 1; // AES模式
    const RSA        = 2; // RSA模式
}

class Http_Parse_Decorator_ClientCrypt_ParamsInvalidException extends Exception {
    public $code    = 801;
    public $message = '参数格式错误';  //参数POST错误，参数缺少或者参数值不合法,  header不足50位等
}

class Http_Parse_Decorator_ClientCrypt_DecryptHeaderFailureException extends Exception {
    public $code    = 802;
    public $message = '数据解密包头失败';  //包头出来的mode不在规范模式内
}

class Http_Parse_Decorator_ClientCrypt_TimeoutException extends Exception {
    public $code    = 803;
    public $message = '数据包超时';  //数据包超时
}

class Http_Parse_Decorator_ClientCrypt_BodyLengthNotMatchException extends Exception {
    public $code    = 804;
    public $message = '数据包长度异常';  //包体长度和包头提供的不一致
}

class Http_Parse_Decorator_ClientCrypt_DecryptBodyFailureException extends Exception {
    public $code    = 805;
    public $message = '数据解密包体失败';  //通过算法解出来的包体不是数组,解密失败 
}

class Http_Parse_Decorator_ClientCrypt extends Http_Parse_Decorator {

    protected $_acton = 0;

    protected $_mode = 0; 

    protected $_session_id = 0;

    protected $_rsa_key_path = '';

    protected $_sign_key     = 'keykeykeykeykeyk';

    protected $_sign_iv      = 'iviviviviviviviv';

    protected $_session_action = null;

    /**
     * @desc   设置第一次请求的Action
     * @access public
     * @param  int   $action
     * @return void
     */ 
    public function setSessionAction($action) {
        $this->_session_action = $action;
    }

    public function setRSAKeyPath($key_path) {
        $this->_rsa_key_path = $key_path;
    }

    public function setSignKey($sign_key) {
        $this->_sign_key = $sign_key;
    }

    public function setSignIv($sign_iv) {
        $this->_sign_iv = $sign_iv;
    }

     /**
     * @desc   获取包头信息
     * @access protected
     * @return void
     */
    protected function _parsePacketHeader() {
        if ( ! isset($this->_request['header']) || 50 != strlen($this->_request['header']) ) {
            throw new Http_Parse_Decorator_ClientCrypt_ParamsInvalidException();
        }
        list(, $this->_request_header['mode'])        = unpack('C*', substr($this->_request['header'], 0, 1) );   //包体加密模式
        list(, $this->_request_header['action'])      = unpack('n*', substr($this->_request['header'], 1, 2) );
        list(, $this->_request_header['length'])      = unpack('N*', substr($this->_request['header'], 3, 4) );   //包体长度
        list(, $this->_request_header['timestamp'])   = unpack('N*', substr($this->_request['header'], 7, 4) );  //时间戳
        list(, $this->_request_header['session_id'])  = unpack('A*', substr($this->_request['header'], 11, 32) );

        $this->_action       = $this->_request_header['action'];
        $this->_mode         = $this->_request_header['mode'];

        if ( ! in_array($this->_mode, array(
            Http_Parse_Decorator_ClientCrypt_Mode::PLAINTEXT,
            Http_Parse_Decorator_ClientCrypt_Mode::AES,
            Http_Parse_Decorator_ClientCrypt_Mode::RSA
            ))) 
            throw new Http_Parse_Decorator_ClientCrypt_DecryptHeaderFailureException();
            
        // 验证的包头时间戳和服务器时间戳之间的间隔 在30秒内表示POST数据有效
        if ( ($this->_session_action != $this->_action) AND ( abs( $this->_request_header['timestamp'] - time() ) > 60 ) ) {
            throw new Http_Parse_Decorator_ClientCrypt_TimeoutException();
        }
    }

    /**
     * @desc   获取包体信息
     * @access protected    
     * @return void
     */
    protected function _parsePacketBody() {
        $body = $this->_request['body'];
        if ( 0 == $this->_request_header['length']
            || 'null' == strtolower($body) ) {
            $this->_request_body = null;
            return;
        }

        // 验证包体长度有效性 (包头解析后, 带有的包体长度 = 实际包体长度)
        if ( strlen($body) != $this->_request_header['length'] ) 
            throw new Http_Parse_Decorator_ClientCrypt_BodyLengthNotMatchException();

        switch ( $this->_mode ) {
            case Http_Parse_Decorator_ClientCrypt_Mode::PLAINTEXT :
                $body = json_decode($body, true);
                break;
            case Http_Parse_Decorator_ClientCrypt_Mode::AES :
                $crypt = new Crypt_AES();
                $body = json_decode($crypt->decrypt($body, $this->_sign_key, $this->_sign_iv), true);
                break;
            case Http_Parse_Decorator_ClientCrypt_Mode::RSA :
                $crypt = new Crypt_Rsa($this->_rsa_key_path);
                $body = json_decode($crypt->privDecrypt( base64_decode( $body ) ), true);
                break;
        }

        // 如果解密出来的结果不是数组，说明解密算法出问题的
        if ( ! is_array($body) ) {
            throw new Http_Parse_Decorator_ClientCrypt_DecryptBodyFailureException();
        }
        $this->_request_body = $body;
    }

    public function parse() {
        $this->_request = $this->getRequest();

        $this->_parsePacketHeader();
        $this->_parsePacketBody();
        $this->setParse(array(
            'header' => $this->_request_header,
            'body'   => $this->_request_body,
        ));
        return parent::parse();
    }
}