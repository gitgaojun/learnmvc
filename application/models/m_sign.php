<?php

defined("APPPATH") or exit("No direct script access allowed");

    /**
     * Class M_sign
     * 用于用户登录的操作
     */
    class M_sign extends SR_Model
    {
        function __construct()
        {
            parent::__construct();
            $this->_db = $this->load->database("learnmvc");
        }


        /**
         * 注册用户数据入库
         * @author jun
         * @access public
         * @param string $user_name 用户名
         * @param string $user_pwd 用户密码
         * @return array
         */
        public function signOn( $user_name , $user_pwd )
        {
            $result = array('status'=>false, 'msg'=>'', 'code'=>10088, 'data'=>array());
            $this->_db->insert();
            return $result;
        }
    }