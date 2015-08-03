<?php
defined("APPPATH") or exit("No direct script access allowed");
/**
 * Created by PhpStorm.
 * User: jun90610@gmail.com
 * Date: 2015/6/5
 * Time: 14:07
 */

    /**
     * Class test
     * 为了测试索引的效果，动态的插入数据1千万来测试
     *
     * @since 2015-8-3
     * @author jun
     * @package test
     * @link    http://www.sparrow.com/test/index.html
     */
    class test extends SR_Controller{

        function __construct()
        {
            parent::__construct();
            $this->load->model("M_test");
        }

        /**
         * 插入数据 一千万 条
         *
         * @since 2015-8-3
         * @author jun
         * @access public
         * @return void
         */
        public function index()
        {
            $result = $this->M_test->inser();
            $data['result']=$result===true?'成功插入1千万条数据':'制造数据失败';
            $this->vars($data);
            $this->view("test");
        }

        /**
         * 得到sql 查询的时间
         *
         * @since 2015-8-3
         * @author jun
         * @access public
         * @return void
         */
        public function getTime()
        {
            $result = $this->M_test->getTime();
            $data['result'] = $result;
            $this->vars($data);
            $this->view('test');//用时   2.5381450653076
            // 添加索引  x_addtime 后用时  0.0040011405944824
        }





    }