<?php
/**
 * 数据分表算法
 *
 * @category Library
 * @package  Algorithm
 * @author   Lancer He <lancer.he@gmail.com>
 * @version  1.0
 */

namespace Library\Algorithm;

class Partition{

    /**
     * 根据位数进行分片，适用于整形，如按照千位数分片 [10000, 19999] => 10
     * @access public
     * @static
     * 
     * @param  int     $id     id
     * @param  int     $figure default 1000  按照千位数分片
     * @return mixed          分片标识
     */
    public static function getIndexByFigure($id, $figure = 1000) {
        if ( 0 != $figure % 10 || $figure <= 0) 
            trigger_error("Arithmetic_Partition::getIndexByFigure figure needs to be divisible by 10.", E_USER_ERROR);

        return intval($id / $figure);
    }

    /**
     * 根据Id分片，适用于整形/哈希值
     * @access public
     * @static
     * 
     * @param  int     $id    id数量
     * @param  int     $num   分片数量10或者36,默认10
     * @return mixed          分片标识
     */
    public static function getIndexById($id, $num = 10){
        if ( ! in_array( $num, array(10, 36) ) ) 
            trigger_error("Arithmetic_Partition::getPartitionById partition num only 10/36.", E_USER_ERROR);

        switch($num){
            case 10: 
                $partitions = array(
                    '0','1','2','3','4','5','6','7','8','9'
                );break;
            case 36:
                $partitions = array(
                    '0','1','2','3','4','5','6','7','8','9',
                    'A','B','C','D','E','F','G','H','I','J','K','L','M',
                    'N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
                );
                break;
        }
        $md5 = md5($id);
        $key = (ord($md5[0]) + ord($md5[1]) + ord($md5[2])) % $num;
        
        return $partitions[$key];
    }
}