<?php
/**
 * Util_Page
 *
 * @category Library
 * @package  Util
 * @author   Lancer <lancer.he@gmail.com>
 * @version  1.0 
 */
class Util_Page{

    private $_current_page; //当前页

    private $_current_url; //当前URL

    private $_total_num; //总记录数

    private $_pagesize = 10; //每页显示数目

    private $_pagelen = 5; //页面显示数目(长度)

    private $_pageclass = 'pagination'; //所用分页样式类名

    private $_pagestring; //分页HTML字符串

    private $_total_pages; //总页数

    private $_pageoffset = 3; //页数偏移量

    public $next_page  = '&gt;';

    public $last_page  = '&gt;&gt;';

    public $prev_page  = '&lt;';

    public $first_page = '&lt;&lt;';
    
    public function setCurrentPage($page) {
        $this->_current_page = intval($page);
    }

    public function setTotalNum($num) {
        $this->_total_num = intval($num);
    }

    public function setPageSize($pagesize) {
        $this->_pagesize = intval($pagesize);
    }

    public function setCurrentUrl($current_url='') {
        if ( ! $current_url) {
            $current_url = $_SERVER["REQUEST_URI"];
            $parse_url   = parse_url($current_url);

            if ( isset($parse_url["query"]) ) {
                $urlquery  = preg_replace("/(^|&)page={$this->_current_page}/", "", $parse_url["query"]);
                $urlquery  = preg_replace("/(^|&)page=/", "", $urlquery);
                $current_url = str_replace($parse_url["query"], $urlquery, $current_url);   

                if($urlquery) $current_url.="&page=";
                else $current_url.="page=";
            } else {
                $current_url.="?page=";
            }
            $this->_current_url = $current_url;
        } else {
            $this->_current_url = rtrim($current_url, '/') . '/';
        }
    }

    public function output() {
        if ( ! $this->_current_url ) {
            $this->setCurrentUrl();
        }
        
        $this->_caculateParam();
        $this->_buildOutput();
        return $this->_pagestring;
    }


    private function _caculateParam() {
        if (!$this->_total_num) return array();

        $this->_total_pages = ceil($this->_total_num / $this->_pagesize);

        $this->_current_page < 1 && $this->_current_page = 1;
        $this->_current_page > $this->_total_pages && $this->_current_page = $this->_total_pages;

        //Make sure _pagelen is odd number.
        $this->_pagelen = $this->_pagelen % 2 ? $this->_pagelen : $this->_pagelen + 1;
        $this->_pageoffset = ($this->_pagelen - 1) / 2;
    }


    private function _buildOutput() {
        $this->_pagestring = $this->_pageclass ? '<div class="' . $this->_pageclass . '">' : '<div>';
        $this->_pagestring.= '<ul>';
        $this->_buildOutputPageList();
        $this->_pagestring .= '</ul></div>';
    }

    private function _buildOutputPageList() {
        $pagemin = 1;
        $pagemax = $this->_total_pages;
        
        if( $this->_current_page != 1 ) {
            $prev = $this->_current_page-1 > 1 ? $this->_current_page-1 : 1;
            $this->_pagestring .= "<li><a href=\"{$this->_current_url}1\">".$this->first_page."</a></li>
            <li><a href=\"{$this->_current_url}".$prev."\">".$this->prev_page."</a></li>";
        } else {
            $this->_pagestring .= "<li class=\"disabled\"><a href=\"javascript:;\">".$this->first_page."</a></li>
            <li class=\"disabled\"><a href=\"javascript:;\">".$this->prev_page."</a></li>";
        }
        
        //Ensure page offset number
        if($this->_total_pages > $this->_pagelen){
            if ($this->_current_page <= $this->_pageoffset) {
                $pagemin = 1;
                $pagemax = $this->_pagelen;
            } else {
                if($this->_current_page + $this->_pageoffset >= $this->_total_pages + 1){
                    $pagemin = $this->_total_pages - $this->_pagelen + 1;
                    $pagemax = $this->_total_pages;
                } else {
                    $pagemin = $this->_current_page - $this->_pageoffset;
                    $pagemax = $this->_current_page + $this->_pageoffset;
                }
            }
        }

        for($i = $pagemin; $i <= $pagemax; $i++){
            if($i == $this->_current_page){
                $this->_pagestring .= '<li class="active"><a href="javascript:;">'.$i.'</a></li>';
            } else {
                $this->_pagestring .= "<li><a href=\"{$this->_current_url}{$i}\">$i</a></li>";
            }
        }

        if( $this->_current_page != $this->_total_pages){
            $next = $this->_current_page+1 > $this->_total_pages ? $this->_total_pages : $this->_current_page+1;
            $this->_pagestring .= "
                <li><a href=\"{$this->_current_url}". $next ."\">".$this->next_page."</a></li>
                <li><a href=\"{$this->_current_url}{$this->_total_pages}\">".$this->last_page."</a></li>";
        } else {
            $this->_pagestring .= "
                <li class=\"disabled\"><a href=\"javascript:;\">".$this->next_page."</a></li>
                <li class=\"disabled\"><a href=\"javascript:;\">".$this->last_page."</a></li>";
        }
    }

}