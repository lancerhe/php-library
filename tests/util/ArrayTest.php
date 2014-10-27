<?php
/**
 * Util_Array Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-27
 */
require dirname(__FILE__) . '/../../libraries/util/Array.php';

class Util_ArrayTest extends PHPUnit_Framework_TestCase {

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
        ), Util_Array::column($this->array, 'last_name') );
    }

    /**
     * @test
     */
    public function columnWithIndexKey() {
        $this->assertEquals(array(
            5698 => 'Griffin',
            4767 => 'Smith',
            3809 => 'Doe',
        ), Util_Array::column($this->array, 'last_name', 'id') );
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
        ), Util_Array::column($this->array, null, 'id') );
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
        ), Util_Array::column($this->array, null, 2) );
    }

    /**
     * @test
     */
    public function columnWithFirstParamtersNotArray() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        Util_Array::column("string", 'first_name');
    }

    /**
     * @test
     */
    public function columnWithSecondParamtersNotCorrect() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        Util_Array::column($this->array, false);
    }

    /**
     * @test
     */
    public function columnWithThirdParamtersNotCorrect() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        Util_Array::column($this->array, 'last_name', false);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function columnWith_array_column_PHPFUNCITONExist() {
        function array_column() {
            return array();
        }

        $this->assertEquals(array(), Util_Array::column($this->array, 'last_name') );
    }
}