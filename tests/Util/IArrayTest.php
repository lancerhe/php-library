<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\IArray;

/**
 * Class IArrayTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class IArrayTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var array
     */
    public $array;

    /**
     *
     */
    public function setUp() {
        $this->array = [
            [
                'id'         => 5698,
                'first_name' => 'Peter',
                'last_name'  => 'Griffin',
            ],
            [
                'id'         => 4767,
                'first_name' => 'Ben',
                'last_name'  => 'Smith',
            ],
            [
                'id'         => 3809,
                'first_name' => 'Joe',
                'last_name'  => 'Doe',
            ],
        ];
    }

    /**
     * @test
     */
    public function column() {
        $this->assertEquals([
            0 => 'Griffin',
            1 => 'Smith',
            2 => 'Doe',
        ], IArray::column($this->array, 'last_name'));
    }

    /**
     * @test
     */
    public function column_with_index_key() {
        $this->assertEquals([
            5698 => 'Griffin',
            4767 => 'Smith',
            3809 => 'Doe',
        ], IArray::column($this->array, 'last_name', 'id'));
    }

    /**
     * @test
     */
    public function column_with_key_null_and_index_key() {
        $this->assertEquals([
            5698 => [
                'id'         => 5698,
                'first_name' => 'Peter',
                'last_name'  => 'Griffin',
            ],
            4767 => [
                'id'         => 4767,
                'first_name' => 'Ben',
                'last_name'  => 'Smith',
            ],
            3809 => [
                'id'         => 3809,
                'first_name' => 'Joe',
                'last_name'  => 'Doe',
            ],
        ], IArray::column($this->array, null, 'id'));
    }

    /**
     * @test
     */
    public function column_with_key_null_and_index_key_2() {
        $this->assertEquals([
            0 => [
                'id'         => 5698,
                'first_name' => 'Peter',
                'last_name'  => 'Griffin',
            ],
            1 => [
                'id'         => 4767,
                'first_name' => 'Ben',
                'last_name'  => 'Smith',
            ],
            2 => [
                'id'         => 3809,
                'first_name' => 'Joe',
                'last_name'  => 'Doe',
            ],
        ], IArray::column($this->array, null, 2));
    }

    /**
     * @test
     */
    public function column_with_first_parameter_not_array() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        IArray::column("string", 'first_name');
    }

    /**
     * @test
     */
    public function column_with_first_parameter_not_correct() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        IArray::column($this->array, false);
    }

    /**
     * @test
     */
    public function columnWithThirdParamtersNotCorrect() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        IArray::column($this->array, 'last_name', false);
    }

    /**
     * @runInSeparateProcess
     */
    public function columnWith_array_column_PHPFUNCITONExist() {
        function array_column() {
            return [];
        }

        $this->assertEquals([], IArray::column($this->array, 'last_name'));
    }

    /**
     * @test
     */
    public function mutisortAsc() {
        $array  = [
            ['id' => 2, 'name' => 'lancer', 'age' => 18],
            ['id' => 3, 'name' => 'chart', 'age' => 17],
            ['id' => 4, 'name' => 'chart', 'age' => 19],
        ];
        $result = IArray::multiSort($array, 'age');
        $this->assertEquals([
            ['id' => 3, 'name' => 'chart', 'age' => 17],
            ['id' => 2, 'name' => 'lancer', 'age' => 18],
            ['id' => 4, 'name' => 'chart', 'age' => 19],
        ], $result);
    }

    /**
     * @test
     */
    public function mutisortDesc() {
        $array  = [
            ['id' => 2, 'name' => 'lancer', 'age' => 18],
            ['id' => 3, 'name' => 'chart', 'age' => 17],
            ['id' => 4, 'name' => 'chart', 'age' => 19],
        ];
        $result = IArray::multiSort($array, 'age', SORT_DESC);
        $this->assertEquals([
            ['id' => 4, 'name' => 'chart', 'age' => 19],
            ['id' => 2, 'name' => 'lancer', 'age' => 18],
            ['id' => 3, 'name' => 'chart', 'age' => 17],
        ], $result);
    }

    /**
     * @test
     */
    public function mutisortWithParamtersNotCorrect() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        IArray::multiSort(null, 'age');
    }

    /**
     * @test
     */
    public function multisortWithMutiRowsNotCorrect() {
        $result = IArray::multiSort(['1', '2'], 'age');
        $this->assertEquals(['1', '2'], $result);
    }
}