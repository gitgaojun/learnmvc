<?php
defined("APPPATH") or exit("No direct script access allowed");

/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/5/7
 * Time: 18:30
 */

    class M_login extends SR_Model
    {
        function __construct()
        {
            parent::__construct();
            $this->_db = $this->load->database("learnmvc");
        }

        /**
         * 判断用户是否存在如果存在那么就返回一个列表并且在里面中写入session数组保存
         * @param $uName string
         * @param $uPwd sting
         * @return $data array
         */
        public function isUser( $uName, $uPwd )
        {
            //获取用户数据
            $data = $this->_db->query( " SELECT * FROM `l_use` WHERE u_name='" . $uName . "' and `u_pwd`='".$uPwd."'" );
            if ( empty($data) )
            {
                return $data;
            }
            //设置用户数据为session
            $_SESSION['user'] = $data['u_name'];
            $_SESSION['userId'] = $data['u_id'];
            return $data;
        }


    }