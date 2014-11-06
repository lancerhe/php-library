<?php
/**
* 数据分表算法 
*
* @category Library
* @package  Algorithm
* @author   Lancer He <lancer.he@gmail.com>
* @version  1.0 
*/
class Algorithm_Partition{

    /**
     * 根据Id分片
     * @access public
     * @static
     * 
     * @param  int     $id    id数量
     * @param  int     $num   分片数量10或者36,默认10
     * @return mixed          分片标识
     */
    public static function getIndexById($id, $num=10){
        if ( ! in_array( $num, array(10, 36) ) ) 
            trigger_error("Arithmetic_Partition::getPartitionById partition num only 10/36", E_USER_ERROR);

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