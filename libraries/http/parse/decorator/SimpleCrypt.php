<?php
/**
 * HTTP Parse Simple Crypt
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-10
 */
class Http_Parse_Decorator_SimpleCrypt extends Http_Parse_Decorator {

    protected $_crypt_key    = '2S23ED';

    public function parse() {
        $request = $this->getRequest();
        parse_str($request, $post);
        $sign = $post['sign'];
        unset($post['sign']);

        if ( $sign !== md5(json_encode($post) . $this->_crypt_key) ) {
            throw new Exception("Error Processing Request", 1);
        }
        $this->setParse($post);
        return parent::parse();
    }
}
