<?php
/**
 * Crypt_RSA Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-27
 */
require_once dirname(__FILE__) . '/../../libraries/crypt/RSA.php';

class Crypt_RSATest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->crypt = new Crypt_RSA('/tmp/rsakey/');
    }

    /**
     * @test
     */
    public function createKey() {
        $this->crypt->createKey();
        $this->assertTrue(file_exists('/tmp/rsakey/priv.key'));
        $this->assertTrue(file_exists('/tmp/rsakey/pub.key'));
    }

    /**
     * @test
     */
    public function setupPrivateKey() {
        $setup_result = $this->crypt->setupPrivateKey();
        $this->assertTrue($setup_result);

        $key_exists_setup = $this->crypt->setupPrivateKey();
        $this->assertTrue($key_exists_setup);
    }

    /**
     * @test
     */
    public function setupPublicKey() {
        $setup_result = $this->crypt->setupPublicKey();
        $this->assertTrue($setup_result);

        $key_exists_setup = $this->crypt->setupPublicKey();
        $this->assertTrue($key_exists_setup);
    }

    /**
     * @test
     */
    public function getPublicKeyModulus() {
        file_put_contents('/tmp/rsakey/priv.key', '-----BEGIN PRIVATE KEY-----
MIIBVgIBADANBgkqhkiG9w0BAQEFAASCAUAwggE8AgEAAkEAm/QglXWYhrTBqOKM
1SrW+Fp17U+U4QMFuc0MATMSHO8uS4nAeclNj3tIf2wVeiqVRMN2Pob4IoUX9eu/
YkUmvQIDAQABAkBFVwdBzNZzVl0gzRIXGYQZSodSa2bjoOdj1EJ5Kg7so845xjuO
oj7qMSvMplw3xN9vVOclE1O1T/GL5rkI4AoVAiEAyzMI1dntzlFeUSbapoIOn7uk
HGCL3ylF+b8sjwAR+GcCIQDEekXrSxaMVoJ5QiVqzcDuVqodC6KD92DYwdqMK0OB
OwIhAI/lQhp+y6LRiGMbirdjXovLS3o0/Jg6GC22Lg3OVOt9AiEAiclWD1RxU6m3
hmIk62mvy3Vrh0MJjZKGkHwiT/pnNNECIQC4sliICwRB1YlVG8EG47+jFbmp35Mg
Xj+dGaf/SnaHMg==
-----END PRIVATE KEY-----
');
        $modulus = $this->crypt->getPublicKeyModulus();
        $this->assertEquals('9BF42095759886B4C1A8E28CD52AD6F85A75ED4F94E10305B9CD0C0133121CEF2E4B89C079C94D8F7B487F6C157A2A9544C3763E86F8228517F5EBBF624526BD', $modulus);
    }

    /**
     * @test
     */
    public function pubEncryptParamterNotString() {
        $encrypted = $this->crypt->pubEncrypt(array());
        $this->assertEquals(null, $encrypted);
    }

    /**
     * @test
     */
    public function privDecryptParamterNotString() {
        $decrypted = $this->crypt->privDecrypt(array());
        $this->assertEquals(null, $decrypted);
    }

    /**
     * @test
     */
    public function pubEncryptFailure() {
        $this->setupPublicKey();
        $encrypted = $this->crypt->pubEncrypt("0x45d267021a5117a22610953f3cf89b3bca9f9f378ebc757f2840331c0a867b7928a2ebc06c0");
        $this->assertEquals(null, $encrypted);
    }

    /**
     * @test
     */
    public function privDecryptFailure() {
        $this->setupPrivateKey();
        $decrypted = $this->crypt->privDecrypt("aassddttdd");
        $this->assertEquals(null, $decrypted);
    }

    /**
     * @test
     */
    public function pubEncryptAndPrivDecryptSuccess() {
        $encrypted = $this->crypt->pubEncrypt('new message');
        $this->assertEquals('new message', $this->crypt->privDecrypt($encrypted));
    }

    public function tearDown() {
        exec("rm -rf /tmp/rsakey");
        unset($this->crypt);
    }
}