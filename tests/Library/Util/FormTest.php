<?php
/**
 * Form Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-10-27
 */

namespace Library\Tests\Util;

use Library\Util\Form;

class FormTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function options() {
        $html = Form::options(array(1 => 'One', 2 => 'Two'));
        $this->assertContains('<option value="1">One</option>', $html);
        $this->assertContains('<option value="2">Two</option>', $html);
    }

    /**
     * @test
     */
    public function optionsWithSelectedKey() {
        $html = Form::options(array(0 => 'One', 1 => 'Two'), 0);
        $this->assertContains('<option value="0" selected>One</option>', $html);
        $this->assertContains('<option value="1">Two</option>', $html);
    }

    /**
     * @test
     */
    public function optionsWithDefaultOptionLabel() {
        $html = Form::options(array(0 => 'One', 1 => 'Two'), null, 'Please choose');
        $this->assertContains('<option value="">Please choose</option>', $html);
        $this->assertContains('<option value="0">One</option>', $html);
        $this->assertContains('<option value="1">Two</option>', $html);
    }

    /**
     * @test
     */
    public function optionsWithLabel2Value() {
        $html = Form::options(array(1 => 'One', 2 => 'Two'), null, null, true);
        $this->assertContains('<option value="One">One</option>', $html);
        $this->assertContains('<option value="Two">Two</option>', $html);
    }

    /**
     * @test
     */
    public function select() {
        $html = Form::select('country', array(1 => 'America', 2 => 'China'));
        $this->assertContains('name="country"', $html);
        $this->assertContains('id="country"', $html);
    }

    /**
     * @test
     */
    public function selectWithCallback() {
        $html = Form::select('country', array(1 => 'America', 2 => 'China'), null, null, "addListener()");
        $this->assertContains('onchange="return addListener();"', $html);
    }

    /**
     * @test
     */
    public function radio() {
        $html = Form::radio('sex', array(1 => 'Male', 2 => 'Female'));
        $this->assertContains('<label class="radio">',                           $html);
        $this->assertContains('<input type="radio" name="sex" value="1">Male',   $html);
        $this->assertContains('<input type="radio" name="sex" value="2">Female', $html);
    }

    /**
     * @test
     */
    public function radioWithCheckedKey() {
        $html = Form::radio('sex', array(0 => 'Male', 1 => 'Female'), 0);
        $this->assertContains('<label class="radio">',                           $html);
        $this->assertContains('<input type="radio" name="sex" value="0" checked>Male',   $html);
        $this->assertContains('<input type="radio" name="sex" value="1">Female', $html);
    }

    /**
     * @test
     */
    public function radioWithClass() {
        $html = Form::radio('sex', array(0 => 'Male', 1 => 'Female'), null, 'radio-inline');
        $this->assertContains('<label class="radio-inline">', $html);
    }

    /**
     * @test
     */
    public function checkbox() {
        $html = Form::checkbox('play[]', array(0 => 'Football', 1 => 'Basketball', 2 => 'Swimming'));
        $this->assertContains('<label class="checkbox">',                           $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="0">Football',   $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="1">Basketball', $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="2">Swimming',   $html);
    }

    /**
     * @test
     */
    public function checkboxWithCheckedKey() {
        $html = Form::checkbox('play[]', array(0 => 'Football', 1 => 'Basketball', 2 => 'Swimming'), array(0, 2));
        $this->assertContains('<input type="checkbox" name="play[]" value="0" checked>Football',   $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="1">Basketball', $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="2" checked>Swimming',   $html);
    }

    /**
     * @test
     */
    public function checkboxWithClass() {
        $html = Form::checkbox('play[]', array(0 => 'Football', 1 => 'Basketball', 2 => 'Swimming'), array(), 'checkbox-inline');
        $this->assertContains('<label class="checkbox-inline">', $html);
    }
}