<?php
namespace LancerHe\Library\Util;

/**
 * Class Page
 *
 * @package LancerHe\Library\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
/**
 * Class Page
 *
 * @package LancerHe\Library\Util
 * @author  Lancer He <lancer.he@gmail.com>
 */
class Page {
    /**
     * @var int
     */
    protected $_currentPage; //当前页
    /**
     * @var string
     */
    protected $_currentUrl; //当前URL
    /**
     * @var int
     */
    protected $_totalNum; //总记录数
    /**
     * @var int
     */
    protected $_pageSize = 10; //每页显示数目
    /**
     * @var int
     */
    protected $_pageLen = 5; //页面显示数目(长度)
    /**
     * @var string
     */
    protected $_pageClass = 'pagination'; //所用分页样式类名
    /**
     * @var string
     */
    protected $_pageHtml; //分页HTML字符串
    /**
     * @var int
     */
    protected $_totalPage; //总页数
    /**
     * @var int
     */
    protected $_pageOffset = 3; //页数偏移量
    /**
     * @var string
     */
    public $nextPageLabel = '&gt;';
    /**
     * @var string
     */
    public $lastPageLabel = '&gt;&gt;';
    /**
     * @var string
     */
    public $prevPageLabel = '&lt;';
    /**
     * @var string
     */
    public $firstPageLabel = '&lt;&lt;';

    /**
     * @param $page
     */
    public function setCurrentPage($page) {
        $this->_currentPage = intval($page);
    }

    /**
     * @param $num
     */
    public function setTotalNum($num) {
        $this->_totalNum = intval($num);
    }

    /**
     * @param $pageSize
     */
    public function setPageSize($pageSize) {
        $this->_pageSize = intval($pageSize);
    }

    /**
     * @param string $currentUrl
     */
    public function setCurrentUrl($currentUrl = '') {
        if ( ! $currentUrl ) {
            $currentUrl = $_SERVER["REQUEST_URI"];
            $parseUrl   = parse_url($currentUrl);
            if ( isset($parseUrl["query"]) ) {
                $urlQuery   = preg_replace("/(^|&)page={$this->_currentPage}/", "", $parseUrl["query"]);
                $urlQuery   = preg_replace("/(^|&)page=/", "", $urlQuery);
                $currentUrl = str_replace($parseUrl["query"], $urlQuery, $currentUrl);
                if ( $urlQuery ) $currentUrl .= "&page=";
                else $currentUrl .= "page=";
            } else {
                $currentUrl .= "?page=";
            }
            $this->_currentUrl = $currentUrl;
        } else {
            $this->_currentUrl = rtrim($currentUrl, '/') . '/';
        }
    }

    /**
     * @return mixed
     */
    public function output() {
        if ( ! $this->_currentUrl ) {
            $this->setCurrentUrl();
        }
        $this->_caculateParam();
        $this->_buildOutput();
        return $this->_pageHtml;
    }

    /**
     * @return array
     */
    private function _caculateParam() {
        if ( ! $this->_totalNum ) return [];
        $this->_totalPage = ceil($this->_totalNum / $this->_pageSize);
        $this->_currentPage < 1 && $this->_currentPage = 1;
        $this->_currentPage > $this->_totalPage && $this->_currentPage = $this->_totalPage;
        //Make sure pageLen is odd number.
        $this->_pageLen    = $this->_pageLen % 2 ? $this->_pageLen : $this->_pageLen + 1;
        $this->_pageOffset = ($this->_pageLen - 1) / 2;
    }

    /**
     *
     */
    private function _buildOutput() {
        $this->_pageHtml = $this->_pageClass ? '<div class="' . $this->_pageClass . '">' : '<div>';
        $this->_pageHtml .= '<ul>';
        $this->_buildOutputPageList();
        $this->_pageHtml .= '</ul></div>';
    }

    /**
     *
     */
    private function _buildOutputPageList() {
        $pageMin = 1;
        $pageMax = $this->_totalPage;
        if ( $this->_currentPage != 1 ) {
            $prev = $this->_currentPage - 1 > 1 ? $this->_currentPage - 1 : 1;
            $this->_pageHtml .= "<li><a href=\"{$this->_currentUrl}1\">" . $this->firstPageLabel . "</a></li>
            <li><a href=\"{$this->_currentUrl}" . $prev . "\">" . $this->prevPageLabel . "</a></li>";
        } else {
            $this->_pageHtml .= "<li class=\"disabled\"><a href=\"javascript:;\">" . $this->firstPageLabel . "</a></li>
            <li class=\"disabled\"><a href=\"javascript:;\">" . $this->prevPageLabel . "</a></li>";
        }
        //Ensure page offset number
        if ( $this->_totalPage > $this->_pageLen ) {
            if ( $this->_currentPage <= $this->_pageOffset ) {
                $pageMin = 1;
                $pageMax = $this->_pageLen;
            } else {
                if ( $this->_currentPage + $this->_pageOffset >= $this->_totalPage + 1 ) {
                    $pageMin = $this->_totalPage - $this->_pageLen + 1;
                    $pageMax = $this->_totalPage;
                } else {
                    $pageMin = $this->_currentPage - $this->_pageOffset;
                    $pageMax = $this->_currentPage + $this->_pageOffset;
                }
            }
        }
        for ( $i = $pageMin; $i <= $pageMax; $i ++ ) {
            if ( $i == $this->_currentPage ) {
                $this->_pageHtml .= '<li class="active"><a href="javascript:;">' . $i . '</a></li>';
            } else {
                $this->_pageHtml .= "<li><a href=\"{$this->_currentUrl}{$i}\">$i</a></li>";
            }
        }
        if ( $this->_currentPage != $this->_totalPage ) {
            $next = $this->_currentPage + 1 > $this->_totalPage ? $this->_totalPage : $this->_currentPage + 1;
            $this->_pageHtml .= "
                <li><a href=\"{$this->_currentUrl}" . $next . "\">" . $this->nextPageLabel . "</a></li>
                <li><a href=\"{$this->_currentUrl}{$this->_totalPage}\">" . $this->lastPageLabel . "</a></li>";
        } else {
            $this->_pageHtml .= "
                <li class=\"disabled\"><a href=\"javascript:;\">" . $this->nextPageLabel . "</a></li>
                <li class=\"disabled\"><a href=\"javascript:;\">" . $this->lastPageLabel . "</a></li>";
        }
    }
}