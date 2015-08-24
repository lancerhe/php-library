<?php
/**
 * IArray Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-27
 */

namespace Library\Tests\Util;

use Library\Util\IArray;

class IArrayTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->array = array(
            array(
                'id'         =>5698,
                'first_name' =>'Peter',
                'last_name'  =>'Griffin',
            ),
            array(
                'id'         =>4767,
                'first_name' =>'Ben',
                'last_name'  =>'Smith',
            ),
            array(
                'id'         =>3809,
                'first_name' =>'Joe',
                'last_name'  =>'Doe',
            )
        );
    }

    /**
     * @test
     */
    public function column() {
        $this->assertEquals(array(
            0 => 'Griffin',
            1 => 'Smith',
            2 => 'Doe',
        ), IArray::column($this->array, 'last_name') );
    }

    /**
     * @test
     */
    public function columnWithIndexKey() {
        $this->assertEquals(array(
            5698 => 'Griffin',
            4767 => 'Smith',
            3809 => 'Doe',
        ), IArray::column($this->array, 'last_name', 'id') );
    }

    /**
     * @test
     */
    public function columnWithKeyNullAndIndexKey() {
        $this->assertEquals(array(
            5698 => array(
                'id'         =>5698,
                'first_name' =>'Peter',
                'last_name'  =>'Griffin',
            ),
            4767 => array(
                'id'         =>4767,
                'first_name' =>'Ben',
                'last_name'  =>'Smith',
            ),
            3809 => array(
                'id'         =>3809,
                'first_name' =>'Joe',
                'last_name'  =>'Doe',
            )
        ), IArray::column($this->array, null, 'id') );
    }

    /**
     * @test
     */
    public function columnWithKeyNullAndIndexKey2() {
        $this->assertEquals(array(
            0 => array(
                'id'         =>5698,
                'first_name' =>'Peter',
                'last_name'  =>'Griffin',
            ),
            1 => array(
                'id'         =>4767,
                'first_name' =>'Ben',
                'last_name'  =>'Smith',
            ),
            2 => array(
                'id'         =>3809,
                'first_name' =>'Joe',
                'last_name'  =>'Doe',
            )
        ), IArray::column($this->array, null, 2) );
    }

    /**
     * @test
     */
    public function columnWithFirstParamtersNotIArray() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        IArray::column("string", 'first_name');
    }

    /**
     * @test
     */
    public function columnWithSecondParamtersNotCorrect() {
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
            return array();
        }

        $this->assertEquals(array(), IArray::column($this->array, 'last_name') );
    }

    /**
     * @test
     */
    public function mutisortAsc() {
        $array = array(
            array('id' => 2, 'name'=>'lancer', 'age'=>18),
            array('id' => 3, 'name'=>'chart',  'age'=>17),
            array('id' => 4, 'name'=>'chart',  'age'=>19),
        );
        $result = IArray::mutisort($array, 'age');
        $this->assertEquals(array(
            array('id' => 3, 'name'=>'chart',  'age'=>17),
            array('id' => 2, 'name'=>'lancer', 'age'=>18),
            array('id' => 4, 'name'=>'chart',  'age'=>19),
        ), $result);
    }

    /**
     * @test
     */
    public function mutisortDesc() {
        $array = array(
            array('id' => 2, 'name'=>'lancer', 'age'=>18),
            array('id' => 3, 'name'=>'chart',  'age'=>17),
            array('id' => 4, 'name'=>'chart',  'age'=>19),
        );
        $result = IArray::mutisort($array, 'age', SORT_DESC);
        $this->assertEquals(array(
            array('id' => 4, 'name'=>'chart',  'age'=>19),
            array('id' => 2, 'name'=>'lancer', 'age'=>18),
            array('id' => 3, 'name'=>'chart',  'age'=>17),
        ), $result);
    }

    /**
     * @test
     */
    public function mutisortWithParamtersNotCorrect() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        IArray::mutisort(null, 'age');
    }

    /**
     * @test
     */
    public function mutisortWithMutiRowsNotCorrect() {
        $result = IArray::mutisort(array('1', '2'), 'age');
        $this->assertEquals(array('1', '2'), $result);
    }
}