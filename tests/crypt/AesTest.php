<?php
/**
 * Crypt_Aes Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-27
 */
require dirname(__FILE__) . '/../../libraries/crypt/Aes.php';

class Crypt_AesTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->_key = 'nh9a6d2b6s6g9ynh';
        $this->_iv  = 'ddky2235gee1g3mr';
    }

    /**
     * @test
     */
    public function encrypt() {
        $crypt   = new Crypt_Aes();
        $encrypt = $crypt->encrypt('my message', $this->_key, $this->_iv);
        $this->assertEquals('S5r5uy5zA7yTGIMj0rk68A==', $encrypt);
    }

    /**
     * @test
     */
    public function decrypt() {
        $crypt   = new Crypt_Aes();
        $decrypt = $crypt->decrypt('S5r5uy5zA7yTGIMj0rk68A==', $this->_key, $this->_iv);
        $this->assertEquals('my message', $decrypt);
    }
}