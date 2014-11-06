<?php
/**
 * Crypt_Id Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-11-06
 */
require_once dirname(__FILE__) . '/../../libraries/crypt/Id.php';

class Crypt_IdTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function encrypt() {
        $crypt   = new Crypt_Id();
        $encrypt = $crypt->encrypt(23123123);
        $this->assertEquals('w6lt46urq', $encrypt);
    }

    /**
     * @test
     */
    public function decrypt() {
        $crypt   = new Crypt_Id();
        $decrypt = $crypt->decrypt('1awntdz3z');
        $this->assertEquals(23123124, $decrypt);
    }

    /**
     * @test
     */
    public function alphaIDEncrypt() {
        $crypt   = new Crypt_Id();
        $encrypt = $crypt->alphaID(124, false, 8);
        $this->assertEquals('qdaaaaab', $encrypt);
    }


    /**
     * @test
     */
    public function alphaIDDecrypt() {
        $crypt   = new Crypt_Id();
        $encrypt = $crypt->alphaID('xvjaaaab', true, 8);
        $this->assertEquals('12443', $encrypt);
    }
}