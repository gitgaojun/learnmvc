<?php
defined("APPPATH") or exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/8/3
 * Time: 17:18
 */

    /**
     * Class B_user
     * 用户控制器的基类
     *
     * @since 2015-8-3
     * @author jun
     * @package B_user
     */
    class B_user extends SR_Controller
    {
        protected $is_user;

        function __construct()
        {
            parent::__construct();

            if( isset($_SESSION['user']) )
            {
                $this->load->model('M_user');
                $this->is_user = $this->M_user->isUse($_SESSION['user']);
            }

            var_dump($this->is_user);exit;
        }



    }