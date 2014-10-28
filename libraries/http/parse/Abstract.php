<?php
/**
 * http parse abstract class
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-28
 */
abstract class Http_Parse_Abstract {

    abstract public function parse();

    abstract public function setParse($parse);

    abstract public function getRequest();
}