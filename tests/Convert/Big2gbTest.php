<?php
namespace LancerHe\Library\Tests\Convert;

use LancerHe\Library\Convert\Big2gb;

/**
 * Class Big2gbTest
 *
 * @package LancerHe\Library\Tests\Convert
 * @author  Lancer He <lancer.he@gmail.com>
 */
class Big2gbTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function gb2big() {
        $string = Big2gb::gb2big('中华人民共和国万岁');
        $this->assertEquals('中華人民共和國萬歲', $string);
    }

    /**
     * @test
     */
    public function big2gb() {
        $string = Big2gb::big2gb('設定自己帳號下的環境參數');
        $this->assertEquals('设定自己帐号下的环境参数', $string);
    }
}