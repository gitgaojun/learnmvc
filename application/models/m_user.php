<?php

defined("APPPATH") or exit("No direct script access allowed");

    /**
     * Class M_sign
     * 用于用户登录的操作
     */
    class M_user extends SR_Model
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
         * @return array
         */
        public function isUser( $uName, $uPwd )
        {
            //获取用户数据
            $data = $this->_db->query( " SELECT * FROM `l_use` WHERE u_name='" . $uName . "' and `u_pwd`='".$uPwd."'" );
            if ( empty($data) )
            {
                return $data;
            }
            ############更新用户数据#################################################################################
            $data = array(
                'u_lastip'      =>      $_SERVER['REMOTE_ADDR'],        // 用户登录ip
                'u_lasttime'    =>      date(time()),                   // 用户登录时间
                'u_sign_count'  =>      'u_sign_count+1'                // 登录次数
            );
            $wdata = array(
                'u_name'        =>      $uName,                         // 用户名
                'u_pwd'         =>      $uPwd                           // 用户密码
            );
            $this->_db->autoInsert($data, 'l_use', $wdata);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////

            //设置用户数据为session
            $_SESSION['user'] = $data['u_name'];
            $_SESSION['userId'] = $data['u_id'];
            return $data;
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
            $data = array(
                'u_name'    =>  $user_name,                 // 用户名
                'u_pwd'     =>  $user_pwd,                  // 用户密码
                'u_addtime' =>  date(time()),               // 注册时间
                'u_addip'   =>  $_SERVER['REMOTE_ADDR'],    // 浏览当前页面的用户ip地址
            );
            $insert_id = $this->_db->autoInsert( $data, 'l_use' );
            if(intval($insert_id) > 0)
            {
                $result['status'] = true;
            }
            return $result;
        }
    }