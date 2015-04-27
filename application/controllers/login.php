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

    }