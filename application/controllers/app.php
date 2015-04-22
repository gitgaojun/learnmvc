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

            $this->vars($data);
            $this->view("app");
        }

    }