<?php
/**
 * Helper_Spell 汉字拼音首字母工具类
 *
 * @category Library
 * @package  Convert
 * @author   Lancer <lancer.he@gmail.com>
 * @version  1.0 
 * @see      Convert_Big2gb
 */
class Convert_Spell {

    /**
     * $_pinyins
     * @var array
     * @access private
     */
    private $_pinyins = array(
        176161 => 'A',
        176197 => 'B',
        178193 => 'C',
        180238 => 'D',
        182234 => 'E',
        183162 => 'F',
        184193 => 'G',
        185254 => 'H',
        187247 => 'J',
        191166 => 'K',
        192172 => 'L',
        194232 => 'M',
        196195 => 'N',
        197182 => 'O',
        197190 => 'P',
        198218 => 'Q',
        200187 => 'R',
        200246 => 'S',
        203250 => 'T',
        205218 => 'W',
        206244 => 'X',
        209185 => 'Y',
        212209 => 'Z',
        215249 => 'Z',
    );

    /**
     * $_charset
     * @var string
     * @access private
     */
    private $_charset = null;


    /**
     * __construct 构造函数, 指定需要的编码 default: utf-8 支持utf-8, gb2312
     *
     * @param unknown_type $charset
     */
    public function __construct( $charset = 'utf-8' ) {
        $this->_charset = $charset;
    }


    /**
     * 返回首个汉字的拼音
     * 
     * @access public
     * @param  string $str
     * @return string
     * @example $Spell->getFirstInitial('我的爱'); => w
     */
    public function getFirstInitial( $str, $big2gb=false ){
        $chars = array(
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','Q','R',
            'S','T','U','V','W','X',
            'Y','Z'
        );
        
        $string = $this->getInitials( $str, $big2gb );
        $length = strlen($string);

        for($i=0; $i < $length; $i++) 
            if ( in_array( $string{$i}, $chars ) ) 
                return $string{$i};

        return '*';
    }

    /**
     * 获取中文字串的拼音首字符 
     * 注：英文的字串：不变返回(包括数字)    eg. abc123 => abc123
     *     中文字符串：返回拼音首字符        eg. 王小明 => WXM
     *     中英混合串: 返回拼音首字符和英文  eg. 我i我j => WIWJ
     * 
     * @access public
     * @param  string $str
     * @return string
     */
    public function getInitials( $str, $big2gb=false ){
        if ( empty($str) ) return '';
        if ( $this->_isAscii($str[0]) && $this->_isAsciis( $str ))
            return $str;

        if ( $big2gb )
            $str = Convert_Big2gb::big2gb( $str );

        $result = array();
        if ( $this->_charset == 'utf-8' ){
            //IGNORE很重要，加上这个就可以是ICONV()函数忽略错误，继续执行
            $str = iconv( 'utf-8', 'gbk//IGNORE', $str );
        }
        $words = $this->_cutWord( $str );

        foreach ( $words AS $word ) {            
            if ( $this->_isAscii($word) ) {//非中文
                $result[] = $word;
                continue;
            }
            $code = ( ord(substr($word,0,1)) ) * 1000 + (ord(substr($word,1,1)));
            //获取拼音首字母A--Z 

            if ( ($i = $this->_search($code)) != -1 ){
                $result[] = $this->_pinyins[$i];
            }
        }
        return strtoupper(implode('', $result));
    }


    /**
     * _msubstr 获取中文字符串
     * 
     * @access private
     * @param string $str
     * @param int    $start
     * @param int    $len
     * @return string
     */
    private function _msubstr ($str, $start, $len) {
        $start  = $start * 2;
        $len    = $len * 2;
        $strlen = strlen($str);
        $result = '';
        for ( $i = 0; $i < $strlen; $i++ ) {
            if ( $i >= $start && $i < ($start + $len) ) {
                if ( ord(substr($str, $i, 1)) > 129 ) $result .= substr($str, $i, 2);
                else $result .= substr($str, $i, 1);
            }
            if ( ord(substr($str, $i, 1)) > 129 ) $i++;
        }
        return $result;
    }


    /**
     * _cutWord  字符串切分为数组 (汉字或者一个字符为单位)
     * 
     * @access private
     * @param string $str
     * @return array
     */
    private function _cutWord( $str ) {
        $words = array();
        while ( $str != "" ) {
            if ( $this->_isAscii($str) ) {//非中文
                $words[] = $str[0];
                $str = substr( $str, strlen($str[0]) );
            } else {
                $word = $this->_msubstr( $str, 0, 1 );
                $words[] = $word;
                $str = substr( $str,  strlen($word) );
            }
         }
         return $words;
    }


    /**
     * _isAscii 判断字符是否是ascii字符
     * 
     * @access private
     * @param  string $char
     * @return bool
     */
    private function _isAscii( $char ) {
        return ( ord( substr($char,0,1) ) < 160 );
    }


    /**
     * _isAsciis 判断字符串前3个字符是否是ascii字符
     * 
     * @access private
     * @param  string $str
     * @return bool
     */
    private function _isAsciis( $str ) {
        $len = strlen($str) >= 3 ? 3: 2;
        $chars = array();
        for( $i = 1; $i < $len -1; $i++ ){
            $chars[] = $this->_isAscii( $str[$i] ) ? 'yes':'no';
        }
        $result = array_count_values( $chars );
        if ( empty($result['no']) ){
            return true;
        }
        return false;
    }


    
    /**
     * _getChar 通过ASC码返回字母或者数字
     * 
     * @access private
     * @param  string $ascii
     * @return string
     */
    // private function _getChar( $ascii ){
    //     if ( $ascii >= 48 && $ascii <= 57 ) {
    //         return chr($ascii);  //数字
    //     } elseif ( $ascii>=65 && $ascii<=90 ) {
    //         return chr($ascii);   // A--Z
    //     } elseif ($ascii>=97 && $ascii<=122 ) {
    //         return chr($ascii-32); // a--z
    //     } else {
    //         return '~'; //其他
    //     }
    // }


    /**
     * _search 查找需要的汉字内码(gb2312) 对应的拼音字符(二分法)
     * 
     * @access private
     * @param int $code
     * @return int
     */
    private function _search( $code ) {    	
        $data = array_keys($this->_pinyins);
      
        $lower = 0;
        $upper = sizeof($data)-1;
        
        // 排除非一级汉字
        if ($code < $data[0] || $code > $data[23]) return -1;
       
        for (;;) {        	
            if ( $lower > $upper ){              
            	return $data[$lower-1];
            }
            $middle = (int) round(($lower + $upper) / 2);
            if ( !isset($data[$middle]) ) {           
            	return -1;
            }
          
            if ( $data[$middle] < $code ){
                $lower = (int)$middle + 1;
            } else if ( $data[$middle] == $code ) {            
                return $data[$middle];
            } else {
                $upper = (int)$middle - 1;
            }
        }// end for
    }
}
?>