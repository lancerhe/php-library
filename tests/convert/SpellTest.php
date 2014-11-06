<?php
/**
 * Convert_Spell Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-11-06
 */
require_once dirname(__FILE__) . '/../../libraries/convert/Spell.php';
require_once dirname(__FILE__) . '/../../libraries/convert/Big2gb.php';

class Convert_SpellTest extends PHPUnit_Framework_TestCase {

    /**
     * @test
     */
    public function getInitialsWithLetter() {
        $Spell = new Convert_Spell();
        $initials = $Spell->getInitials('abc123');
        $this->assertEquals('abc123', $initials);
    }

    /**
     * @test
     */
    public function getInitialsWithChinese() {
        $Spell = new Convert_Spell();
        $initials = $Spell->getInitials('王小明');
        $this->assertEquals('WXM', $initials);
    }

    /**
     * @test
     */
    public function getInitialsWithTraditionalChinese() {
        $Spell = new Convert_Spell();
        $initials = $Spell->getInitials('間夢', true);
        $this->assertEquals('JM', $initials);
    }

    /**
     * @test
     */
    public function getInitialsWithChineseAndLetter() {
        $Spell = new Convert_Spell();
        $initials = $Spell->getInitials('我i我j');
        $this->assertEquals('WIWJ', $initials);
    }

    /**
     * @test
     */
    public function getInitialsWithSpecial() {
        $Spell = new Convert_Spell();
        $initials = $Spell->getInitials('*&^^');
        $this->assertEquals('*&^^', $initials);
    }

    /**
     * @test
     */
    public function getFirstInitialWithCorrect() {
        $Spell = new Convert_Spell();
        $initials = $Spell->getFirstInitial('我i我j');
        $this->assertEquals('W', $initials);
    }

    /**
     * @test
     */
    public function getFirstInitialWithNothing() {
        $Spell = new Convert_Spell();
        $initials = $Spell->getFirstInitial('はのの');
        $this->assertEquals('*', $initials);
    }
}