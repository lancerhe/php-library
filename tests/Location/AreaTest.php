<?php
namespace LancerHe\Library\Tests\Location;

use LancerHe\Library\Location\Area;

/**
 * Class AreaTest
 *
 * @package LancerHe\Library\Tests\Location
 * @author  Lancer He <lancer.he@gmail.com>
 */
class AreaTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var Area
     */
    public $Area;

    /**
     *
     */
    public function setUp() {
        $this->Area = new Area();
    }

    /**
     * @test
     */
    public function getArea() {
        $this->assertEquals('仓山区', $this->Area->getArea(350104));
    }

    /**
     * @test
     */
    public function getCity() {
        $this->assertEquals('福州市', $this->Area->getCity(350104));
    }

    /**
     * @test
     */
    public function getProvince() {
        $this->assertEquals('福建省', $this->Area->getProvince(350104));
    }

    /**
     * @test
     */
    public function getPath() {
        $this->assertEquals('福建省 福州市 仓山区', $this->Area->getPath(350104));
    }

    /**
     * @test
     */
    public function getPathWithSpecialCity() {
        $this->assertEquals('北京市 东城区', $this->Area->getPath(110101));
    }
}
