<?php
namespace LancerHe\Library\Tests\Convert;

use LancerHe\Library\Convert\Spell;

/**
 * Class SpellTest
 *
 * @package LancerHe\Library\Tests\Convert
 * @author  Lancer He <lancer.he@gmail.com>
 */
class SpellTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function letter_will_spell_letter() {
        $Spell    = new Spell();
        $initials = $Spell->getInitials('abc123');
        $this->assertEquals('abc123', $initials);
    }

    /**
     * @test
     */
    public function chinese_spell_first_letter() {
        $Spell    = new Spell();
        $initials = $Spell->getInitials('王小明');
        $this->assertEquals('WXM', $initials);
    }

    /**
     * @test
     */
    public function traditional_chinese_spell_letter() {
        $Spell    = new Spell();
        $initials = $Spell->getInitials('間夢', true);
        $this->assertEquals('JM', $initials);
    }

    /**
     * @test
     */
    public function letter_with_chinese_spell_letter() {
        $Spell    = new Spell();
        $initials = $Spell->getInitials('我i我j');
        $this->assertEquals('WIWJ', $initials);
    }

    /**
     * @test
     */
    public function special_char_spell_self() {
        $Spell    = new Spell();
        $initials = $Spell->getInitials('*&^^');
        $this->assertEquals('*&^^', $initials);
    }

    /**
     * @test
     */
    public function letter_with_chinese_spell_first_letter() {
        $Spell    = new Spell();
        $initials = $Spell->getFirstInitial('我i我j');
        $this->assertEquals('W', $initials);
    }

    /**
     * @test
     */
    public function japanese_with_chinese_spell_all() {
        $Spell    = new Spell();
        $initials = $Spell->getFirstInitial('はのの');
        $this->assertEquals('*', $initials);
    }
}