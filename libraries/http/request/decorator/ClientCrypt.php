<?php
/**
 * HTTP Client Connect Request Decorator
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-28
 */

require_once dirname(__FILE__) . '/../../../crypt/AES.php';
require_once dirname(__FILE__) . '/../../../crypt/RSA.php';

class Http_Request_Decorator_ClientCrypt extends Http_Request_Decorator {

    const ENCRY_TYPE_PLAINTEXT  = 0;

    const ENCRY_TYPE_AES        = 1;

    const ENCRY_TYPE_RSA        = 2;

    protected $_acton = 0;

    protected $_mode = 0; 

    protected $_session_id = 0;

    protected $_rsa_key_path = '';

    protected $_sign_key     = 'keykeykeykeykeyk';

    protected $_sign_iv      = 'iviviviviviviviv';

    public function setRSAKeyPath($key_path) {
        $this->_rsa_key_path = $key_path;
    }

    public function setSignKey($sign_key) {
        $this->_sign_key = $sign_key;
    }

    public function setSignIv($sign_iv) {
        $this->_sign_iv = $sign_iv;
    }

    protected function _buildPacketHeader() {
        $this->_request_header  = '';
        $this->_request_header .= pack('C',   $this->_mode );                   //length: 1
        $this->_request_header .= pack('n',   $this->_action );                 //length: 2
        $this->_request_header .= pack('N',   strlen( $this->_request_body ) ); //length: 4
        $this->_request_header .= pack('N',   time() );                         //length: 4
        $this->_request_header .= pack('A32', $this->_session_id );             //length: 32
        $this->_request_header .= pack('a7',  '');                              //length: 7
    }

    protected function _buildPacketBody() {
        $this->_request_body = json_encode($this->_request);
        switch ( $this->_mode ) {
            case self::ENCRY_TYPE_PLAINTEXT:
                return ;
            case self::ENCRY_TYPE_AES:
                $crypt = new Crypt_AES();
                $this->_request_body = $crypt->encrypt($this->_request_body, $this->_sign_key, $this->_sign_iv);break;
            case self::ENCRY_TYPE_RSA:
                $crypt = new Crypt_Rsa($this->_rsa_key_path);
                $this->_request_body = base64_encode( $crypt->pubEncrypt($this->_request_body) );break;
        }
    }

    public function sendRequest($url = null, $post = null) {
        // 设置请求信息
        curl_setopt($this->getHandler(), CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($this->getHandler(), CURLOPT_TIMEOUT, 3);

        $this->_action     = isset($post['action']) ? intval($post['action']) : '';
        $this->_mode       = isset($post['mode']) ? intval($post['mode']) : '';
        $this->_session_id = isset($post['session_id']) ? $post['session_id'] : '';
        $this->_request    = isset($post['request']) ? $post['request'] : array();

        $this->_buildPacketBody();
        $this->_buildPacketHeader();
        $post = array(
            'header' => $this->_request_header,
            'body'   => $this->_request_body,
        );
        parent::sendRequest($url, $post);
    }
}