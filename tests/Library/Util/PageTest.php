<?php
/**
 * Page Library Test
 * @author Lancer He <lancer.he@gmail.com>
 * @since  2014-11-04
 */

namespace Library\Tests\Util;

use Library\Util\Page;

class PageTest extends \PHPUnit_Framework_TestCase {

    public function setUp() {
        $_SERVER["REQUEST_URI"] = 'http://127.0.0.1/list?action=1&tid=2';
    }

    /**
     * @test
     */
    public function FirstPageOutput() {
        $page   = new Page();
        $page->setCurrentPage(1);
        $page->setTotalNum(200);
        $page->setPageSize(10);
        $output = $page->output();
        $this->assertContains('<li class="disabled"><a href="javascript:;">&lt;&lt;</a></li>', $output);
        $this->assertContains('<li class="disabled"><a href="javascript:;">&lt;</a></li>', $output);
        $this->assertContains('<li class="active"><a href="javascript:;">1</a></li>', $output);
        $this->assertNotContains('<li class="disabled"><a href="javascript:;">&gt;&gt;</a></li>', $output);
        $this->assertNotContains('<li class="disabled"><a href="javascript:;">&gt;</a></li>', $output);
    }

    /**
     * @test
     */
    public function LastPageOutput() {
        $page   = new Page();
        $page->setCurrentPage(20);
        $page->setTotalNum(200);
        $page->setPageSize(10);
        $output = $page->output();
        $this->assertContains('<li class="disabled"><a href="javascript:;">&gt;&gt;</a></li>', $output);
        $this->assertContains('<li class="disabled"><a href="javascript:;">&gt;</a></li>', $output);
        $this->assertContains('<li class="active"><a href="javascript:;">20</a></li>', $output);
        $this->assertNotContains('<li class="disabled"><a href="javascript:;">&lt;&lt;</a></li>', $output);
        $this->assertNotContains('<li class="disabled"><a href="javascript:;">&lt;</a></li>', $output);
    }


    /**
     * @test
     */
    public function CenterPageOutput() {
        $page   = new Page();
        $page->setCurrentPage(10);
        $page->setTotalNum(200);
        $page->setPageSize(10);
        $output = $page->output();
        $this->assertNotContains('<li class="disabled"><a href="javascript:;">&gt;&gt;</a></li>', $output);
        $this->assertNotContains('<li class="disabled"><a href="javascript:;">&gt;</a></li>', $output);
        $this->assertContains('<li class="active"><a href="javascript:;">10</a></li>', $output);
        $this->assertNotContains('<li class="disabled"><a href="javascript:;">&lt;&lt;</a></li>', $output);
        $this->assertNotContains('<li class="disabled"><a href="javascript:;">&lt;</a></li>', $output);
    }

    /**
     * @test
     */
    public function PageOutputWithCustomUrl() {
        $page   = new Page();
        $page->setCurrentPage(10);
        $page->setTotalNum(200);
        $page->setPageSize(10);
        $page->setCurrentUrl("http://127.0.0.1/list/");
        $output = $page->output();
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/1">&gt;&gt;</a></li>', $output);
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/1">&gt;</a></li>', $output);
        $this->assertContains('<li class="active"><a href="javascript:;">10</a></li>', $output);
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/20">&lt;&lt;</a></li>', $output);
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/20">&lt;</a></li>', $output);
    }


    /**
     * @test
     */
    public function PageOutputWithUrlNoParamter() {
        $_SERVER["REQUEST_URI"] = 'http://127.0.0.1/list';
        $page   = new Page();
        $page->setCurrentPage(10);
        $page->setTotalNum(200);
        $page->setPageSize(10);
        $output = $page->output();
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/?page=1">&gt;&gt;</a></li>', $output);
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/?page=1">&gt;</a></li>', $output);
        $this->assertContains('<li class="active"><a href="javascript:;">10</a></li>', $output);
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/?page=20">&lt;&lt;</a></li>', $output);
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/?page=20">&lt;</a></li>', $output);
    }


    /**
     * @test
     */
    public function PageOutputWithUrlPageParamter() {
        $_SERVER["REQUEST_URI"] = 'http://127.0.0.1/list?page=10';
        $page   = new Page();
        $page->setCurrentPage(10);
        $page->setTotalNum(200);
        $page->setPageSize(10);
        $output = $page->output();
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/?page=1">&gt;&gt;</a></li>', $output);
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/?page=1">&gt;</a></li>', $output);
        $this->assertContains('<li class="active"><a href="javascript:;">10</a></li>', $output);
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/?page=20">&lt;&lt;</a></li>', $output);
        $this->assertNotContains('<li><a href="http://127.0.0.1/list/?page=20">&lt;</a></li>', $output);
    }
}