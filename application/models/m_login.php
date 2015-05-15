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

        public function isUser( $uName, $uPwd )
        {
            $data = $this->_db->query("select * from l_use");
            echo json_encode($data);exit;
        }


    }