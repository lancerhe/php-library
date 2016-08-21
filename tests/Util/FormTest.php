<?php
namespace LancerHe\Library\Tests\Util;

use LancerHe\Library\Util\Form;

/**
 * Class FormTest
 *
 * @package LancerHe\Library\Tests\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class FormTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function options() {
        $html = Form::options([1 => 'One', 2 => 'Two']);
        $this->assertContains('<option value="1">One</option>', $html);
        $this->assertContains('<option value="2">Two</option>', $html);
    }

    /**
     * @test
     */
    public function options_with_selected_key() {
        $html = Form::options([0 => 'One', 1 => 'Two'], 0);
        $this->assertContains('<option value="0" selected>One</option>', $html);
        $this->assertContains('<option value="1">Two</option>', $html);
    }

    /**
     * @test
     */
    public function options_with_default_option_label() {
        $html = Form::options([0 => 'One', 1 => 'Two'], null, 'Please choose');
        $this->assertContains('<option value="">Please choose</option>', $html);
        $this->assertContains('<option value="0">One</option>', $html);
        $this->assertContains('<option value="1">Two</option>', $html);
    }

    /**
     * @test
     */
    public function options_with_label_to_value() {
        $html = Form::options([1 => 'One', 2 => 'Two'], null, null, true);
        $this->assertContains('<option value="One">One</option>', $html);
        $this->assertContains('<option value="Two">Two</option>', $html);
    }

    /**
     * @test
     */
    public function select() {
        $html = Form::select('country', [1 => 'America', 2 => 'China']);
        $this->assertContains('name="country"', $html);
        $this->assertContains('id="country"', $html);
    }

    /**
     * @test
     */
    public function select_with_callback() {
        $html = Form::select('country', [1 => 'America', 2 => 'China'], null, null, "addListener()");
        $this->assertContains('onchange="return addListener();"', $html);
    }

    /**
     * @test
     */
    public function radio() {
        $html = Form::radio('sex', [1 => 'Male', 2 => 'Female']);
        $this->assertContains('<label class="radio">', $html);
        $this->assertContains('<input type="radio" name="sex" value="1">Male', $html);
        $this->assertContains('<input type="radio" name="sex" value="2">Female', $html);
    }

    /**
     * @test
     */
    public function radio_with_checked_key() {
        $html = Form::radio('sex', [0 => 'Male', 1 => 'Female'], 0);
        $this->assertContains('<label class="radio">', $html);
        $this->assertContains('<input type="radio" name="sex" value="0" checked>Male', $html);
        $this->assertContains('<input type="radio" name="sex" value="1">Female', $html);
    }

    /**
     * @test
     */
    public function radio_with_class() {
        $html = Form::radio('sex', [0 => 'Male', 1 => 'Female'], null, 'radio-inline');
        $this->assertContains('<label class="radio-inline">', $html);
    }

    /**
     * @test
     */
    public function checkbox() {
        $html = Form::checkbox('play[]', [0 => 'Football', 1 => 'Basketball', 2 => 'Swimming']);
        $this->assertContains('<label class="checkbox">', $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="0">Football', $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="1">Basketball', $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="2">Swimming', $html);
    }

    /**
     * @test
     */
    public function checkbox_with_checked_key() {
        $html = Form::checkbox('play[]', [0 => 'Football', 1 => 'Basketball', 2 => 'Swimming'], [0, 2]);
        $this->assertContains('<input type="checkbox" name="play[]" value="0" checked>Football', $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="1">Basketball', $html);
        $this->assertContains('<input type="checkbox" name="play[]" value="2" checked>Swimming', $html);
    }

    /**
     * @test
     */
    public function checkbox_with_class() {
        $html = Form::checkbox('play[]', [0 => 'Football', 1 => 'Basketball', 2 => 'Swimming'], [], 'checkbox-inline');
        $this->assertContains('<label class="checkbox-inline">', $html);
    }
}