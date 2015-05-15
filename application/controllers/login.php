<?php
defined("APPPATH") or exit("No direct script access allowed");

/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/4/25
 * Time: 10:31
 */

    /**
     * 登录类
     */
    class login extends SR_Controller
    {
        function __construct()
        {
            parent::__construct();

        }

        public function index()
        {
            $data['title'] = "Sparrow-login 登录页面";
            $this->vars($data);
            $this->view("login");
        }

        /**
         * 验证用户信息是否合格
         */
        public function isUser()
        {
            $result = array("status"=>false, "code"=>10000, "msg"=>"");
            $uName  =   empty($_POST["uName"])?"":addslashes(trim($_POST["uName"]));
            $uPwd   =   empty($_POST["uPwd"])?"":addslashes(trim($_POST["uPwd"]));
            $uCode  =   empty($_POST["uCode"])?"":addslashes(trim($_POST["uCode"]));
            $uPwd = md5($uPwd);

            if($uName == "")
            {
                $result["msg"] = "用户名不能为空";
                exit(json_encode($result));
            }
            if($uPwd == "")
            {
                $result["msg"] = "密码不能为空";
                exit(json_encode($result));
            }
            if($uCode == "")
            {
                $result["msg"] = "验证码不能为空";
                exit(json_encode($result));
            }
            if(strtolower($uCode) != strtolower($_SESSION["adCodeText"]))
            {
                $result["msg"] = "验证码填写错误";
                exit(json_encode($result));
            }
            $this->load->model("M_login");
            $result['data'] = $userList = $this->M_login->isUser($uName, $uPwd);
            if(empty($userList))
            {
                $result['msg'] = "用户名或密码错误";
                exit(json_encode($result));
            }
            $result['status'] = true;
            exit(json_encode($result));
        }

        /**
         * 验证码
         */
        public function adCode()
        {
            $this->load->helper('code_helper');
            codeImage(200,50,"adCodeText");
            //  $_SESSION['adCodeText']   采用原生的session , adCodeText 是验证码的 键值名

            exit;

        }

    }