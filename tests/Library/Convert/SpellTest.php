<?php
/**
 * Convert_Spell Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-11-06
 */

namespace Library\Tests\Convert;

use Library\Convert\Spell;

class SpellTest extends \PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getInitialsWithLetter() {
        $Spell = new Spell();
        $initials = $Spell->getInitials('abc123');
        $this->assertEquals('abc123', $initials);
    }

    /**
     * @test
     */
    public function getInitialsWithChinese() {
        $Spell = new Spell();
        $initials = $Spell->getInitials('王小明');
        $this->assertEquals('WXM', $initials);
    }

    /**
     * @test
     */
    public function getInitialsWithTraditionalChinese() {
        $Spell = new Spell();
        $initials = $Spell->getInitials('間夢', true);
        $this->assertEquals('JM', $initials);
    }

    /**
     * @test
     */
    public function getInitialsWithChineseAndLetter() {
        $Spell = new Spell();
        $initials = $Spell->getInitials('我i我j');
        $this->assertEquals('WIWJ', $initials);
    }

    /**
     * @test
     */
    public function getInitialsWithSpecial() {
        $Spell = new Spell();
        $initials = $Spell->getInitials('*&^^');
        $this->assertEquals('*&^^', $initials);
    }

    /**
     * @test
     */
    public function getFirstInitialWithCorrect() {
        $Spell = new Spell();
        $initials = $Spell->getFirstInitial('我i我j');
        $this->assertEquals('W', $initials);
    }

    /**
     * @test
     */
    public function getFirstInitialWithNothing() {
        $Spell = new Spell();
        $initials = $Spell->getFirstInitial('はのの');
        $this->assertEquals('*', $initials);
    }
}