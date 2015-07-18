<?php
defined("APPPATH") or exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/4/22
 * Time: 10:29
 */

    class app extends SR_Controller
    {

        function __construct()
        {
            parent::__construct();
        }

        public function index()
        {


            $data['title'] = "Sparrow-shop";
            $data['u_name'] = isset($_SESSION['u_name'])?$_SESSION['u_name']:"游客";
            $data['u_id'] = isset($_SESSION['u_id'])?$_SESSION['u_id']:0;
            $this->vars($data);
            $this->view("app");
        }

    }