<?php
/**
 * http parse decorator class
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-28
 */
abstract class Http_Parse_Decorator extends Http_Parse_Abstract {

    public function __construct(Http_Parse_Abstract $parse) {
        $this->_http_parse = $parse;
    }

    public function setParse($parse) {
        $this->_http_parse->setParse($parse);
    }

    public function parse() {
        return $this->_http_parse->parse();
    }

    public function getRequest() {
        return $this->_http_parse->getRequest();
    }
}