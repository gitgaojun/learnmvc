<?php
defined("APPPATH") or exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/6/5
 * Time: 14:14
 */


    class M_test extends SR_Model
    {
        function __construct()
        {
            parent::__construct();
            $this->_db = $this->load->database("test");
        }


        /**
         * 插入数据用来测试
         * @return bool
         */
        public function inser()
        {
            ini_set('max_execution_time', '31536000');//关闭php的执行时间,设置1年超时
            for($i=1;$i < 10000001; $i++ )
            {
                $this->_db->into("insert into `b_xiangce`(`uid`, `x_info`, `x_addtime`) values('2', '美好时光', now())");
            }
            if($i===10000001)
            {
                return true;
            }else{
                return false;
            }

        }

        /**
         * 不使用索引的查询
         * @return int
         */
        public function getTime()
        {
            $old_time = $this->getMircoTime();
            $this->_db->query("select * from `b_xiangce` order by x_addtime limit 0,100");
            $use_time = $this->getMircoTime()-$old_time;
            return $use_time;
        }


        /**
         * 得到毫秒级的时间
         * @return float
         */
        public function getMircoTime()
        {
            list($usec, $sec) = explode(" ", microtime());
            return ((float)$usec+(float)$sec);
        }

    }