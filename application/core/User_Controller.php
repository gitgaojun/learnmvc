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
    class User_Controller extends SR_Controller
    {
        protected $is_user=false;

        function __construct()
        {
            parent::__construct();
            global $_fun_name;

            if( isset($_SESSION['user']) )
            {
                $this->load->model('M_user');
                $this->is_user = $this->M_user->isUse($_SESSION['user']);
            }

            ###########需要登录才能访问的页面#######################################################
            $login_fun = array('Home');
            if( in_array( $_fun_name, $login_fun, true ) )
            {
                if( !$this->is_user )
                {
                     echo '<script>window.location.href="/user/index.html";</script>';
                }
            }
            //////////////////////////////////////////////////////////////////////////////////////


        }



    }